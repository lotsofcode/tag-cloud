<?php

  /************************************************************\
  *
  *	  wordCloud Copyright 2007 Derek Harvey
  *	  www.lotsofcode.com
  *
  *	  This file is part of wordCloud.
  *
  *	  wordCloud is free software; you can redistribute it and/or modify
  *	  it under the terms of the GNU General Public License as published by
  *	  the Free Software Foundation; either version 2 of the License, or
  *	  (at your option) any later version.
  *
  *	  wordCloud is distributed in the hope that it will be useful,
  *	  but WITHOUT ANY WARRANTY; without even the implied warranty of
  *	  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
  *	  GNU General Public License for more details.
  *
  *	  You should have received a copy of the GNU General Public License
  *	  along with wordCloud; if not, write to the Free Software
  *	  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA	02111-1307	USA
  *
  \************************************************************/
  
  require 'classes/wordcloud.class.php';
  
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html>
  <head>
  <title>PHP wordCloud by LotsOfCode.com</title>
  <style type="text/css">
    <!--
      @import url('./css/example.css');
      @import url('./css/wordcloud.css');
      
      textarea:before {
         content: '[code]';  
      }
      textarea:after {
         content: '[/code]';           
      }
    //-->
  </style>
  <script>
    window.onload = function()
    {
      // WRITTEN BY DEL
      // lotsofcode.com
      
      // Get the elements of the main "cloud" form
      e = document.forms['cloud'].elements;
      // Get the length of all the elements
      l = e.length;
      for (var i = 0; i < l; i++) {
        // If the element is a textarea
        if (e[i].type == 'textarea') {
          // select the element as we click on it
          e[i].onclick = e[i].select;
        }
      }
    }
  </script>
  </head>
  <body>
  <div id="example">
  <form name="cloud">
      <h1><a href="http://www.lotsofcode.com/php/tutorials/tag-cloud-v2" target="_blank">PHP Tag Cloud v2.0</a></h1>
      <h2><a href="http://www.lotsofcode.com" target="_blank">lotsofcode.com</a></h2>
      <p>Thank you for downloading the tag cloud script at lotsofcode.com, below are some examples of how you can impliment the tag cloud in to your personal website, it's pretty simple to include however if you do have any problems, please don't hesitate to use our <a href="http://www.lotsofcode.com/forum/index.php?c=3" target="_blank">support forum</a>. Good luck and i hope you find this code useful.</p>
      <p>Some of the new features included in the tag cloud script are:
        <ul>
          <li>Link and URL Assignment to each Tag</li>
          <li>Additional attribute assignment to each tag e.g. title, etc</li>
          <li>Add styles and colour options to any tag</li>
          <li>Set a limit to the amount of tags that are displayed</li>
          <li>Examples of intergrating with a MySQL Database </li>
          <li>Examples of intergrating with a Flat Text File </li>
          <li>String to cloud, parse a single string into a tag cloud instantly</li>
          <li>Ignore list, to remove particular words from the cloud. e.g. and, the, it, i</li>
          <li>Ordering by a selective field. e.g. word, size, colour</li>
        </ul>
      </p>
      <p><b>Important:</b> Please include the wordcloud class and the wordcloud stylesheet along with every example to get the desired results, like so:<br /><br />
      <code style="padding: 4px; display: block; background: #FFF; border: 1px inset #000;">
        &lt;?php<br />
          &nbsp; include './classes/wordcloud.class.php';<br />
        ?&gt;<br />
        &lt;link rel=&quot;stylesheet&quot; href=&quot;./css/wordcloud.css&quot; type=&quot;text/css&quot;&gt;
      </code></p>
      </p>
      <!-- b: basic example -->
      <h3>Basic Example</h3>
      <p>This is a basic example of how you can impliment a tag-cloud into your website</p>
      <div class="word-cloud">
      <?php
        // Initite the basic object
        $cloud = new wordCloud();
        // Basic Add Option
        $cloud->addWord('php');
        $cloud->addWord('google');
        $cloud->addWord('digg');
        $cloud->addWord('lotsofcode');
        // Advanced Add Option
        $cloud->addWord(array('word' => 'lotsofcode', 'size' => 4, 'url' => 'http://www.lotsofcode.com'));
        $cloud->addWord(array('word' => 'google', 'size' => 1, 'url' => 'http://www.lotsofcode.com'));
        echo $cloud->showCloud();
      ?>
      <br /><br />
      </div>
      <h4>Code Example</h4>
      <textarea>&lt;?php
