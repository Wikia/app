-- Table content_review_status
DROP TABLE IF EXISTS content_review_status;
CREATE TABLE content_review_status (
  review_id       INT unsigned      NOT NULL  AUTO_INCREMENT,
  wiki_id         INT unsigned      NOT NULL,
  page_id         INT unsigned      NOT NULL,
  revision_id     INT unsigned      NOT NULL,
  status          SMALLINT unsigned NOT NULL,
  submit_user_id  INT unsigned      NOT NULL,
  submit_time     DATETIME          NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  review_user_id  INT unsigned      NULL,
  review_time     DATETIME          NULL,
  CONSTRAINT content_review_status_pk PRIMARY KEY (review_id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE INDEX content_review_status_wiki_id_idx ON content_review_status (wiki_id);
CREATE INDEX content_review_status_page_id_idx ON content_review_status (page_id);
CREATE INDEX content_review_status_idx         ON content_review_status (status);

-- Table current_reviewed_revisions
DROP TABLE IF EXISTS current_reviewed_revisions;
CREATE TABLE current_reviewed_revisions (
  wiki_id     INT unsigned NOT NULL,
  page_id     INT unsigned NOT NULL,
  revision_id INT unsigned NOT NULL,
  touched     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY page_id (wiki_id, page_id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
