CREATE TABLE /*_*/blanked_page (
blank_id                     int NOT NULL AUTO_INCREMENT,
blank_page_id                int UNSIGNED NOT NULL,
blank_user_id                int UNSIGNED NOT NULL,
blank_user_name              varchar(256),
blank_timestamp              varbinary(14),
blank_summary                varchar(256),
blank_parent_id              int UNSIGNED,
PRIMARY KEY (blank_id)
) /*$wgDBTableOptions*/;

CREATE INDEX blank_id ON          /*_*/blanked_page (blank_id);
CREATE INDEX blank_page_id ON     /*_*/blanked_page (blank_page_id);
CREATE INDEX blank_user_id ON     /*_*/blanked_page (blank_user_id);
CREATE INDEX blank_user_name ON   /*_*/blanked_page (blank_user_name);
CREATE INDEX blank_timestamp ON   /*_*/blanked_page (blank_timestamp);