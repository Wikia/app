-- Tables used by the MediaWiki Wikilog extension.
--
-- You should not have to create these tables manually unless you are doing
-- a manual installation. In normal conditions, maintenance/update.php should
-- perform any needed database setup.
--

--
-- All existing wikilogs and associated metadata.
--
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/wikilog_wikilogs (
  -- Primary key, reference to wikilog front page article.
  wlw_page INTEGER UNSIGNED NOT NULL,

  -- Serialized PHP object representing the wikilog description or subtitle.
  wlw_subtitle BLOB NOT NULL,

  -- Image that provides iconic visual identification of the feed.
  wlw_icon VARCHAR(255) BINARY NOT NULL,

  -- Image that provides visual identification of the feed.
  wlw_logo VARCHAR(255) BINARY NOT NULL,

  -- Serialized PHP array of authors.
  wlw_authors BLOB NOT NULL,

  -- Last time the wikilog (including posts) was updated.
  wlw_updated BINARY(14) NOT NULL,

  PRIMARY KEY (wlw_page),
  INDEX wlw_updated (wlw_updated)

) /*$wgDBTableOptions*/;

--
-- All wikilog posts and associated metadata.
--
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/wikilog_posts (
  -- Primary key, reference to wiki article associated with this post.
  wlp_page INTEGER UNSIGNED NOT NULL,

  -- Parent wikilog.
  wlp_parent INTEGER UNSIGNED NOT NULL,

  -- Post title derived from page(page_title), in order to simplify indexing.
  wlp_title VARCHAR(255) BINARY NOT NULL,

  -- Either if the post was published or not.
  wlp_publish BOOL NOT NULL DEFAULT FALSE,

  -- If wlp_publish = TRUE, this is the date that the post was published,
  -- otherwise, it is the date of the last draft revision (for sorting).
  wlp_pubdate BINARY(14) NOT NULL,

  -- Last time the post was updated.
  wlp_updated BINARY(14) NOT NULL,

  -- Serialized PHP array of authors.
  wlp_authors BLOB NOT NULL,

  -- Serialized PHP array of tags.
  wlp_tags BLOB NOT NULL,

  -- Cached number of comments.
  wlp_num_comments INTEGER UNSIGNED,

  PRIMARY KEY (wlp_page),
  INDEX wlp_parent (wlp_parent),
  INDEX wlp_title (wlp_title),
  INDEX wlp_pubdate (wlp_pubdate),
  INDEX wlp_updated (wlp_updated)

) /*$wgDBTableOptions*/;

--
-- Authors of each post.
--
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/wikilog_authors (
  -- Reference to post wiki article which this author is associated to.
  wla_page INTEGER UNSIGNED NOT NULL,

  -- ID of the author of the post.
  wla_author INTEGER UNSIGNED NOT NULL,

  -- Name of the author of the post.
  wla_author_text VARCHAR(255) BINARY NOT NULL,

  PRIMARY KEY (wla_page, wla_author_text),
  INDEX wla_page (wla_page),
  INDEX wla_author (wla_author),
  INDEX wla_author_text (wla_author_text)

) /*$wgDBTableOptions*/;

--
-- Tags associated with each post.
--
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/wikilog_tags (
  -- Reference to post wiki article which this tag is associated to.
  wlt_page INTEGER UNSIGNED,

  -- Tag associated with the post.
  wlt_tag VARCHAR(255) BINARY NOT NULL,

  PRIMARY KEY (wlt_page, wlt_tag),
  INDEX wlt_tag (wlt_tag)

) /*$wgDBTableOptions*/;

--
-- Post comments.
--
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/wikilog_comments (
  -- Unique comment identifier, across the whole wiki.
  wlc_id INTEGER UNSIGNED auto_increment NOT NULL,

  -- Parent comment, for threaded discussion. NULL for top-level comments.
  wlc_parent INTEGER UNSIGNED,

  -- Thread history, used for sorting. An array of wlc_id values of all parent
  -- comments up to and including the current comment. Each id is padded with
  -- zeros to six digits ("000000") and joined with slashes ("/").
  wlc_thread VARBINARY(255) NOT NULL DEFAULT '',

  -- Reference to post wiki article which this comment is associated to.
  wlc_post INTEGER UNSIGNED NOT NULL,

  -- ID of the author of the comment, if a registered user.
  wlc_user INTEGER UNSIGNED NOT NULL,

  -- Name of the author of the comment.
  wlc_user_text VARCHAR(255) BINARY NOT NULL,

  -- Name used for anonymous (not logged in) posters.
  wlc_anon_name VARCHAR(255) BINARY,

  -- Comment status. For hidden or deleted comments, a placeholder is left
  -- with some description about what happened to the comment.
  wlc_status ENUM(
    'OK',               -- OK, comment is visible
    'PENDING',          -- Comment is pending moderation
    'DELETED'           -- Comment was deleted
  ) NOT NULL DEFAULT 'OK',

  -- Date and time the comment was first posted.
  wlc_timestamp BINARY(14) NOT NULL,

  -- Date and time the comment was edited for the last time.
  wlc_updated BINARY(14) NOT NULL,

  -- Wiki article that contains this comment, to allow editing, revision
  -- history and more. This should be joined with `page` and `text` to get
  -- the actual comment text.
  wlc_comment_page INTEGER UNSIGNED,

  PRIMARY KEY (wlc_id),
  INDEX wlc_post_thread (wlc_post, wlc_thread),
  INDEX wlc_timestamp (wlc_timestamp),
  INDEX wlc_updated (wlc_updated),
  INDEX wlc_comment_page (wlc_comment_page)

) /*$wgDBTableOptions*/;
