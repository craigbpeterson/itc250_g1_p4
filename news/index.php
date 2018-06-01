<?php
/**
 * index.php along with news_view.php provides a list/view application and a start to our rss news feed app
 *
 * @package SurveySez
 * @author Craig Peterson <craig.b.peterson@gmail.com>
 * @version .2 2018/06/01
 * @link http://craigpeterson.video/itc250/sp18_surveysez/
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see news_view.php
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
$sql = 
"
select c.RSSCategoryID, c.Category, c.Description as CategoryDescription, f.FeedID, f.FeedURL, f.Title, f.Description as FeedDescription, 
date_format(f.DateAdded, '%W %D %M %Y %H:%i') 'DateAdded' from " . PREFIX . "rss_categories c, " . PREFIX . "rss_feeds f where c.RSSCategoryID=f.RSSCategoryID
";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'RSS News Feeds made with love & PHP in Seattle';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC250 RSS News Feeds are made with pure PHP! ' . $config->metaDescription;
$config->metaKeywords = 'RSS News Feeds,PHP,Fun,'. $config->metaKeywords;

//adds font awesome icons for arrows on pager
$config->loadhead .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php

echo '<h3 align="center">RSS News Feeds</h3>';

#images in this case are from font awesome
$prev = '<i class="fa fa-chevron-circle-left"></i>';
$next = '<i class="fa fa-chevron-circle-right"></i>';

# Create instance of new 'pager' class
$myPager = new Pager(10,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	//if($myPager->showTotal()==1){$itemz = "survey";}else{$itemz = "surveys";}  //deal with plural
    //echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
    
    $prev = null;
    
	while($row = mysqli_fetch_assoc($result))
	{# process each row
        
        if($prev == null){//if first row, display category name and description and start table
        echo '
        <h4>' . dbOut($row['Category']) . ': <small class="text-info"> ' . dbOut($row['CategoryDescription']) . '</small></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date Added</th>
                </tr>
            </thead>
            <tbody>';
        }
        
        if($prev['Category'] != $row['Category'] && $prev != null){//finish previous table, display next category name and description, and start new table
        echo '
            </tbody>
        </table>
        <h4 style="margin-top:3em;">' . dbOut($row['Category']) . ': <small class="text-info"> ' . dbOut($row['CategoryDescription']) . '</small></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date Added</th>
                </tr>
            </thead>
            <tbody>';
        }
        
        //generate table row for each rss feed
        echo '
            <tr>
                <td><a href="' . VIRTUAL_PATH . 'news/news_view.php?id=' . (int)$row['FeedID'] . '">' . dbOut($row['Title']) . '</a></td>
                <td>' . dbOut($row['FeedDescription']) . '</td>
                <td>' . dbOut($row['DateAdded']) . '</td>
            </tr>
        ';
        
        $prev = $row; //set $prev to the row we just finished processing
        //var_dump($prev);
	}
    
    echo '
        </tbody>
    </table> 
    ';
    
	echo $myPager->showNAV(); # show paging nav, only if enough records	 
}else{#no records
    echo "<div align=center>There are currently no RSS feeds.</div>";	
}

@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
