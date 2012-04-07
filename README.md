# PHP Tag Cloud
## v3.0

#### Basic usage

	include 'classes/tagcloud.php';
	$cloud = new tagcloud();
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

#### Outputting the cloud (shown above)

	echo $cloud->render();

More usages on in a prettier format can be found here: http://lotsofcode.github.com/tag-cloud