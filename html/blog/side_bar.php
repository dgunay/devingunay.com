<!-- Include inside of a column or something -->
<h4 class="display-5">Recent</h4>
  <ul class="list-unstyled">
  <?php
    require_once(__DIR__ . '/config/config.php');
    require_once($GLOBALS['blog_root'] . '/src/post_functions.php');

    $archive = load_archive();
    $most_recent_posts = array_slice($archive, 0, 5, true);
    foreach ($most_recent_posts as $publish_date => $metadata) {
      echo '<li><a href="/blog/post.php?t=' . $metadata['last_modified'] . '">'
        . $metadata['title']
        . '</a><hr></li>' . PHP_EOL;
    }
  ?>
  </ul>
  <h4 class="display-5"><a style="text-decoration:none; color:#000;" href="/blog/archive">Archive</a></h4>
  <ul class="list-unstyled">
    <?php      
      $archive_by_year = get_archive_by_year();
      foreach ($archive_by_year as $year => $months) {
        echo '<li><b>' . $year . '</b></li>' . PHP_EOL;
        foreach ($months as $month => $posts) {
          echo '<li><a href="/blog/archive?m='.date('m', strtotime($month)).'&y='.$year.'">' 
            . $month 
            . '</a></li>' . PHP_EOL;
        }
      }
    ?>
  </ul>