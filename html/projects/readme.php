<?php
// get the title of the project
$path = 'kuroganehammer-php';
$project_html = file_get_contents(
    'https://github.com/dgunay/' . $path
);

$dom = new DOMDocument();
@$dom->loadHTML($project_html);
$x = new DOMXPath($dom);

$article_nodelist = $x->query("//article");
// var_dump($article_nodelist);

echo $dom->saveHTML($article_nodelist->item(0));