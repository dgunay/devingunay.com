<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
  public function about()
  {
    return $this->render('about.html.twig');
  }
}