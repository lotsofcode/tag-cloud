PHP Tag Cloud Class
===================

The required files are as follows:

* example.php - Example file, contains a list of example ways to include the script.
* css/wordcloud.css - Stylesheet, contains all the size options, imported in example.php
* classes/wordcloud.class.php - PHP Class, included in example.php

Sample usage
-------------
	
```	
<?php
	require_once 'classes/wordcloud.class.php';
	$cloud = new wordCloud();
	$cloud->addWord('php'); // Basic Method of Adding Keyword
	$cloud->addWord(array('word' => 'google', 'url' => 'http://www.google.com')); // Advanced user method
	$cloud->addString('List of words i would like to include');
	$cloud->addWords('hello','world','how','are','foo','bar');
	echo $cloud->showCloud();
?>
```

More advanced usages can be found here:  http://lotsofcode.github.com/tag-cloud