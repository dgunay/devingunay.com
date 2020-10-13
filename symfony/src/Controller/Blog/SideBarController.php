<?php

namespace App\Controller\Blog;

use App\Controller\Blog\AbstractBlogController;

/**
 * Handles passing posts and the archive to the blog sidebar.
 */
class SideBarController extends AbstractBlogController
{
  public function renderSideBar()
  {
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

