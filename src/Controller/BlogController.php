<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
  public function blogFront()
  {
    return $this->render('blog.html.twig');
  }
}