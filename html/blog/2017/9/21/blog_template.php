<!DOCTYPE html>
<html>

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
        include('/var/www/html/menu.php');
    ?>

    <!-- Top row -->
    <div class="container" style="margin-bottom: 40px;margin-top: 40px;">
        <h1 class="display-3">Devin's Blog</h1>
    </div>

    <!-- Main -->
    <div class="container">
        <div class="row">
            <!-- Content -->
            <div class="col-sm-8">
                <div class="blog-post">
                    <h2>Post title</h2>
                    <p class="text-muted">Metadata</p>
                    <p>Some content here.</p>
                </div>
            </div>
            <!-- Side bar -->
            <div class="col-sm-3">
                <h4 class="display-5">Side bar title</h4>
                <?php
                    include('/var/www/html/blog/most_recent_posts.php');
                    $most_recent_posts = most_recent_posts();
                    foreach ($most_recent_posts as $post) {
                        echo '<a href="' . $post . '">link</a>' . PHP_EOL;
                    }
                ?>
            </div>
        </div>
    </div>

    <?php
        include('/var/www/html/footer.php');
    ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
            crossorigin="anonymous"></script>
</body>

</html>