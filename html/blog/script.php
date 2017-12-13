<?php
    if (true) {
        require_once('/var/www/Parsedown.php');
        // echo 'hi';
        // load contents of markdown file with t.md
        if (file_exists('/var/www/html/blog/posts/1506036600.md')) {
            echo 'hi';
            $pd = new Parsedown(); 
            // print_r($pd);
            $success = file_get_contents('/var/www/html/blog/posts/1506036600.md');
            var_dump($success);
        }
    }
?>