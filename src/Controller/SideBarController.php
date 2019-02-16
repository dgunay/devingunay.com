<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SideBarController extends AbstractController
{
  public function renderSideBar()
  {
    // TODO: grab the 5 most recent blog posts
    // TODO: grab the monthly archive 

    // send it to the template
    return $this->render('blog_sidebar.html.twig', [
      
    ]);
  }
}