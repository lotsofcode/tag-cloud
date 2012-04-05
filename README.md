# PHP Tag Cloud
## Derek Harvey
### v3.0

#### Basic usage

	include 'classes/tagcloud.php';
	$cloud = new tagcloud();
	$cloud->addWord("tag-cloud");
	$cloud->addWord("programming");
	echo $cloud->render();

#### Convert a string 

	$cloud->addString("This is a tag-cloud script, written by Del Harvey. I wrote this tag-cloud class because I just love writing code.");

#### Adding multiple words

	$cloud->addWords(array('tag-cloud','php','github'));

#### Removing a word

	$cloud->setRemoveWord('github');

#### Removing multiple words

	$cloud->setRemoveWords(array('del','harvey'));

#### More complex adding

	$cloud->addWord(array('word' => 'php', 'url' => 'http://www.php.net', 'colour' => 1));
	$cloud->addWord(array('word' => 'ajax', 'url' => 'http://www.php.net', 'colour' => 2));
	$cloud->addWord(array('word' => 'css', 'url' => 'http://www.php.net', 'colour' => 3));

#### Set the minimum length required

	$cloud->setMinLength(3);

#### Limiting the output
	$cloud->setLimit(10);

#### Set the order
	$cloud->setOrder('colour','DESC');

#### Outputting the cloud (shown above)

	echo $cloud->render();

More usages on in a prettier format can be found here: http://lotsofcode.github.com/tag-cloud