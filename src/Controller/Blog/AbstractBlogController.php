<?php

namespace App\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use BlogBackend\PersistentArchive;

use Parsedown;

/**
 * Handles data and logic common to all Blog controller classes.
 */
abstract class AbstractBlogController extends AbstractController
{
  // TODO: the .env file doesn't seem to be behaving as I expected so I 
  // hardcoded these here. They really shouldn't be.
  protected const PUBLISHED_POSTS_DIR = __DIR__ . '/../../../blog/published';
  protected const FLAT_ARCHIVE_FILE   = __DIR__ . '/../../../blog/flat_archive.json';
  protected const YMD_ARCHIVE_FILE    = __DIR__ . '/../../../blog/ymd_archive.json';

  /** @var PersistentArchive $archive */
  protected $archive;

  /** @var Parsedown $parsedown */
  protected $parsedown;

  public function __construct()
  {
    $this->archive = new PersistentArchive(
      self::PUBLISHED_POSTS_DIR,
      self::FLAT_ARCHIVE_FILE,
      self::YMD_ARCHIVE_FILE
    );

    $this->parsedown = new Parsedown();
  }

  /**
   * Returns the most recent posts in the archive.
   *
   * @param integer $n
   * @return Post[]
   */
  protected function mostRecentPosts(int $n = 5) : array {
    $this->archive->loadFlatArchive();
    $most_recent_posts = array_slice(
      $this->archive->getFlatArchive(),
      0,
      $n,
      true // preserve keys for timestamps
    );

    return $most_recent_posts;
  }
}

