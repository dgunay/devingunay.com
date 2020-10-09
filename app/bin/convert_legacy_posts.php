<?php
/**
 * Quick n dirty script to convert the headers of legacy posts into the new
 * YAML headers.
 */

$blog_posts = array_slice($argv, 1);

foreach ($blog_posts as $file) {
  $lines = file($file);
  $header = array_shift($lines);
  $tags = array_map(function($tag) {return "'$tag'";}, capture_tags($header));
  $new_header = [
    "<!--\n",
    'tags: [' . implode(', ', $tags) . "]\n",
    "-->\n"
  ];

  array_unshift($lines, ...$new_header);

  file_put_contents($file, implode('', $lines));
}

function capture_tags(string $line) : array{
  preg_match_all('/(#[\w_]+)/', $line, $match);
  return $match[1];
}