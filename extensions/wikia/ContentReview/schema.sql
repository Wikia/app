-- Table content_for_review
DROP TABLE IF EXISTS content_review_status;
CREATE TABLE content_review_status (
  wiki_id         INT unsigned      NOT NULL,
  page_id         INT unsigned      NOT NULL,
  revision_id     INT unsigned      NOT NULL,
  status          SMALLINT unsigned NOT NULL,
  submit_user_id  INT unsigned      NOT NULL,
  submit_time     TIMESTAMP         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  review_user_id  INT unsigned      NULL,
  review_start    TIMESTAMP         NULL,
  escalated       BOOLEAN           NOT NULL DEFAULT 0,
  UNIQUE KEY page_id (wiki_id, page_id, revision_id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE INDEX content_review_status_idx         ON content_review_status (status);
CREATE UNIQUE INDEX content_review_unique_idx  ON content_review_status (wiki_id, page_id, status);

-- Table reviewed_content_logs
DROP TABLE IF EXISTS reviewed_content_logs;
CREATE TABLE reviewed_content_logs (
  wiki_id         INT unsigned      NOT NULL,
  page_id         INT unsigned      NOT NULL,
  revision_id     INT unsigned      NOT NULL,
  status          SMALLINT unsigned NOT NULL,
  submit_user_id  INT unsigned      NOT NULL,
  submit_time     TIMESTAMP         NOT NULL DEFAULT 0,
  review_user_id  INT unsigned      NOT NULL,
  review_start    TIMESTAMP         NOT NULL DEFAULT 0,
  review_end      TIMESTAMP         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  escalated       BOOLEAN           NOT NULL DEFAULT 0,
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- Table current_reviewed_revisions
DROP TABLE IF EXISTS current_reviewed_revisions;
CREATE TABLE current_reviewed_revisions (
  wiki_id     INT unsigned NOT NULL,
  page_id     INT unsigned NOT NULL,
  revision_id INT unsigned NOT NULL,
  touched     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY page_id (wiki_id, page_id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