$cloud = new wordCloud();
$cloud-&gt;addWord('php'); // Basic Method of Adding Keyword
$cloud-&gt;addWord(array('word' =&gt; 'google', 'size' =&gt; 2, 'url' =&gt; 'http://www.google.com')); // Advanced user method
$cloud-&gt;addWord(array('word' =&gt; 'digg', 'url' =&gt; 'http://digg.com'));
$cloud-&gt;addWord(array('word' =&gt; 'lotsofcode', 'size' =&gt; 4, 'url' =&gt; 'http://www.lotsofcode.com'));
echo $cloud-&gt;showCloud();
?&gt;</textarea>
      <!-- e: basic example -->
      
      <br /><br />
      <!-- b: basic string example -->
      <h3>Basic String Example</h3>
      <p>This is a basic example of how you can impliment a tag-cloud into your website by using a single string</p>
      <div class="word-cloud">
      <?php
        $cloud = new wordCloud();
        $cloud->addString('lotsofcode lotsofcode lotsofcode have developed a tag cloud that contains keywords found ');
        echo $cloud->showCloud();
      ?>
      <br /><br />
      </div>
      <h4>Code Example</h4>
      <textarea>&lt;?php
$cloud = new wordCloud();
$cloud-&gt;addString('lotsofcode lotsofcode lotsofcode have developed a tag cloud that contains keywords found ');
echo $cloud-&gt;showCloud();
?&gt;</textarea>
      <!-- e: basic string example -->
      
      <br /><br />
      <!-- b: basic example w/ links -->
      <h3>Example w/ Links</h3>
      <p>This is an example of how you can impliment a tag-cloud into your website including links</p>
      <div class="word-cloud">
        <?php
          // Initite the basic object
          $cloud = new wordCloud();
          $cloud->addWord(array('word' => 'php', 'size' => 1, 'url' => 'http://www.php.net'));
          $cloud->addWord(array('word' => 'google', 'size' => 2, 'url' => 'http://www.google.com'));
          $cloud->addWord(array('word' => 'digg', 'size' => 3, 'url' => 'http://digg.com'));
          $cloud->addWord(array('word' => 'lotsofcode', 'size' => 4, 'url' => 'http://www.lotsofcode.com'));
          $myCloud = $cloud->showCloud('array');
          foreach ($myCloud as $cloudArray) {
            echo ' &nbsp; <a href="'.$cloudArray['url'].'" class="word size'.$cloudArray['range'].'">'.$cloudArray['word'].'</a> &nbsp;';
          }	
        ?>
      </div>
      <h4>Code Example</h4>
      <textarea>&lt;?php
$cloud = new wordCloud();
$cloud-&gt;addWord(array('word' =&gt; 'php', 'size' =&gt; 1, 'url' =&gt; 'http://www.php.net'));
$cloud-&gt;addWord(array('word' =&gt; 'google', 'size' =&gt; 2, 'url' =&gt; 'http://www.google.com'));
$cloud-&gt;addWord(array('word' =&gt; 'digg', 'size' =&gt; 3, 'url' =&gt; 'http://digg.com'));
$cloud-&gt;addWord(array('word' =&gt; 'lotsofcode', 'size' =&gt; 4, 'url' =&gt; 'http://www.lotsofcode.com'));
$myCloud = $cloud-&gt;showCloud('array');
foreach ($myCloud as $cloudArray) {
  echo ' &amp;nbsp; &lt;a href=&quot;'.$cloudArray['url'].'&quot; class=&quot;word size'.$cloudArray['range'].'&quot;&gt;'.$cloudArray['word'].'&lt;/a&gt; &amp;nbsp;';
}
?&gt;</textarea>
      <!-- e: basic example w/ links -->
      <br /><br />
      <!-- b: basic example w/ colours -->
      <h3>Example w/ Colours</h3>
      <p>This is a basic example of how you can impliment a tag-cloud into your website including colours</p>
      <div class="word-cloud">
        <?php
          // Initite the basic object
          $cloud = new wordCloud();
          $cloud->addWord(array('word' => 'php', 'size' => 1, 'url' => 'http://www.php.net', 'colour' => '#FF0000'));
          $cloud->addWord(array('word' => 'google', 'size' => 2, 'url' => 'http://www.google.com', 'colour' => '#00FF00'));
          $cloud->addWord(array('word' => 'digg', 'size' => 3, 'url' => 'http://digg.com', 'colour' => '#0000FF'));
          $cloud->addWord(array('word' => 'lotsofcode', 'size' => 4, 'url' => 'http://www.lotsofcode.com', 'colour' => '#FFFF00'));
          $myCloud = $cloud->showCloud('array');
          foreach ($myCloud as $cloudArray) {
            echo ' &nbsp; <span style="color: '.$cloudArray['colour'].';" class="word size'.$cloudArray['range'].'">'.$cloudArray['word'].'</span> &nbsp;';
          }	
        ?>
      </div>
      <h4>Code Example</h4>
      <textarea>&lt;?php
