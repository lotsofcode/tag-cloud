# PHP Tag Cloud
## v4.0.1

[![Build Status](https://travis-ci.org/lotsofcode/tag-cloud.png?branch=master)](https://travis-ci.org/lotsofcode/tag-cloud)

#### Basic usage

	$cloud = new TagCloud();
	$cloud->addTag("tag-cloud");
	$cloud->addTag("programming");
	echo $cloud->render();

#### Convert a string

	$cloud->addString("This is a tag-cloud script, written by Del Harvey. I wrote this tag-cloud class because I just love writing code.");

#### Adding multiple tags

	$cloud->addTags(array('tag-cloud','php','github'));

#### Removing a tag

	$cloud->setRemoveTag('github');

#### Removing multiple tags

	$cloud->setRemoveTags(array('del','harvey'));

#### More complex adding

	$cloud->addTag(array('tag' => 'php', 'url' => 'http://www.php.net', 'colour' => 1));
	$cloud->addTag(array('tag' => 'ajax', 'url' => 'http://www.php.net', 'colour' => 2));
	$cloud->addTag(array('tag' => 'css', 'url' => 'http://www.php.net', 'colour' => 3));

#### Set the minimum length required

	$cloud->setMinLength(3);

#### Limiting the output
	$cloud->setLimit(10);

#### Set the order
	$cloud->setOrder('colour','DESC');

#### Set a custom HTML output

	$cloud->setHtmlizeTagFunction( function($tag, $size) {
		$link = '<a href="'.$tag['url'].'">'.$tag['tag'].'</a>';
		return "<span class='tag size{$size} colour-{$tag['colour']}'>{$link}</span> ";
	});

#### Outputting the cloud (shown above)

	echo $cloud->render();

More usages on in a prettier format can be found here: http://lotsofcode.github.com/tag-cloud

## Tests

To run the unit test suite, first install the dependencies:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
```

Then execute phpunit in the root directory

```
./vendor/bin/phpunit
```

## Submitting pull requests

Indentation style, size and encoding should be followed as per .editorconfig settings.
