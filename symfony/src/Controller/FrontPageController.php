<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontPageController extends AbstractController
{
  public function frontPage()
  {
    return $this->render('frontpage.html.twig');
  }
}