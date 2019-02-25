<?php

namespace App\Controller\Blog;

use App\Controller\Blog\BlogController;

class SideBarController extends BlogController
{
  public function renderSideBar()
  {
    // TODO: grab the 5 most recent blog posts
    // TODO: grab the monthly archive 
    $this->archive->loadFlatArchive();
    $this->archive->loadYmdArchive();
    
    // send it to the template
    return $this->render(
      'blog_sidebar.html.twig',
      [
        'posts' => $this->mostRecentPosts(5),
        'ymdArchive' => $this->archive->getYmdArchive()
      ]
    );
  }
}

