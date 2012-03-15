CREATE TABLE dataware.video_sanitization_failededit (
  id INT unsigned NOT NULL AUTO_INCREMENT,
  city_id INT NOT NULL,
  city_name VARCHAR(255) NOT NULL,
  article_id INT NOT NULL,
  article_title VARCHAR(255) NOT NULL,
  article_namespace INT NOT NULL,
  rename_from VARCHAR(255) NOT NULL,
  rename_to VARCHAR(255) NOT NULL,
  primary key (id)
);
CREATE index city_id on dataware.video_sanitization_failededit (city_id);

// ALTER TABLE dataware.video_sanitization_failededit ADD city_name VARCHAR(255) NOT NULL;
// ALTER TABLE dataware.video_sanitization_failededit ADD article_namespace INT NOT NULL;