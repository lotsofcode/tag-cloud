<?
	ini_set('display_errors','On');
	error_reporting(E_ALL);
	include 'classes/tagcloud.php';
?>

<link rel="stylesheet" type="text/css" href="./css/tagcloud.css" />

<!-- <div style="xwidth: 200px;,'DESC'"> -->

	<?
		$cloud = new tagcloud();
		
		/* adding a string */
		$cloud->addString("This is a tag-cloud script, written by Del Harvey. I wrote this tag-cloud class because I just love writing code.");
		/* adding a word */
		$cloud->addWord("programming");
		$cloud->addWord("tag-cloud");
		/* adding words */
		$cloud->addWords(array('tag-cloud','php','github',''));
		/* removing a word */
		$cloud->setRemoveWord('github');
		/* removing a word */
		$cloud->setRemoveWord('github');
		/* more complex adding */
    	$cloud->addWord(array('word' => 'php', 'url' => 'http://www.php.net', 'colour' => 1));
    	$cloud->addWord(array('word' => 'ajax', 'url' => 'http://www.php.net', 'colour' => 2));
    	$cloud->addWord(array('word' => 'css', 'url' => 'http://www.php.net', 'colour' => 3));
		/* limiting the output */
//		$cloud->setLimit(10);
		/* set the order */
		// $cloud->setOrder('colour','DESC');

		echo $cloud->showCloud();
	?>

</div>