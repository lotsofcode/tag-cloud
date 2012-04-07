<link rel="stylesheet" type="text/css" href="./css/tagcloud.css" />

<div style="width: 200px">

	<?

ini_set('display_errors','on');

		include 'classes/tagcloud.php';
		$cloud = new tagcloud();

		/* adding a string */
		$cloud->addString("This is a tag-cloud script, written by Del Harvey. I wrote this tag-cloud class because I just love writing code.");

		/* adding a tag */
		$cloud->addTag("programming");
		$cloud->addTag("tag-cloud");

		/* adding multiple tags */
		$cloud->addTags(array('tag-cloud','php','github'));

		/* removing a tag */
		$cloud->setRemoveTag('github');

		/* removing a tag */
		$cloud->setRemoveTags(array('del','harvey'));

		/* more complex adding */
		$cloud->addTag(array('tag' => 'php', 'url' => 'http://www.php.net', 'colour' => 1));
		$cloud->addTag(array('tag' => 'ajax', 'url' => 'http://www.php.net', 'colour' => 2));
		$cloud->addTag(array('tag' => 'css', 'url' => 'http://www.php.net', 'colour' => 3));

		/* set the minimum length required */
		$cloud->setMinLength(3);

		/* limiting the output */
		$cloud->setLimit(10);

		/* set the order */
		$cloud->setOrder('colour','DESC');

		echo $cloud->render();
	?>

</div>