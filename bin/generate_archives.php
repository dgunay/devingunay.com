<?php

// TODO: this whole script should just be a new Console Command class that gets
// the location of the archive(s) from a configured env variable.

require __DIR__ . '/../vendor/autoload.php';

use BlogBackend\PersistentArchive;

$archive = new PersistentArchive(
	__DIR__ . '/../blog/published',
	__DIR__ . '/../blog/flat_archive.json',
	__DIR__ . '/../blog/ymd_archive.json'
);

$archive->generateFlatArchive();
$archive->loadFlatArchive();
$archive->generateYmdArchive();