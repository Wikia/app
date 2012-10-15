-- allow copying to a particular dataset to be done by a particular virtual user
-- specify whom here. (this is optional, things will likely still work if this column is not present)

ALTER TABLE wikidata_sets ADD COLUMN virtual_user_id int(8) unsigned;

INSERT INTO `script_log` (`time`, `script_name`, `comment`) VALUES (NOW(), '35 Table changes for copying A.sql', "added virtual user id support for copying");
