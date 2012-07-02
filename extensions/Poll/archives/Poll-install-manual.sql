-- (c) Jan Luca, 2009, CC by-sa 3.0 or later
-- Table structure for manual installing
-- Replace /*$wgDBprefix*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

CREATE TABLE /*$wgDBprefix*/poll (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`question` VARCHAR( 255 ) NOT NULL ,
`alternative_1` VARCHAR( 255 ) NOT NULL ,
`alternative_2` VARCHAR( 255 ) NOT NULL ,
`alternative_3` VARCHAR( 255 ) NOT NULL ,
`alternative_4` VARCHAR( 255 ) NOT NULL ,
`alternative_5` VARCHAR( 255 ) NOT NULL ,
`alternative_6` VARCHAR( 255 ) NOT NULL
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/poll_answer (
`pid` INT( 10 ) NOT NULL ,
`uid` INT( 10 ) NOT NULL ,
`vote` VARCHAR( 255 ) NOT NULL
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/poll_start_log (
`time` INT( 30 ) NOT NULL
) /*$wgDBTableOptions*/;


-- New fields for poll

ALTER TABLE /*$wgDBprefix*/poll 
ADD `creater` VARCHAR( 255 ) NOT NULL;

ALTER TABLE /*$wgDBprefix*/poll 
ADD `dis` VARCHAR( 255 ) NOT NULL ;

ALTER TABLE /*$wgDBprefix*/poll 
ADD `multi` INT( 1 ) NOT NULL ;

ALTER TABLE /*$wgDBprefix*/poll 
ADD `ip` INT( 1 ) NOT NULL ;


-- New fields for poll_answer

ALTER TABLE /*$wgDBprefix*/poll_answer 
ADD `user` VARCHAR( 255 ) NOT NULL ;

ALTER TABLE /*$wgDBprefix*/poll_answer 
ADD `isset_vote_other` INT( 1 ) NOT NULL ;

ALTER TABLE /*$wgDBprefix*/poll_answer 
ADD `vote_other` VARCHAR( 255 ) NOT NULL ;

ALTER TABLE /*$wgDBprefix*/poll_answer 
ADD `ip` VARCHAR( 255 ) NOT NULL ;