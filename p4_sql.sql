SET foreign_key_checks = 0; #turn off constraints temporarily

CREATE TABLE sp18_rss_categories(
RSSCategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
Category VARCHAR(255) DEFAULT '',
Description TEXT DEFAULT '',
PRIMARY KEY (RSSCategoryID)
)ENGINE=INNODB;

#add the category records:
INSERT INTO sp18_rss_categories VALUES (NULL,'NASA','News from NASA.gov');
INSERT INTO sp18_rss_categories VALUES (NULL,'Star Trek','Popular Star Trek related news');
INSERT INTO sp18_rss_categories VALUES (NULL,'Travel','Travel news and blogs');

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
    'https://blogs.nasa.gov/stationreport/feed/',
    'International Space Station Reports',
    'What\'s happening on the ISS as it zips around the Earth at 4.76 miles per second.',
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

#Star Trek
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    2,
    'http://hailingfrequency.com/podcast.xml',
    'Star Trek Podcast Feed',
    'This is our most important feed, the podcast. Everytime we release a new podcast or special transmission, you will be instantly notified so you can download it in all of its glory!',
    NOW(),
    NOW()
);
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    2,
    'http://www.hailingfrequency.com/boards/index.php?type=rss;action=.xml;sa=news;boards=3.0,26.0;limit=20',
    'General Star Trek Gaming News',
    'This feed contains ANY Star Trek Gaming News, fan game news, official game news and of course, Star Trek Online.',
    NOW(),
    NOW()
);
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    2,
    'http://www.hailingfrequency.com/boards/index.php?type=rss;action=.xml;sa=news;boards=26.0;limit=20',
    'General Star Trek Gaming News',
    'This feed only contains news and information about Star Trek Online. Any other news will not be included in this feed at all.',
    NOW(),
    NOW()
);

#Travel
INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    3,
    'http://www.vagabondish.com/feed/',
    'Vagabondish',
    'Dubious tips and essential ephemera for today\'s curious traveler.',
    NOW(),
    NOW()
);

INSERT INTO sp18_rss_feeds VALUES (
    NULL,
    3,
    'https://aboomerstravels.wordpress.com/feed/',
    'A Boomer\'s Travels',
    'Sleep with the Stars ~ Sail with the Wind ~ Walk in Peace',
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