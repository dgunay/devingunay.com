<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use GoodBans\ChampionsDatabase;
use GoodBans\RiotChampions;
use GoodBans\Lolalytics;

class GoodBansController extends AbstractController
{
  // FIXME: why isn't the .env file working?
  private const GOODBANS_DB = __DIR__ .'/../../var/db/goodbans.sqlite';

  public function goodBans()
  {
    $db = new ChampionsDatabase(
      new \PDO('sqlite:' . self::GOODBANS_DB),
      // new OpGG(),
      new Lolalytics(),
      new RiotChampions()			
    );
    $bans = $db->topBans();

    return $this->render('goodbans.html.twig', ['bans' => $bans]);
  }
}