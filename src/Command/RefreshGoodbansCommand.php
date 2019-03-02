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
    
    // FIXME: configureable .env variables
    $db = new ChampionsDatabase(
      new \PDO('sqlite:'.__DIR__.'/../../var/db/goodbans.sqlite'),
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
