<link rel="stylesheet" type="text/css" href="./css/tagcloud.css" />

<div style="width: 200px">

	<?
		include 'classes/tagcloud.php';
		$cloud = new tagcloud();

		/* adding a string */
		$cloud->addString("This is a tag-cloud script, written by Del Harvey. I wrote this tag-cloud class because I just love writing code.");

		/* adding a word */
		$cloud->addWord("programming");
		$cloud->addWord("tag-cloud");

		/* adding multiple words */
		$cloud->addWords(array('tag-cloud','php','github'));

		/* removing a word */
		$cloud->setRemoveWord('github');

		/* removing a word */
		$cloud->setRemoveWords(array('del','harvey'));

		/* more complex adding */
		$cloud->addWord(array('word' => 'php', 'url' => 'http://www.php.net', 'colour' => 1));
		$cloud->addWord(array('word' => 'ajax', 'url' => 'http://www.php.net', 'colour' => 2));
		$cloud->addWord(array('word' => 'css', 'url' => 'http://www.php.net', 'colour' => 3));

		/* set the minimum length required */
		$cloud->setMinLength(3);

		/* limiting the output */
		$cloud->setLimit(10);

		/* set the order */
		$cloud->setOrder('colour','DESC');

		echo $cloud->render();
	?>

</div>