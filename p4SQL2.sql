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

#Travel
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    3,
    'https://www.huffingtonpost.com/section/travel/feed',
    'Huffington Post',
    'Travel stories, advice and featured articles for travelers.',
    NOW(),
    NOW()
);

INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    3,
    'https://www.10best.com/interests/rss/',
    '10best.com',
    'Travel lifestyle - news and information',
    NOW(),
    NOW()
);

INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    3,
    'https://www.alexinwanderland.com/feed/',
    'Alex in Wanderland',
    'Working and playing around the world.',
    NOW(),
    NOW()
);


SET foreign_key_checks = 1; #turn on constraints