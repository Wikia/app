-- (c) Jan Luca, 2009, CC by-sa 3.0 or later
-- Table structure for table `Poll`
-- Replace /*$wgDBprefix*/ with the proper prefix

ALTER TABLE /*$wgDBprefix*/poll_answer 
ADD `ip` VARCHAR( 255 ) NOT NULL ;