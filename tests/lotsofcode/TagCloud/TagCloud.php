<?php

namespace lotsofcode\TagCloud;

/**
 * Tests for \lotsofcode\TagCloud.
 *
 * @category lotsofcode
 * @package lotsofcode\TagCloud
 */
class TagCloudTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Tests invoke of class without any tags supplied
   */
  public function testEmptyTagCloudRendersNull()
  {
    $tagCloud = new TagCloud();
    $this->assertEquals(null, $tagCloud->render());
  }

  /**
   * Tests size increment of tag entity
   */
  public function testAddingMultipleTagsIncreasesSizeKey()
  {
    $tagCloud = new TagCloud();
    $tagCloud->addTag('Foo');
    $tagCloud->addTag('Foo');

    $rendered = $tagCloud->render('array');

    $this->assertEquals(2, $rendered['foo']['size']);
  }

  /**
   * Tests creation of cloud with tags
   * provided directly to the contructor
   */
  public function testTagCloudCreatedFromContructor()
  {
    $input = array('foo','bar','baz');

    $tagCloud = new TagCloud($input);
    $rendered = $tagCloud->render('array');

    foreach ($input as $item) {
      $this->assertTrue(in_array($item, array_keys($rendered)));
    }
  }

  public function testCustomTagEntity()
  {
    $tagCloud = new TagCloud();

    $this->assertEquals(0, $tagCloud->calculateClassFromPercent(0));
    $this->assertEquals(1, $tagCloud->calculateClassFromPercent(5));
    $this->assertEquals(2, $tagCloud->calculateClassFromPercent(10));
    $this->assertEquals(3, $tagCloud->calculateClassFromPercent(20));
    $this->assertEquals(4, $tagCloud->calculateClassFromPercent(30));
    $this->assertEquals(5, $tagCloud->calculateClassFromPercent(40));
    $this->assertEquals(6, $tagCloud->calculateClassFromPercent(50));
    $this->assertEquals(7, $tagCloud->calculateClassFromPercent(60));
    $this->assertEquals(8, $tagCloud->calculateClassFromPercent(70));
    $this->assertEquals(8, $tagCloud->calculateClassFromPercent(80));
    $this->assertEquals(8, $tagCloud->calculateClassFromPercent(90));
    $this->assertEquals(9, $tagCloud->calculateClassFromPercent(100));
  }
}
