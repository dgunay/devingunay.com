<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controls NavBar rendering by passing info about the current active page and
 * which links go in the NavBar.
 */
class NavBarController extends AbstractController
{
  protected const NAVBAR_LINKS = [
    'Good Bans' => '/goodbans', 
    'Hobbies'   => '/hobbies',  
    'About'     => '/about',    
    'Blog'      => '/blog',     
  ];

  /**
   * @param Request $originalRequest Passed via twig {{app.request}}
   * @return void
   */
  public function renderWithCurrentPageLinkDeactivated(Request $originalRequest)
  { 
    return $this->render('navbar.html.twig', [
      'currentPage' => $originalRequest->getPathInfo(),
      'navBarLinks' => self::NAVBAR_LINKS,
    ]);
  }
}