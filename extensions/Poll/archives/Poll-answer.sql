-- (c) Jan Luca, 2009, CC by-sa 3.0 or later
-- Table structure for table `Poll`
-- Replace /*$wgDBprefix*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

CREATE TABLE /*$wgDBprefix*/poll_answer (
`pid` INT( 10 ) NOT NULL ,
`uid` INT( 10 ) NOT NULL ,
`vote` VARCHAR( 255 ) NOT NULL
) /*$wgDBTableOptions*/;