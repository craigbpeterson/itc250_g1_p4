SET foreign_key_checks = 0; #turn off constraints temporarily

DROP TABLE IF EXISTS `sp18_rss_categories`;
CREATE TABLE sp18_rss_categories(
RSSCategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
Category VARCHAR(255) DEFAULT '',
Description TEXT DEFAULT '',
PRIMARY KEY (RSSCategoryID)
)ENGINE=INNODB;

#add the category records:
INSERT INTO sp18_rss_categories VALUES (NULL,'NASA','News from NASA.gov');
INSERT INTO sp18_rss_categories VALUES (NULL,'Business','Business news from around the web');
INSERT INTO sp18_rss_categories VALUES (NULL,'Travel','Travel news from around the web');

DROP TABLE IF EXISTS `sp18_rss_feeds`;
CREATE TABLE sp18_rss_feeds(
FeedID INT UNSIGNED NOT NULL AUTO_INCREMENT,
RSSCategoryID INT UNSIGNED DEFAULT 0,
FeedURL VARCHAR(255) DEFAULT '',
Title VARCHAR(255) DEFAULT '',
Description TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (FeedID),
FOREIGN KEY (RSSCategoryID) REFERENCES sp18_rss_categories(RSSCategoryID) ON DELETE CASCADE
)ENGINE=INNODB; 


#add the feed records:

#NASA
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    1,
    'https://www.nasa.gov/rss/dyn/breaking_news.rss',
    'NASA Breaking News',
    'A RSS news feed containing the latest NASA news articles and press releases.',
    NOW(),
    NOW()
);
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    1,
    'https://www.nasa.gov/rss/dyn/lg_image_of_the_day.rss',
    'Image of the Day',
    'Daily Image from Nasa',
    NOW(),
    NOW()
);
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    1,
    'https://www.nasa.gov/rss/dyn/solar_system.rss',
    'Solar System and Beyond',
    'A RSS news feed containing the latest NASA press releases on missions exploring our solar system and beyond.',
    NOW(),
    NOW()
);

#Business
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    2,
    'https://www.huffingtonpost.com/section/business/feed',
    'Huffington Post Business',
    'The latest news about Business from Huffington Post',
    NOW(),
    NOW()
);
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    2,
    'http://feeds.nbcnews.com/nbcnews/public/business',
    'NBC News Business',
    'The latest business news from NBC News',
    NOW(),
    NOW()
);
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    2,
    'http://rss.nytimes.com/services/xml/rss/nyt/Business.xml',
    'New York Times Business',
    'Business news from the New York Times.',
    NOW(),
    NOW()
);

#Travel
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    3,
    'https://www.huffingtonpost.com/section/travel/feed',
    'Huffington Post Travel',
    'Travel stories, advice and featured articles for travelers.',
    NOW(),
    NOW()
);

INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    3,
    'http://feeds.nbcnews.com/nbcnews/public/travel',
    'NBC News Travel',
    'The latest travel news from NBC News',
    NOW(),
    NOW()
);

INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    3,
    'http://rss.nytimes.com/services/xml/rss/nyt/Travel.xml',
    'New York Times Travel',
    'Travel news from the New York Times.',
    NOW(),
    NOW()
);

SET foreign_key_checks = 1; #turn on constraints