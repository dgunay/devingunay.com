<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebsiteAvailabilityFunctionalTest extends WebTestCase
{
  /**
   * Smoke tests to make sure the main pages of the website load at all.
   * 
   * @dataProvider urlProvider
   */
  public function testPageIsSuccessful(string $url)
  {
    $client = self::createClient();
    $client->request('GET', $url);

    $this->assertTrue($client->getResponse()->isSuccessful());
  }

  public function urlProvider()
  {
    yield ['/'];
    yield ['/goodbans'];
    yield ['/hobbies'];
    yield ['/about'];
    yield ['/blog'];
  }
}