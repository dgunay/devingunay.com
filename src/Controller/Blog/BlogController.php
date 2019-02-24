<?php

namespace App\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use BlogBackend\Archive;

use Parsedown;

/**
 * Handles data and logic common to all Blog controller classes.
 */
abstract class BlogController extends AbstractController
{
  // TODO: the .env file doesn't seem to be behaving as I expected so I 
  // hardcoded these here. They really shouldn't be.
  protected const PUBLISHED_POSTS_DIR = __DIR__ . '/../../../blog/published';
  protected const FLAT_ARCHIVE_FILE   = __DIR__ . '/../../../blog/flat_archive.json';
  protected const YMD_ARCHIVE_FILE    = __DIR__ . '/../../../blog/ymd_archive.json';

  /** @var Archive $archive */
  protected $archive;

  /** @var Parsedown $parsedown */
  protected $parsedown;

  public function __construct()
  {
    $this->archive = new Archive(
      self::PUBLISHED_POSTS_DIR,
      self::FLAT_ARCHIVE_FILE,
      self::YMD_ARCHIVE_FILE
    );

    $this->parsedown = new Parsedown();
  }

  // protected function render(Post $p): string
  // {
  //   // parse post Markdown to HTML
  //   $html = $this->parsedown->text($p->markdown());

  //   // extra styling
  //   $html = preg_replace(
  //     '/<blockquote>/',
  //     '<blockquote class="blockquote">',
  //     $html
  //   );

  //   return $html;
  // }
}
