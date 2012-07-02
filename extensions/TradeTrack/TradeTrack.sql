-- Store mapping of i18n key of "trademark" to an ID
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/tradetrack_trademarks (
  -- Trademark Id
  tt_mark_id int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  -- Text (i18n key) for rating description
  tt_mark varchar(255) binary NOT NULL
) /*$wgDBTableOptions*/;

-- Default trademarks 
INSERT INTO /*$wgDBprefix*/tradetrack_trademarks (tt_mark) VALUES
	('wmf'),
	('wikipedia'),
	('wiktionary'),
	('wikiquote'),
	('wikibooks'),
	('wikiversity'),
	('wikispecies'),
	('wikisource'),
	('mediawiki'),
	('wikimediacommons'),
	('wikimediaincubator'),
	('wikinews'),
	('other') /*$wgDBTableOptions*/;
	
-- Store request data
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/tradetrack_requests (
  -- Request Id
  tt_request_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  -- This defines the purpose type flag (commercial, non-commercial, media)
  tt_purpose VARCHAR(200) NOT NULL DEFAULT "",
  -- This defines whether or not there is an existing agreement in place
  tt_agreement VARCHAR(200) NOT NULL DEFAULT "",
  -- Store the provided name
  tt_name VARCHAR(200) NOT NULL,
  -- Store the provided email
  tt_email VARCHAR(200) NOT NULL,
  -- Store the provided organization name
  tt_orgname VARCHAR(200) NOT NULL,
  -- Store the value set for "other" if selected
  tt_otherval VARCHAR(200) NULL,
  -- Store the phone number
  tt_phone VARCHAR(200) NOT NULL,
  -- MW Timestamp
  tt_timestamp BINARY(14) NOT NULL DEFAULT '',
  -- This stores the text describing how the marks will be used.
  tt_usage TEXT NOT NULL,
  -- This stores the user's mailing address.  It probably doesn't need to be this large.
  tt_mailingaddress TEXT NOT NULL
) /*$wgDBTableOptions*/;

-- Store individual mark data
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/tradetrack_mark_requests (
  -- Foreign key to tradetrack_requests.tt_request_id
  tt_request_id INT UNSIGNED NOT NULL,
  -- Foreign key to tradetrack_trademarks.tt_mark_id
  tt_mark_id INT UNSIGNED NOT NULL,
  -- MW Timestamp
  tt_timestamp BINARY(14) NOT NULL DEFAULT '',

  PRIMARY KEY (tt_request_id, tt_mark_id, tt_timestamp)
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/tt_mark_connection ON /*_*/tradetrack_mark_requests (tt_request_id);





