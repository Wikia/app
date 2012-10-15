CREATE TABLE IF NOT EXISTS notificator (
  page_id int(10) NOT NULL,
  rev_id int(10) NOT NULL,
  receiver_email tinytext NOT NULL,
  PRIMARY KEY (page_id, rev_id, receiver_email(10))
);