-- This stores user rating data for revisions
CREATE TABLE /*$wgDBprefix*/validate (
  val_id int(10) NOT NULL auto_increment,
  val_user int(10) NOT NULL,
  val_page int(10) NOT NULL,
  val_revision int(10) NOT NULL,
  val_type int NOT NULL,
  val_value int(2) NOT NULL,
  val_comment varchar(255) NOT NULL default '',
  val_ip varchar(255) NULL default '',

  PRIMARY KEY (val_id),
  UNIQUE KEY (val_user,val_revision,val_type),
  UNIQUE KEY (val_ip,val_revision,val_type)
) TYPE=InnoDB;