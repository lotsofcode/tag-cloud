PHP Tag Cloud http://www.lotsofcode.com/php/tag-cloud.htm
=============

The required files are as follows:

* example.php - Example file, contains a list of example ways to include the script.
* css/wordcloud.css - Stylesheet, contains all the size options, imported in example.php
* classes/wordcloud.class.php - PHP Class, included in example.php

Sample usage
-------------
	
	<?php
		require_once 'classes/wordcloud.class.php';
		$cloud = new wordCloud();
		$cloud->addWord('php'); // Basic Method of Adding Keyword
		$cloud->addWord(array('word' => 'google', 'url' => 'http://www.google.com')); // Advanced user method
		$cloud->addString('List of words i would like to include');
		$cloud->addWords('hello','world','how','are','foo','bar');
		echo $cloud->showCloud();
	?>