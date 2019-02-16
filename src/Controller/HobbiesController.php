<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HobbiesController extends AbstractController
{
  public function hobbies()
  {
    return $this->render('hobbies.html.twig');
  }
}