$cloud = new wordCloud();
$cloud-&gt;addWord(array('word' =&gt; 'php', 'size' =&gt; 1, 'url' =&gt; 'http://www.php.net', 'colour' =&gt; '#FF0000'));
$cloud-&gt;addWord(array('word' =&gt; 'google', 'size' =&gt; 2, 'url' =&gt; 'http://www.google.com', 'colour' =&gt; '#00FF00'));
$cloud-&gt;addWord(array('word' =&gt; 'digg', 'size' =&gt; 3, 'url' =&gt; 'http://digg.com', 'colour' =&gt; '#0000FF'));
$cloud-&gt;addWord(array('word' =&gt; 'lotsofcode', 'size' =&gt; 4, 'url' =&gt; 'http://www.lotsofcode.com', 'colour' =&gt; '#FFFF00'));
$myCloud = $cloud-&gt;showCloud('array');
foreach ($myCloud as $cloudArray) {
  echo ' &amp;nbsp; &lt;span style=&quot;color: '.$cloudArray['colour'].';&quot; class=&quot;word size'.$cloudArray['range'].'&quot;&gt;'.$cloudArray['word'].'&lt;/span&gt; &amp;nbsp;';
}	
?&gt;</textarea>
      <!-- e: basic example w/ colours -->
      <br /><br />
      <!-- b: basic example w/ links & colours -->
      <h3>Example w/ Links &amp; Colours</h3>
      <p>This is a basic example of how you can impliment a tag-cloud into your website including links with colours</p>
      <div class="word-cloud">
        <?php
          // Initite the basic object
          $cloud = new wordCloud();
          $cloud->addWord(array('word' => 'php', 'size' => 1, 'url' => 'http://www.php.net', 'colour' => '#FF0000'));
          $cloud->addWord(array('word' => 'google', 'size' => 2, 'url' => 'http://www.google.com', 'colour' => '#00FF00'));
          $cloud->addWord(array('word' => 'digg', 'size' => 3, 'url' => 'http://digg.com', 'colour' => '#0000FF'));
          $cloud->addWord(array('word' => 'lotsofcode', 'size' => 4, 'url' => 'http://www.lotsofcode.com', 'colour' => '#FFFF00'));
          $myCloud = $cloud->showCloud('array');
          foreach ($myCloud as $cloudArray) {
            echo ' &nbsp; <a href="'.$cloudArray['url'].'" style="color: '.$cloudArray['colour'].';" class="word size'.$cloudArray['range'].'">'.$cloudArray['word'].'</a> &nbsp;';
          }	
        ?>
      </div>
      <h4>Code Example</h4>
      <textarea>&lt;?php
