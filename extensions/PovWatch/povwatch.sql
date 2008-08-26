
-- Log of watchlist pushes
CREATE TABLE /*$wgDBprefix*/povwatch_log (
  -- Primary key
  pwl_id INT NOT NULL AUTO_INCREMENT,

  -- Standard format timestamp
  pwl_timestamp CHAR(14) NOT NULL,

  -- Title of the article pushed
  pwl_namespace INT NOT NULL,
  pwl_title VARCHAR(255) NOT NULL,

  -- User doing the pushing
  pwl_user INT NOT NULL,

  -- Informational text comment
  pwl_comment TINYBLOB NOT NULL,

  PRIMARY KEY (pwl_id),
  INDEX (pwl_timestamp)
) TYPE=InnoDB;

-- List of subscribers
CREATE TABLE /*$wgDBprefix*/povwatch_subscribers (
  -- Link to user_id
  pws_user INT NOT NULL,
  PRIMARY KEY (pws_user)
) TYPE=InnoDB;
