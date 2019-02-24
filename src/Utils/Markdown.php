<?php

namespace App\Utils;

use Parsedown;

/**
 * Defines how we'd like to render our Markdown posts.
 */
class Markdown
{
  private $pd;

  public function __construct()
  {
    $this->pd = new Parsedown();
  }

  public function toHtml(string $text): string
  {
		$html = $this->pd->text($text);
		
    // extra styling
    $html = preg_replace(
      '/<blockquote>/',
      '<blockquote class="blockquote">',
      $html
		);
		
		return $html;
  }
}
