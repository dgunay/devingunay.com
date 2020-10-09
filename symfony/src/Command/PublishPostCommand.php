<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use BlogBackend\PersistentArchive;
class PublishPostCommand extends Command
{
  protected static $defaultName = 'app:publish';

  protected function configure()
  {
    $this->setDescription('Publishes a blog post.');
		$this->addArgument('file', InputArgument::REQUIRED, 'The post .md file to publish');
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
    
		$archive->publish($input->getArgument('file'));

    $io->success(
      'Post ' . $input->getArgument('file') . ' successfully published.'
    );
  }
}
