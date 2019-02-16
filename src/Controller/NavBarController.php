<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class NavBarController extends AbstractController
{
  public function renderWithCurrentPageLinkDeactivated(Request $request)
  { 
    // TODO: pull the current page out from the request so that the template
    // can deactivate it in the navbar
    $currentPageUri = '';
    return $this->render('navbar.html.twig', [
      'currentPage' => $currentPageUri,
    ]);
  }
}