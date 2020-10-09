<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use BlogBackend\PersistentArchive;
use Symfony\Component\Filesystem\Filesystem;

class InitializeBlogCommand extends Command
{
  protected static $defaultName = 'app:initialize-blog';

  protected function configure()
  {
    $this->setDescription('Initializes the blog system and folders.');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $io = new SymfonyStyle($input, $output);
    
    $dirs_to_add = [
      __DIR__ . '/../../blog/published',
      __DIR__ . '/../../blog/unpublished',
    ];

    $files_to_add = [
      __DIR__ . '/../../blog/flat_archive.json',
      __DIR__ . '/../../blog/ymd_archive.json'
    ];
    
    $fs = new Filesystem();
    if ($fs->exists(array_merge($files_to_add, $files_to_add))) {
      $resp = $io->ask("Blog files/folders already detected. Overwrite? [y]");
      if ($resp !== 'y' && $resp !== 'yes') {
        $io->warning("Aborting blog initialization");
        return;
      }
    }

    $fs->mkdir($dirs_to_add);
    $fs->touch($files_to_add);

    $io->success("Blog successfully initialized.");
  } 
}
