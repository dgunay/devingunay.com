<?php

use BlogBackend\PostFactory;
/**
 * Resets the edit time of all published posts.
 */

require_once __DIR__ . '/../vendor/autoload.php';

$blog_posts = array_slice($argv, 1);

foreach ($blog_posts as $file) 
{ 
  $post = PostFactory::fromFilename($file);
  touch($file, $post->getPublishTime());
}


