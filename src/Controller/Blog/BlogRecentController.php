<?php

namespace App\Controller\Blog;

use App\Controller\Blog\BlogController;
use phpDocumentor\Reflection\Types\Null_;

/**
 * TODO: refactor to handle single and multi posts as well
 * TODO: rename
 */
class BlogRecentController extends BlogController
{
  public function __construct()
  {
    parent::__construct();
  }

  // Renders the 5 most recent posts.
  public function blogFront()
  {
    $most_recent_posts = $this->mostRecentPosts(6);
    $prev_post = array_pop($most_recent_posts);
    return $this->render(
      'blog.html.twig',
      [
        'posts' => $most_recent_posts,
        'prev'  => $prev_post,
        'next'  => null
      ]
    );
  }

  // Renders just one blog post.
  public function blogPost(int $publishTime)
  {
    $this->archive->loadFlatArchive();
    $archive = $this->archive->getFlatArchive();

    // Grab our post
    $the_post = $archive[$publishTime];

    // ...as well as the ones next to it.
    $next = null;
    $prev = null;
    $archive = array_values($archive);
    foreach ($archive as $index => $post) {
      if ($post->getPublishTime() === $publishTime) {
        $next = $archive[$index - 1] ?? null;
        $prev = $archive[$index + 1] ?? null;
        break;
      }
    }

    return $this->render(
      'blog.html.twig',
      [
        'posts' => [$the_post],
        'next'  => $next,
        'prev'  => $prev,
      ]
    );
  }
}
