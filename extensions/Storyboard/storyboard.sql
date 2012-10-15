-- MySQL version of the database schema for the Storyboard extension.

CREATE TABLE /*$wgDBprefix*/storyboard (
  story_id                 INT(8) unsigned   NOT NULL auto_increment PRIMARY KEY,
  story_lang_code          VARCHAR(8)        NOT NULL,
  story_author_id          INT unsigned          NULL,
  story_author_name        VARCHAR(255)      NOT NULL,
  story_author_location    VARCHAR(255)      NOT NULL,
  story_author_occupation  VARCHAR(255)      NOT NULL,
  story_author_image       VARCHAR(255)          NULL,  -- TODO: find out if this is an acceptible way to refer to an image
  story_author_email       VARCHAR(255)      NOT NULL,
  story_hit_count          INT(8) unsigned   NOT NULL default '0',
  story_title              VARCHAR(255)      NOT NULL,
  story_text               MEDIUMBLOB        NOT NULL,
  story_modified           CHAR(14) binary   NOT NULL default '',
  story_created            CHAR(14) binary   NOT NULL default '',
  story_state              TINYINT           NOT NULL default '0',
  story_image_hidden       TINYINT           NOT NULL default '0'
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX story_title ON /*$wgDBprefix*/storyboard (story_title);
CREATE INDEX story_state_modified ON /*$wgDBprefix*/storyboard (story_state, story_modified);
CREATE INDEX story_modified_id ON /*$wgDBprefix*/storyboard (story_modified, story_id);