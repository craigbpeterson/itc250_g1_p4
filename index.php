<?php
/**
 * index.php is a model for largely static PHP pages 
 *
 * @package nmCommon
 * @author Christy Rae Thom <christyraethom@gmail.com>
 * @version 2.091 2011/06/17
 * @link http://christyraedesigns.com/sp-18-client
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see config_inc.php 
 * @todo none
 */
 
require 'inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
$config->titleTag = THIS_PAGE; #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php

//below you can add a link to a unique page to the existing nav as follows
//$config->nav1 = array("aboutus.php"=>"About Us") + $config->nav1; 
/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<div class="jumbotron" style="margin-top:.5em;">

       	<h2><em class="title"><?=$config->banner;?></em></h2>
	<p><em><?=$config->slogan;?></em>         

	<a href="surveys/index.php"  class="btn btn-primary btn-lg">Get Your Survey On!</a></p>

</div>

<div class="background">
<h1>Welcome To the Magic World of Surveys!!</h1>

<h2>At <em class="name">SurveySez!! </em>  We Take Our Surveys Seriously!! </h2>
<p class="home"> 
<img id="home" src="images/survey.png" alt="picture of survey checklist">
<em class="title">SurveySez!!</em> This phrase echoes to my mind the famous game show Family Feud!! How many times have you wondered what people were thinking about? Well we here at <em class="name">SurveySez!! </em>  live to embody the famous game show hosts of Family Feud and get <em>THE </em> most popular answer!! Come and play along and find out what the <em class="name">SurveySez!!</em> </p>


<p class="home">
<img id="home2" src="images/news.png" alt="picture of newspaper">   
We also have ALL the <em class="title">NEW NEWS</em> you could possibly want!! It's important to stay connected to all the latest news daily, our <em class="name">NEWS</em> page keeps you in touch with updates throughout the day!  Frequent visits to <em class="name">NEWS</em> will keep you in the know with all the latest and greatest updates on all the things that matter! 
    
    <a href="news.php" class="btn btn-primary btn-lg">Get Your NEW NEWS!</a></p>
    
</div>
<?php

//add a benchmarking note as follows:
//$config->benchNote = "Test From Index File!";

get_footer(); #defaults to theme header or footer_inc.php
?>
