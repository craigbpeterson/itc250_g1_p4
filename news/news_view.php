<?php
/**
 * news_view.php along with index.php provides a list/view application for RSS news feeds
 * 
 * @package RSSNews (the Feed class has not moved out of this document yet)
 * @author Craig Peterson <craig.b.peterson@gmail.com>
 * @version .2 2018/06/06
 * @link http://craigpeterson.video/
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
	myRedirect(VIRTUAL_PATH . "news/index.php");
}

//create new instance of Feed object based on id from query string
$myFeed = new Feed($myID);

//dumpDie($myFeed);

if($myFeed->IsValid)
{#only load data if record found
	$config->titleTag = $myFeed->Title . " | RSS Feeds made with PHP & love!"; #overwrite
}

if(!isset($_SESSION)){
    session_start();
}

if(isset($_GET['clearCache'])){
    unset($_SESSION['FeedID' . $myID]);
}

//get rss feed xml from session cache or from source
if((!isset($_SESSION['FeedID' . $myID])) || ((time() - $_SESSION['FeedID' . $myID . 'CacheTime']) > 600)) {
    $feedXML = $myFeed->FeedURL; //get rss XML url string from Feed object
    $xml = simplexml_load_file($feedXML);//get RSS XML file from source and convert to object
    $_SESSION['FeedID' . $myID] = $xml->asXML(); //convert XML object to serialized string and save to SESSION cache
    $_SESSION['FeedID' . $myID . 'CacheTime'] = time();
}else{
    $xml = new SimpleXMLElement($_SESSION['FeedID' . $myID]); //retrieve XML serialized string from SESSION cache and convert back to XML object    
}

//dumpDie($_GET);
//dumpDie($_SESSION);
//dumpDie($xml);

//parse the news items
$feedItems = $xml->xPath('/rss/channel/item');

//format session cache date and time
$feedCacheTime = date('F j, Y \a\t g:ia', $_SESSION['FeedID' . $myID . 'CacheTime']); //date format example: June 6, 2018 at 1:39pm

//dumpDie($feedCacheTime);
//dumpDie($feedItems);

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php

echo '
    <h3 align="center">' . $myFeed->Title . '</h3>
    <p align="center">' . $myFeed->Description . '</p>
    <p align="center">Feed cached at: ' . $feedCacheTime . ' [ <a href="?id=' . $myID . '&clearCache=true">Clear cache and reload</a> ]</p>
';
    
if($myFeed->IsValid)
{//show data
    
    //start bootswatch list group
    echo '
        <div class="list-group">
    ';
    
    foreach($feedItems as $item){
        echo '
            <a href="' . $item->link . '" class="list-group-item list-group-item-action flex-column align-items-start" target="_blank" style="overflow:auto;">
                <div class="d-flex w-100 justify-content-between">
                    <img src="' . $item->enclosure->attributes()->url . '" style="width:150px;float:left;margin-right:1rem;"/>
                    <h4 style="margin-bottom:0;">' . $item->title . '</h4>
                    <small>' . $item->pubDate . '</small>
                </div>
                <p style="margin:1rem 0;">' . $item->description . '</p>
            </a>
        ';
    }//end foreach loop
    
    //end bootswatch list group
    echo '
        </div>
    ';
    
}else{//problem!
    echo '
    <div>No such Feed!</div>
    ';
}

get_footer(); #defaults to theme footer or footer_inc.php


class Feed
{
    public $FeedID = 0;
    public $FeedURL = '';
    public $Title = '';
    public $Description = '';
    public $Category = '';
    public $CategoryDescription = '';
    public $IsValid = 'false';
        
    public function __construct($id)
    {
        $this->FeedID = (int)$id;
        
        $sql = '
        select 
            sp18_rss_feeds.FeedURL, 
            sp18_rss_feeds.Title, 
            sp18_rss_feeds.Description, 
            sp18_rss_categories.Category,
            sp18_rss_categories.Description as CategoryDescription
        from sp18_rss_feeds 
        join sp18_rss_categories on sp18_rss_feeds.RSSCategoryID = sp18_rss_categories.RSSCategoryID
        where FeedID = ' . $this->FeedID;
        
        # connection comes first in mysqli (improved) function
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
        
        if(mysqli_num_rows($result) > 0)
        {#records exist - process
            $this->IsValid = true;
            while ($row = mysqli_fetch_assoc($result))
            {
                $this->FeedURL = dbOut($row['FeedURL']);
                $this->Title = dbOut($row['Title']);
                $this->Description = dbOut($row['Description']);
                $this->Category = dbOut($row['Category']);
                $this->CategoryDescription = dbOut($row['CategoryDescription']);
            }
        }
    }//end of Feed Constructor
    
}//end of Feed Class
