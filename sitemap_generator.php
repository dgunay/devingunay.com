<?php

/**
 * Recursively generates a sitemap of devingunay.com
 * 
 * TODO: does it really get all the links? Why doesn't it follow outside
 * the domain?
 * 
 * @author Devin Gunay <devingunay@gmail.com>
 */

////////////////////
// Configuration
////////////////////
define('BASE_URL', 'http://devingunay.com');

// flag for echoing output of the URLs crawled.
$OUTPUT_URLS = false;

/////////////////////
// Execution Flow
/////////////////////
$sitemap = array();
crawl_rewrite($sitemap, BASE_URL);

// print_r($sitemap);
// exit;

if ($OUTPUT_URLS) {
	foreach($sitemap as $url => $html) {
		echo $url . PHP_EOL;
	}
}
else {
	// build XML
	$xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
	$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
	foreach($sitemap as $url) {
		$xml .= "\t" . '<url>' . PHP_EOL;
		$xml .= "\t\t" . '<loc>' . htmlspecialchars($url, ENT_XML1, 'UTF-8') . '</loc>' . PHP_EOL;
		$xml .= "\t" . '</url>' . PHP_EOL;
	}
	$xml .= '</urlset>';
	
	file_put_contents('/var/www/html/sitemap.xml', $xml);
}



/////////////////
// Functions
/////////////////

/**
 * Generates an associative array of unique pages on the website by recursively
 * crawling all the links on each page.
 * 
 * Uniqueness is checked by keying the contents of each page to a URL. This
 * will break if I introduce dynamic content in the future, but that's ok for
 * now since the site is static and I wrote this in like half an hour.
 * 
 * It also doesn't scale well since the contents of the entire website will
 * be stored in RAM by the end. Overall, would not recommend using this on a
 * large website.
 *
 * @param array $visited_links
 * @param string $link
 * @return array Associative array of each unique page URL and its contents.
 */
function crawl(array &$visited_links, string $link) {
	$html = @file_get_contents($link);

	if ($html === false || isset(array_flip($visited_links)[$html])) {
		return $visited_links;
	}

	$visited_links[$link] = $html;

	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$x = new DOMXPath($dom);

	$all_links_nodelist = $x->query("//a/@href");
	if ($all_links_nodelist->length > 0) {
		// recurse
		foreach ($all_links_nodelist as $node) {
			$link = BASE_URL . $node->nodeValue;
			if (!in_array($link, $visited_links)) {
				$visited_links = crawl($visited_links, $link);
			}
		}
	} 

	return $visited_links;
}

function crawl_rewrite(array &$visited_links, string $link) {
	$html = @file_get_contents($link);
	
	if ($html === false) {
		return $visited_links;
	}

	$visited_links[] = $link;

	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$x = new DOMXPath($dom);

	$all_links_nodelist = $x->query("//a/@href");
	if ($all_links_nodelist->length > 0) {
		// recurse
		foreach ($all_links_nodelist as $node) {
			$link = BASE_URL . $node->nodeValue;
			if (!in_array($link, $visited_links)) {
				$visited_links = crawl_rewrite($visited_links, $link);
			}
		}
	} 

	return $visited_links;
}
