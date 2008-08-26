CREATE TABLE feeditem(
  fi_feed VARCHAR(255),
  fi_date CHAR(14),
  fi_title TEXT,
  fi_content TEXT,
  fi_url TEXT,
  fi_author TEXT,
  fi_comments TEXT,
  KEY (fi_feed,fi_date)
) TYPE=InnoDB;

CREATE TABLE feed (
  feed_group VARCHAR(128),
  feed_url VARCHAR(255),
  feed_touched CHAR(14),
  UNIQUE KEY (feed_group,feed_url)
) TYPE=InnoDB;
