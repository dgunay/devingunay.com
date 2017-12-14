<?php

require_once(__DIR__ . '/post_functions.php');

if (count($argv) < 2) {
	exit('Usage: php ' . __FILE__ . ' [file(s)_to_publish]');
}

foreach(glob($argv[1]) as $file) {
	echo $file . PHP_EOL;
	if (preg_match('/.+\.md$/', $file)) {
		publish_post($file);
	}
}
