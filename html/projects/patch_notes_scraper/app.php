<?php

// collect patch number
if (isset($argv[1])) {
    $patch_number = $argv[1];
} elseif (isset($_GET['patchnumber']) && $_GET['patchnumber'] !== '') {
    $patch_number = $_GET['patchnumber'];
}

// validate patch number
if (!is_numeric($patch_number) || empty($patch_number)) {
    echo 'Please provide a patch number in the URL.' . PHP_EOL;
    exit;
}

// Remove periods from argument
$patch_number = str_replace('.', '', $patch_number);

// Crawl the data from the patch
crawl_patch($patch_number);

// http://eune.leagueoflegends.com/en/news/game-updates/patch/patch-715-notes

function crawl_patch($patch_number)
{
    // create an array of xpaths for the sections you need/want
    $field_xpaths = array(
        'title'             => "div/div/h3",
        'summary'           => "div/div/p[@class='summary']",
        'explanation'       => "div/div/blockquote",
        'bulletpoints'      => "div/div/ul/li",
        // 'abilities'		=> "div/div/h4[contains(@class,'ability-title')]"
    );

    if (strpos($patch_number, '.') !== false) {
        throw new Exception('Patch number must not contain a period (.)');
    }

    $url = "http://eune.leagueoflegends.com/en/news/game-updates/patch/patch-$patch_number-notes";

    $ch = setup_curl_resource();
    curl_setopt($ch, CURLOPT_URL, $url);

    $response = curl_exec($ch);

    $dom = new DOMDocument();
    @$dom->loadHTML($response);
    $x = new DOMXPath($dom);

    $patch_notes = array();
    
    // gather headers (champions, items, etc)
    $headers = array();
    $header_nodelist = $x->query("//header[@class='header-primary']");
    if ($header_nodelist->length > 0) {
        foreach ($header_nodelist as $header_node) {
            $header_title = trim($header_node->nodeValue);
            $headers[] = $header_title;
        }
    }
    // echo '<pre>';
    // print_r($headers);
    // exit;

    // returns entries under the current header
    $header_index = 0;
    foreach ($headers as $header) {
        // TODO: document what the fuck I wanted when I wrote this XPath query
        $section_nodes = $x->query(
            "//header[{$header_index}+1]
				/following-sibling::div[not(self::header)][count(preceding-sibling::header)={$header_index}+1]");

        if ($section_nodes->length > 0) {
            $index_of_section = 0;
            foreach ($section_nodes as $node) {
                $patch_notes[$headers[$header_index]][] = array();
                foreach ($field_xpaths as $field => $xpath) {
                    // gather data from each entry
                    $nodelist = $x->query($xpath, $node);
                    if ($nodelist->length > 0) {
                        if ($field == 'bulletpoints') {
                            $patch_notes[$headers[$header_index]]
                                    [$index_of_section]
                                        [$field] = array();

                            foreach ($nodelist as $node) {
                                $data = trim($node->nodeValue);
                                $patch_notes[$headers[$header_index]]
                                    [$index_of_section]
                                        [$field][] = $data;
                            }
                        } else {
                            $data = trim($nodelist->item(0)->nodeValue);
							$patch_notes[$headers[$header_index]][$index_of_section][$field]
                                = $data;
                        }
                    }
                }

                $index_of_section++;
            }
        }

        $header_index++;
    }


    echo '<pre>';
    print_r($patch_notes);
}


/**
 * Initializes and returns a cURL handle configured for scraping webpages.
 *
 * @return resource cURL handle.
 */
function setup_curl_resource()
{
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_SSL_VERIFYPEER  => false,
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_CONNECTTIMEOUT  => 30,
        CURLOPT_TIMEOUT         => 30,
        CURLOPT_ENCODING        => "gzip",
        CURLOPT_FOLLOWLOCATION  => true,
        CURLOPT_USERAGENT       => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.89 Safari/537.36",
        CURLOPT_HEADER          => false,
        CURLOPT_NOBODY          => false
    ));

    return $ch;
}
