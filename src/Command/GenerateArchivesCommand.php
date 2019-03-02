<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use BlogBackend\PersistentArchive;
class GenerateArchivesCommand extends Command
{
  protected static $defaultName = 'app:generate_archives';

  protected function configure()
  {
    $this->setDescription('Generates JSON archive files for the blog.');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $io = new SymfonyStyle($input, $output);

    // FIXME: configurable/env values!!!
    $archive = new PersistentArchive(
      __DIR__ . '/../../blog/published',
      __DIR__ . '/../../blog/flat_archive.json',
      __DIR__ . '/../../blog/ymd_archive.json'
    );
    
    $archive->generateFlatArchive();
    $archive->loadFlatArchive();
    $archive->generateYmdArchive();

    $io->success(
      'Archive files successfully generated at ' . date(\DateTime::ATOM)
    );
  }
}
