-- Channel definition table
CREATE TABLE /*_*/sal_channel (
  salc_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  -- Code to access the channel by
  salc_code varbinary(255) NOT NULL,
  -- Human readable name
  salc_name varbinary(255) NOT NULL,

  PRIMARY KEY (salc_id)
)

CREATE UNIQUE INDEX /*i*/salc_code ON /*_*/sal_channel (salc_code)

-- Actual log entries
CREATE TABLE /*_*/sal_entry (
  sale_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  -- FK to sal_channel.salc_id
  sale_channel int(10) unsigned NOT NULL,
  -- FK to user.user_id
  sale_user int(10) unsigned NOT NULL DEFAULT '0',
  -- If sale_user is 0, this will be used as the user text
  sale_user_text varbinary(250) NOT NULL,
  -- Timestamp for the sal_entry
  sale_timestamp binary(14) NOT NULL,
  -- Entry text
  sale_comment blob NOT NULL,

  PRIMARY KEY (sale_id)
)