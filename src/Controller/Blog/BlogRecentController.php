<?php

namespace App\Controller\Blog;

use App\Controller\Blog\BlogController;

class BlogRecentController extends BlogController
{
  public function __construct() {
    parent::__construct();
  }

  public function blogFront()
  {
    // TODO: gather 5 most recent posts and send them to the template
    $this->archive->loadFlatArchive();
    $five_most_recent_posts = array_slice(
      $this->archive->getFlatArchive(),
      0,
      5,
      true // preserve keys for timestamps
    );

    return $this->render('blog.html.twig', [ 'posts' => $five_most_recent_posts ]);
  }

  public function blogPost() {

  }
}