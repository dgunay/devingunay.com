<?php

namespace App\Controller\Blog;

use App\Controller\Blog\AbstractBlogController;
use Symfony\Component\HttpFoundation\Request;
use BlogBackend\Post;

/**
 * Handles displaying the front page of the blog as well as single blog posts.
 */
class BlogController extends AbstractBlogController
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
      'blog_showposts.html.twig',
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
    try {
      $the_post = $archive[$publishTime];
    } catch (\ErrorException $e) {
      // If it isn't there, suggest nearby posts
      return $this->postNotFound($publishTime, $archive);
    }

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
      'blog_showposts.html.twig',
      [
        'posts' => [$the_post],
        'next'  => $next,
        'prev'  => $prev,
      ]
    );
  }

  public function archive(int $year = null, int $month = null)
  {
    $this->archive->loadFlatArchive();
    $this->archive->loadYmdArchive();

    return $this->render(
      'blog_showarchive.html.twig',
      [
        'archive' => $this->archive->getYmdArchive(),
        'year'    => $year,
        'month'   => $month,
      ]
    );
  }

  public function postNotFound(int $time, array $archive)
  {
    // Within 7 days
    $time_difference = 604800;
    $nearby_posts = array_filter(
      $archive,
      function ($timestamp) use ($time_difference, $time) {
        return abs($timestamp - $time) < $time_difference;
      },
      ARRAY_FILTER_USE_KEY
    );

    return $this->render(
      'blog_postnotfound.html.twig',
      [
        'nearbyPosts' => $nearby_posts,
      ]
    );
  }

  public function search(Request $req)
  {
    $this->archive->loadFlatArchive();
    $archive = $this->archive->getFlatArchive();

    // Search linearly for matching tags
    $tags = $req->query->get('tags');
    $relevant_posts = [];
    foreach ($archive as $post) {
      if (self::postMatchesTags($post, $tags)) {
        $relevant_posts[] = $post;
      }
    }

    return $this->render(
      'blog_search.html.twig',
      [
        'posts' => $relevant_posts
      ]
    );
  }

  public static function postMatchesTags(Post $p, array $search_tags): bool
  {
    $remove_hash_symbol = function (string $s) {
      return ltrim($s, '#');
    };

    // Remove hashes from the left
    $post_tags   = array_map($remove_hash_symbol, $p->getTags());
    $search_tags = array_map($remove_hash_symbol, $search_tags);

    return !empty(array_intersect($post_tags, $search_tags));
  }
}