$cloud = new wordCloud();
$cloud-&gt;addWord(array('word' =&gt; 'php', 'size' =&gt; 1, 'url' =&gt; 'http://www.php.net', 'colour' =&gt; '#FF0000'));
$cloud-&gt;addWord(array('word' =&gt; 'google', 'size' =&gt; 2, 'url' =&gt; 'http://www.google.com', 'colour' =&gt; '#00FF00'));
$cloud-&gt;addWord(array('word' =&gt; 'digg', 'size' =&gt; 3, 'url' =&gt; 'http://digg.com', 'colour' =&gt; '#0000FF'));
$cloud-&gt;addWord(array('word' =&gt; 'lotsofcode', 'size' =&gt; 4, 'url' =&gt; 'http://www.lotsofcode.com', 'colour' =&gt; '#FFFF00'));
$myCloud = $cloud-&gt;showCloud('array');
foreach ($myCloud as $cloudArray) {
  echo ' &amp;nbsp; &lt;a href=&quot;'.$cloudArray['url'].'&quot; style=&quot;color: '.$cloudArray['colour'].';&quot; class=&quot;word size'.$cloudArray['range'].'&quot;&gt;'.$cloudArray['word'].'&lt;/a&gt; &amp;nbsp;';
}	
 ?&gt;</textarea>
      <!-- e: basic example w/ links & colours -->
      <br /><br />
      <!-- b: basic example w/ limit -->
      <h3>Example w/ Limit</h3>
      <p>This is a basic example of how you can impliment a tag-cloud into your website with a limit of words</p>
      <div class="word-cloud">
        <?php
          // Initite the basic object
          $cloud = new wordCloud();
          $cloud->addWord(array('word' => 'php', 'size' => 1, 'url' => 'http://www.php.net', 'colour' => '#FF0000'));
          $cloud->addWord(array('word' => 'google', 'size' => 2, 'url' => 'http://www.google.com', 'colour' => '#00FF00'));
          $cloud->addWord(array('word' => 'digg', 'size' => 3, 'url' => 'http://digg.com', 'colour' => '#0000FF'));
          $cloud->addWord(array('word' => 'lotsofcode', 'size' => 4, 'url' => 'http://www.lotsofcode.com', 'colour' => '#FFFF00'));
          $cloud->setLimit(2);
          echo $cloud->showCloud();	
        ?>
      </div>
      <h4>Code Example</h4>
      <textarea>&lt;?php
$cloud = new wordCloud();
$cloud-&gt;addWord(array('word' =&gt; 'php', 'size' =&gt; 1, 'url' =&gt; 'http://www.php.net', 'colour' =&gt; '#FF0000'));
$cloud-&gt;addWord(array('word' =&gt; 'google', 'size' =&gt; 2, 'url' =&gt; 'http://www.google.com', 'colour' =&gt; '#00FF00'));
$cloud-&gt;addWord(array('word' =&gt; 'digg', 'size' =&gt; 3, 'url' =&gt; 'http://digg.com', 'colour' =&gt; '#0000FF'));
$cloud-&gt;addWord(array('word' =&gt; 'lotsofcode', 'size' =&gt; 4, 'url' =&gt; 'http://www.lotsofcode.com', 'colour' =&gt; '#FFFF00'));
$cloud-&gt;setLimit(2);
echo $cloud-&gt;showCloud();	
?&gt;</textarea>
      <!-- e: basic example w/ limit -->
      <br /><br />
      
      <!-- b: basic example with ordering -->
      <h3>Order Results Example</h3>
      <p>This is a basic example of how you can impliment a tag-cloud into your website and order the output of the results</p>
      <div class="word-cloud">
      <?php
        // Initite the basic object
        $cloud = new wordCloud();
        // Basic Add Option
        $cloud->addWord('php');
        $cloud->addWord('google');
        $cloud->addWord('digg');
        $cloud->addWord('lotsofcode');
        // Advanced Add Option
        $cloud->orderBy('size', 'desc'); // Add Order to the cloud
        echo $cloud->showCloud();
      ?>
      <br /><br />
      </div>
      <h4>Code Example</h4>
      <textarea>&lt;?php
