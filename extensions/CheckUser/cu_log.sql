-- CheckUser log table
-- vim: autoindent syn=mysql sts=2 sw=2

CREATE TABLE /*$wgDBprefix*/cu_log (
  -- Unique identifier
  cul_id int unsigned not null auto_increment,
  
  -- Timestamp of CheckUser action
  cul_timestamp binary(14) not null,

  -- User who performed the action
  cul_user int unsigned not null,
  cul_user_text varchar(255) binary not null,

  -- Reason given
  cul_reason varchar(255) binary not null,

  -- String indicating the type of query, may be "userips", "ipedits", "ipusers", "ipedits-xff", "ipusers-xff"
  cul_type varbinary(30) not null,

  -- Integer target, interpretation depends on cul_type
  -- For username targets, this is the user_id
  cul_target_id int unsigned not null default 0,

  -- Text target, interpretation depends on cul_type
  cul_target_text blob not null default '',

  -- If the target was an IP address, this contains the hexadecimal form of the IP
  cul_target_hex varbinary(255) not null default '',
  -- If the target was an IP range, these fields contain the start and end, in hex form
  cul_range_start varbinary(255) not null default '',
  cul_range_end varbinary(255) not null default '',

  PRIMARY KEY (cul_id),
  INDEX (cul_timestamp),
  INDEX cul_user (cul_user, cul_timestamp),
  INDEX cul_type_target (cul_type,cul_target_id, cul_timestamp),
  INDEX cul_target_hex (cul_target_hex, cul_timestamp),
  INDEX cul_range_start (cul_range_start, cul_timestamp)

) /*$wgDBTableOptions*/;

