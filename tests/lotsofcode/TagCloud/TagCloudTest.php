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
    $input = array('foo', 'bar', 'baz');

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

  function testRemovalOfTag()
  {
    $tagCloud = new TagCloud();
    $tagCloud->addTags(array('test', 'removal', 'tags'));
    $tagCloud->setRemoveTag('test');

    $this->assertFalse(array_key_exists('test', $tagCloud->render('array')));
  }

  public function testCustomAttributes()
  {
    $tagCloud = new TagCloud();

    $tags = array(
      array(
        'tag' => 'Hello',
        'url' => 'http://hello.com'
      ),
      array(
        'tag' => 'World',
        'url' => 'http://world.com'
      ),
    );

    foreach ($tags as $tag) {
      $tagCloud->addTag(array('tag' => $tag['tag'], 'url' => $tag['url']));
    }

    $rendered = $tagCloud->render('array');

    $this->assertSame('http://hello.com', $rendered['hello']['url']);
    $this->assertSame('http://world.com', $rendered['world']['url']);
  }

  public function testOrderingBySize()
  {
    $tagCloud = new TagCloud();

    $tagCloud->addTag("hello");
    $tagCloud->addTag("hello");
    $tagCloud->addTag("hello");
    $tagCloud->addTag("beautiful");
    $tagCloud->addTag("beautiful");
    $tagCloud->addTag("beautiful");
    $tagCloud->addTag("world");

    $tagCloud->setOrder('size', 'DESC');

    $cloud = $tagCloud->render('array');

    $keys = array_keys($cloud);

    $this->assertSame("beautiful", $keys[0]);
    $this->assertSame("hello", $keys[1]);
    $this->assertSame("world", $keys[2]);
  }

  public function testHtmlizeFunction()
  {
    $tagCloud = new TagCloud();
    $tagCloud->addTag("Howdy");

    // default
    $expected = "<span class='tag size9'> &nbsp; howdy &nbsp; </span>";
    $this->assertSame($expected, $tagCloud->render());

    // custom htmlize function
    $htmlizeCloud = new TagCloud();
    $htmlizeCloud->addTag("Howdy");
    $htmlizeCloud->setHtmlizeTagFunction(function ($arrayInfo) {
      return '<p>' . $arrayInfo['tag'] . '</p>';
    });

    $this->assertSame("<p>howdy</p>", $htmlizeCloud->render('html'));
  }

  public function testEmptyAttributeCache()
  {
    $tagCloud = new TagCloud();

    $attributes = $tagCloud->getAttributes();

    $this->assertNotContains("tag", $attributes);
    $this->assertNotContains("size", $attributes);
  }

  public function testAttributeCache()
  {
    $tagCloud = new TagCloud();
    $tagCloud->addTag("Howdy");

    $attributes = $tagCloud->getAttributes();

    $this->assertContains("tag", $attributes);
    $this->assertContains("size", $attributes);
  }

  public function testCustomAttributeCache()
  {
    $tagCloud = new TagCloud();
    $tagCloud->addTag(array("tag" => "Howdy", "description" => "Greeting"));

    $attributes = $tagCloud->getAttributes();

    $this->assertContains("tag", $attributes);
    $this->assertContains("size", $attributes);
    $this->assertContains("description", $attributes);

    $cloud = $tagCloud->render("array");

    $this->assertSame("Greeting", $cloud['howdy']['description']);
  }

  public function testNoTransliterate()
  {
    $tagCloud = new TagCloud();

    $tagCloud->setOption('transliterate', false);

    $this->assertSame(false, $tagCloud->getOption("transliterate"));

    $tagCloud->addTag("example");
    $tagCloud->addTag("éxample");

    $cloud = $tagCloud->render("array");

    $this->assertCount(2, $cloud);
    $this->assertArrayHasKey("example", $cloud);
    $this->assertArrayHasKey("éxample", $cloud);
  }

  public function testTransliterate()
  {
    $tagCloud = new TagCloud();

    // transliterate should be default behaviour
    $this->assertSame(true, $tagCloud->getOption("transliterate"));

    $tagCloud->addTag("myexample");
    $tagCloud->addTag("myéxample");

    $cloud = $tagCloud->render("array");

    $this->assertCount(1, $cloud);
    $this->assertArrayHasKey("myexample", $cloud);
    $this->assertArrayNotHasKey("myéxample", $cloud);
  }
}