$cloud = new wordCloud();
$cloud-&gt;addWord('php');
$cloud-&gt;addWord('google');
$cloud-&gt;addWord('digg');
$cloud-&gt;addWord('lotsofcode');
$cloud-&gt;orderBy('size', 'desc'); // Add Order to the cloud
echo $cloud-&gt;showCloud();
?&gt;</textarea>
      <!-- e: basic example -->
      
      <br /><br />
      
      <!-- b: basic example w/ Ignore List -->
      <h3>Example w/ Ignore List</h3>
      <p>This is a basic example of how you can impliment a tag-cloud into your website with the option to ignore certain tags</p>
      <div class="word-cloud">
        <?php
          // Initite the basic object
          $cloud = new wordCloud();
          $cloud->addWord(array('word' => 'php', 'size' => 1, 'url' => 'http://www.php.net', 'colour' => '#FF0000'));
          $cloud->addWord(array('word' => 'google', 'size' => 2, 'url' => 'http://www.google.com', 'colour' => '#00FF00'));
          $cloud->addWord(array('word' => 'digg', 'size' => 3, 'url' => 'http://digg.com', 'colour' => '#0000FF'));
          $cloud->addWord(array('word' => 'lotsofcode', 'size' => 4, 'url' => 'http://www.lotsofcode.com', 'colour' => '#FFFF00'));
          $cloud->removeWord('digg');
          $cloud->removeWord('google');
          echo $cloud->showCloud();	
        ?>
      </div>
      <h4>Code Example</h4>
      <textarea>&lt;?php
require 'classes/wordcloud.class.php';
$cloud = new wordCloud();
$cloud-&gt;addWord(array('word' =&gt; 'php', 'size' =&gt; 1, 'url' =&gt; 'http://www.php.net', 'colour' =&gt; '#FF0000'));
$cloud-&gt;addWord(array('word' =&gt; 'google', 'size' =&gt; 2, 'url' =&gt; 'http://www.google.com', 'colour' =&gt; '#00FF00'));
$cloud-&gt;addWord(array('word' =&gt; 'digg', 'size' =&gt; 3, 'url' =&gt; 'http://digg.com', 'colour' =&gt; '#0000FF'));
$cloud-&gt;addWord(array('word' =&gt; 'lotsofcode', 'size' =&gt; 4, 'url' =&gt; 'http://www.lotsofcode.com', 'colour' =&gt; '#FFFF00'));
$cloud-&gt;removeWord('digg');
$cloud-&gt;removeWord('google');
echo $cloud-&gt;showCloud();	
?&gt;</textarea>
      <!-- e: basic example w/ Ignore List -->
      <br /><br />
      <!-- b: basic example w/ Mysql Database -->
      <h3>Example w/ MySQL Database Example</h3>
      <p>This is how you can include this script into a MySql result set.</p>
<textarea style="height: 300px">&lt;?
$cloud = new wordCloud();
$getBooks = mysql_query(&quot;SELECT title FROM `tags`&quot;);
if ($getBooks)
{
  &nbsp;while ($rowBooks = mysql_fetch_assoc($getBooks))
  &nbsp;{
    &nbsp;&nbsp;$cloud-&gt;addWord($rowBooks['title']);
  &nbsp;}
}
$myCloud = $cloud-&gt;showCloud('array');
if (is_array($myCloud))
{
  &nbsp;foreach ($myCloud as $key =&gt; $value)
  &nbsp;{
  &nbsp;&nbsp;echo ' &lt;a href=&quot;./tags/'.urlencode($value['word']).'&quot; style=&quot;font-size: 1.'.($value['range']).'em&quot;&gt;'.$value['word'].'&lt;/a&gt; ';
  &nbsp;}
}
?&gt;
</textarea>
      <!-- e: basic example w/ Mysql Database -->
      <br /><br />
      <!-- b: basic example w/ FlatFile -->
      <h3>Example w/ FlatFile</h3>
      <p>This is how you can include this script into a FlatFile txt file.</p>
      
      <textarea style="height: 300px;">&lt;?php
require 'classes/wordcloud.class.php';
$cloud = new wordCloud();
$f = 'tags.txt'; // Filename of the text file
$s = '|'; // The char that seperates the tags
if ($h = fopen($f, 'r')) {
  if (!feof($h)) {
    do {
      $c = fread($h, 4096);
      $t = explode($s, $c);
      foreach ($t as $k =&gt; $v) {
        $cloud-&gt;addWord($v);
      }
    } while (!feof($h));
  }
}
echo $cloud-&gt;showCloud();
?&gt;
      </textarea>
      <!-- e: basic example w/ FlatFile -->
    </form>
    </div>
  </body>
</html>
