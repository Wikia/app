--
-- SQL schema for FBConnect extension
--

CREATE TABLE /*$wgDBprefix*/user_fbconnect (
  user_fbid BIGINT unsigned NOT NULL PRIMARY KEY,
  user_id int(10) unsigned NOT NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*$wgDBprefix*/user_fbconnect_user ON /*$wgDBprefix*/user_fbconnect(user_id);



CREATE TABLE fbconnect_event_stats (
  user_id int(10) unsigned NOT NULL,
  city_id int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  event_type ENUM('OnAddBlogPost', 'OnAddImage', 'OnAddVideo','OnArticleComment','OnBlogComment','OnLargeEdit','OnRateArticle','OnWatchArticle'));
