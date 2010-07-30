

# Create needed table.  Please add so that this can be automatically added by update.php.
CREATE TABLE `blog_listing_relation` (
  `blr_relation` varbinary(255) NOT NULL default '',
  `blr_title` varbinary(255) NOT NULL default '',
  `blr_type` enum('cat','user') default NULL,
  UNIQUE KEY `wl_user` (`blr_relation`,`blr_title`,`blr_type`),
  KEY `type_relation` (`blr_relation`,`blr_type`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
