# PHP Tag Cloud
## v4.0.1

[![Build Status](https://travis-ci.org/lotsofcode/tag-cloud.png?branch=master)](https://travis-ci.org/lotsofcode/tag-cloud)

#### Install with composer

```bash
composer require lotsofcode/tag-cloud
```

#### Basic usage

```php
$cloud = new TagCloud();
$cloud->addTag("tag-cloud");
$cloud->addTag("programming");
echo $cloud->render();
```

#### Convert a string

```php
$cloud->addString("This is a tag-cloud script, written by Del Harvey. I wrote this tag-cloud class because I just love writing code.");
```

#### Adding multiple tags

```php
$cloud->addTags(array('tag-cloud','php','github'));
```

#### Removing a tag

```php
$cloud->setRemoveTag('github');
```

#### Removing multiple tags

```php
$cloud->setRemoveTags(array('del','harvey'));
```

#### More complex adding

```php
$cloud->addTag(array('tag' => 'php', 'url' => 'http://www.php.net', 'colour' => 1));
$cloud->addTag(array('tag' => 'ajax', 'url' => 'http://www.php.net', 'colour' => 2));
$cloud->addTag(array('tag' => 'css', 'url' => 'http://www.php.net', 'colour' => 3));
```

#### Set the minimum length required

```php
$cloud->setMinLength(3);
```

#### Limiting the output

```php
$cloud->setLimit(10);
```

#### Set the order

```php
$cloud->setOrder('colour','DESC');
```

#### Set a custom HTML output

```php
$cloud->setHtmlizeTagFunction(function($tag, $size) use ($baseUrl) {
  $link = '<a href="'.$baseUrl.'/'.$tag['url'].'">'.$tag['tag'].'</a>';
  return "<span class='tag size{$size} colour-{$tag['colour']}'>{$link}</span> ";
});
```

#### Outputting the cloud (shown above)

```php
echo $cloud->render();
```

#### Transliteration

By default, all accented characters will be converted into their non-accented equivalent,
this is to circumvent duplicate similar tags in the same cloud, to disable this functionality
and display the UTF-8 characters you can do the following:

```php
$tagCloud->setOption('transliterate', false);
```

More usages on in a prettier format can be found here: http://lotsofcode.github.com/tag-cloud

## Tests

To run the unit test suite, first install the dependencies:

```bash
curl -s https://getcomposer.org/installer | php
php composer.phar install
```

Then execute phpunit in the root directory

```bash
./vendor/bin/phpunit
```

## Submitting pull requests

Indentation style, size and encoding should be followed as per .editorconfig settings.
