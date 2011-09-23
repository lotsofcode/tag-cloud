Sample usage
	
<?php
	require_once 'classes/wordcloud.class.php';
	$cloud = new wordCloud();
	$cloud->addWord('php'); // Basic Method of Adding Keyword
	$cloud->addWord(array('word' => 'google', 'url' => 'http://www.google.com')); // Advanced user method
	$cloud->addString('List of words i would like to include');
	$cloud->addWords('hello','world','how','are','foo','bar');
	echo $cloud->showCloud();
?>