<?php
/**
 * survey_view.php along with index.php provides a list/view application and a start to our survey app
 * 
 * @package SurveySez/news
 * @author Christy Thom <christyraethom@gmail.com>
 * @version 0.1 2018/05/22
 * @link http://christyraedesigns.com/sp-18-client/surveys
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to index.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "news.php");
}

//sql statement to select individual item
//$sql = "select MuffinName,Description,MetaDescription,MetaKeywords,Price from test_Muffins where MuffinID = " . $myID;

//---end config area --------------------------------------------------

$myPager = new Pager($myID);

//dumpDie($myPager);

if($myPager->IsValid)
{#only load data if record found
	$config->titleTag = $myPager->Title . " RSS News Feeds made with love & PHP in Seattle"; #overwrite 
}

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
    
echo '<h3 align="center">' . $myPager->Title . ' News Feed</h3>';    

if($myPager->IsValid)
{//show data
   echo '<div>News Description: ' . $myPager->FeedDescription . '</div>'; 
}else{//problem!
   echo '<div>No News Feeds</div>';
}    

get_footer(); #defaults to theme footer or footer_inc.php

class Survey
{
    public $FeedID = 0;
    public $Title = '';
    public $FeedDescription = '';
    public $IsValid = false;
   
    
    public function __construct($id){
        $this->FeedID = (int)$id;
        
        $sql = "select * from sp18_rss_feeds where FeedID = " . $this->FeedID;
   
        # connection comes first in mysqli (improved) function
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
               $this->IsValid = true;	
               while ($row = mysqli_fetch_assoc($result))
               {
                    $this->Title = dbOut($row['Title']);
                    $this->Description = dbOut($row['FeedDescription']);
               }
        }

        @mysqli_free_result($result); # We're done with the data!
        
        //START RSSFEEDS HERE
        
        $sql = "select * from sp18_rss_feeds where SurveyID = " . $this->FeedID;
   
        # connection comes first in mysqli (improved) function
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
               while ($row = mysqli_fetch_assoc($result))
               {
                    //$this->Title = dbOut($row['Title']);
                    //$this->Description = dbOut($row['Description']);
                   $this->Feeds[] = new Feed((int)$row['FeedID'],dbOut($row['FeedURL']),dbOut($row['FeedDescription']));
               }
        }

        @mysqli_free_result($result); # We're done with the data!
        
        
        //END FEED HERE

    }//end Feed constructor
    
}//end Feed class

/*

QuestionID	int(10) unsigned Auto Increment	 
SurveyID	int(10) unsigned NULL [0]	 
Question	text NULL	 
Description	text NULL	 
DateAdded	datetime NULL	 
LastUpdated	timestamp NULL [0000-00-00 00:00:00]

FeedID	int(10) unsigned Auto Increment	 
RSSCategoryID	int(10) unsigned NULL [0]	 
FeedURL	varchar(255) NULL []	 
Title	varchar(255) NULL []	 
Description	text NULL	 
DateAdded	datetime NULL	 
LastUpdated	timestamp NULL [0000-00-00 00:00:00]

*/
class Question{
    public $FeedID = 0;
    public $FeedURL = '';
    public $FeedDescription = '';
    
    public function __construct($FeedID,$FeedURL,$FeedDescription){
        $this->FeedID = (int)$FeedID;
        $this->FeedURL = $FeedURL;
        $this->Description = $FeedDescription;
    }//end Feed constructor
    
}//end Feed Class
