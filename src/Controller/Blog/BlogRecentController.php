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
    return $this->render('blog.html.twig', [ 'posts' => $this->mostRecentPosts(5) ]);
  }

  public function blogPost() {

  }
}