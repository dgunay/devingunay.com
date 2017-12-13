<?php
include('post_functions.php');

echo '<pre>';

print_r(get_posts_by_tags(array(
  'gaming',
)));

echo memory_get_peak_usage();