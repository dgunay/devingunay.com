<!DOCTYPE html>
<html>

<?php
    require_once('../../config.php');
?>
<head>
    <!-- required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
        crossorigin="anonymous">

    <!-- Other -->
    <title>About</title>
</head>

<body>
    <?php
        include($GLOBALS['site_root'] . '/menu.php');
    ?>

    <!-- dynamically create content here -->

    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">
                About
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>The Man</h1>
                <p>Devin Gunay is a PHP developer for 
			<a href = "http://feedonomics.com/">Feedonomics.</a>
		            In his
                    spare time he likes to code, play jazz piano, and play
                    videogames, particularly Smash 4 and League of Legends.
                </p>
            </div>
            <div class="col-lg-6">
                <h1>The Stack</h1>
                <p>Front-end made with the Bootstrap 4 framework. 
                    Back-end running PHP 7.2. Served with Apache2, running on
                    Ubuntu Server 16.04.2 LTS.
                </p>
                <p>
                    Blog is pure PHP operating on the filesystem, with posts 
                    converted from Markdown to HTML with the 
                    <a href="http://parsedown.org/">Parsedown</a>
                    library.
                </p>
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
