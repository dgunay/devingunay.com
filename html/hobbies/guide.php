<!DOCTYPE html>
<html>
<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  require_once(__DIR__ . '/../../config.php');
?>
<head>
  <!-- required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
    crossorigin="anonymous">

  <!-- Other -->
  <title>Devin Gunay</title>
</head>

<body>
  <?php
    include('../menu.php');
  ?>

    <!-- <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">Guides </h1>

            <p class="lead">
                Competitive guides for Smash 4 and League of Legends.
            </p>
            <p class="lead">
                No guarantees that any of my writing is current for
                for the meta of either game!
            </p>
        </div>
    </div> -->

  <!-- <div class="container">
    <div class="row" style="bottom: 20px;">
      <h1 class="text-left display-4">Video Games</h1>
    </div>
  </div> -->
  <div class="container">
    <div class="row">    
      <div class="col-md">
        <?php
        require_once($GLOBALS['parsedown_path']);
        
        $guides = array_map(function($element) {
          return basename($element);
        }, glob(__DIR__ . '/guides/*.md'));
        
        if (in_array($_GET['guide'], $guides)) {
          $pd = new Parsedown();
          echo $pd->text(file_get_contents(__DIR__ . '/guides/' . $_GET['guide']));
        }
        else {
          // TODO: handle failure path
        }
        
        ?>
      </div>
    </div>
  </div>


  <?php
    include($GLOBALS['site_root'] . '/footer.php');
  ?>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
    crossorigin="anonymous"></script>
</body>

</html>
