<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use GoodBans\ChampionsDatabase;
use GoodBans\RiotChampions;
use GoodBans\Lolalytics;
use Symfony\Component\Filesystem\Filesystem;

class RefreshGoodbansCommand extends Command
{
  protected static $defaultName = 'app:refresh_goodbans';

  protected function configure()
  {
    $this->setDescription('Refreshes the GoodBans database.');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $io = new SymfonyStyle($input, $output);
    
    $fs = new Filesystem();
    $goodbans_db = __DIR__ . '/../../var/db/goodbans.sqlite';
    if (!$fs->exists($goodbans_db)) {
      $fs->touch($goodbans_db);
    }

    // FIXME: configureable .env variables
    $db = new ChampionsDatabase(
      new \PDO("sqlite:$goodbans_db"),
      //new OpGG(),
      new Lolalytics(),
      new RiotChampions()
    );
    $db->refresh();
    
    $io->success(
      'GoodBans database successfully refreshed at ' . date(\DateTime::ATOM)
    );
  }
}
