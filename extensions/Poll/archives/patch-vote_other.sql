-- (c) Jan Luca, 2009, CC by-sa 3.0 or later
-- Patch for table `Poll-answer`
-- Replace /*$wgDBprefix*/ with the proper prefix

ALTER TABLE /*$wgDBprefix*/poll_answer 
ADD `isset_vote_other` INT( 1 ) NOT NULL ;

ALTER TABLE /*$wgDBprefix*/poll_answer 
ADD `vote_other` VARCHAR( 255 ) NOT NULL ;