CREATE TABLE dataware.video_migration_log (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  action_time CHAR(14) NOT NULL,
  wiki_id INT NOT NULL,
  action_name VARCHAR(255) NOT NULL,
  action_status VARCHAR(255) NOT NULL,
  action_desc VARCHAR(255) NOT NULL,
  primary key (id)
);
CREATE index city_id on dataware.video_migration_log (wiki_id, action_time);
