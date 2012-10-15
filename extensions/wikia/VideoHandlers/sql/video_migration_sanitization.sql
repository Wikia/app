/*
 * Table to log sanitization process, should not be needed after refactoring is complete
 * and verified to work ;)
 */


CREATE TABLE dataware.video_migration_sanitization (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  city_id INT NOT NULL,
  old_title VARCHAR(255) NOT NULL,
  sanitized_title VARCHAR(255) NOT NULL,
  operation_status CHAR(14) NOT NULL default 'UNKNOWN',
  operation_time CHAR(14) NOT NULL,
  article_title VARCHAR(255) NOT NULL,
  primary key (id)
);
CREATE unique index city_id on dataware.video_migration_sanitization (city_id, old_title);
CREATE index sanitized_title on dataware.video_migration_sanitization (sanitized_title);
