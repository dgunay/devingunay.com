<?php
require_once(__DIR__ . '/post_functions.php');

generate_archive_by_folder();
// generate_archive_by_timestamp();
// generate_archive_by_year();


/**
 * Collects the paths to all .md files in ./posts into an associative array
 * with posts filed away by year and month. 
 * 
 * @author Devin Gunay <devingunay@gmail.com>
 */
function generate_archive_by_year() {
  $all_posts = glob('/var/www/html/blog/posts/*.md');
  
  $archive = array();
  
  foreach ($all_posts as $path_to_post) {
    // construct datetime from Unix timestamp
    $post_datetime = DateTime::createFromFormat(
      'U', // unix timestamp
      filemtime($path_to_post),
      new DateTimeZone('America/Los_Angeles')
    );
  
    // use year and month to sort posts into data structure ($archive)
    $year = $post_datetime->format('Y');
    $month = $post_datetime->format('F');
  
    $archive[$year][$month][] = get_post_data($path_to_post);
  }
  
  // sort years descending
  arsort($archive);

  // sort months
  foreach ($archive as $year => &$months) {
    uksort($months, function($a, $b) {
      $month_a = date_parse($a)['month'];
      $month_b = date_parse($b)['month'];
  
      return $month_a - $month_b;
    });
  }

  // output the archive as .json
  file_put_contents('/var/www/html/blog/archive.json', json_encode($archive));
}

/**
 * TODO: document and finish
 *
 * @return void
 */
function generate_archive_by_folder() {
  $archive = array();

  $years = glob(__DIR__ . '/archive/*', GLOB_ONLYDIR);
  foreach ($years as $year) {
    $year = basename($year);
    $archive[$year] = array();

    $months = glob(__DIR__ . '/archive/' . $year . '/*', GLOB_ONLYDIR);
    foreach ($months as $month) {
      $month = basename($month);
      $archive[$year][$month] = array();
      $days = glob(
        __DIR__ . '/archive/' . $year . '/' . $month . '/*', 
        GLOB_ONLYDIR
      );

      foreach ($days as $day) {
        $day = basename($day);
        $archive[$year][$month][$day] = array();

        $posts = glob(
          __DIR__ . '/archive/' . $year . '/' . $month . '/' . $day . '/*' 
        );
        foreach ($posts as $post) {
          $archive[$year][$month][$day][$post] = get_post_data($post);
        }
      }
    }
  }

  // sort years descending
  krsort($archive);

  // sort months
  foreach ($archive as $year => &$months) {
    uksort($months, function($a, $b) {
      $month_a = date_parse($a)['month'];
      $month_b = date_parse($b)['month'];
  
      return $month_a - $month_b;
    });
  }

  print_r($archive); exit;
}

/**
 * Collects posts into a 1D sorted array by timestamp.
 *
 * @return void
 */
function generate_archive_by_timestamp() {
  $all_posts = glob('/var/www/html/blog/posts/*.md');
  
  $archive = array();
  foreach ($all_posts as $path_to_post) {    
    $post_data = get_post_data($path_to_post);
    $archive[$post_data['last_modified']] = array_merge(
      array('path' => $path_to_post),
      $post_data
    );
  }
  
  krsort($archive, SORT_NUMERIC);

  // output the archive as .json
  file_put_contents(
    '/var/www/html/blog/timestamp_archive.json', 
    json_encode($archive)
  );
}