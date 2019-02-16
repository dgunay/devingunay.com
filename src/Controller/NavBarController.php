<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class NavBarController extends AbstractController
{
  public function renderWithCurrentPageLinkDeactivated(Request $request)
  {
    $currentPage = $request->getUriForPath($request->getPathInfo());
    echo $currentPage;
    // TODO: pull the current page out from the request so that the template
    // can deactivate it in the navbar
    return $this->render('navbar.html.twig', []);
  }
}