-- Rename misnamed fields

ALTER TABLE /*$wgDBprefix*/collabwatchlist
  CHANGE rl_id cw_id integer unsigned  NOT NULL AUTO_INCREMENT;
ALTER TABLE /*$wgDBprefix*/collabwatchlist
  CHANGE rl_name cw_name varbinary(255) NOT NULL;
ALTER TABLE /*$wgDBprefix*/collabwatchlist
  CHANGE rl_start cw_start binary(14) NOT NULL default '';

ALTER TABLE /*$wgDBprefix*/collabwatchlistrevisiontag
  CHANGE rl_id cw_id integer unsigned NOT NULL;
  
ALTER TABLE /*$wgDBprefix*/collabwatchlisttag
  CHANGE rl_id cw_id integer unsigned NOT NULL;
  
ALTER TABLE /*$wgDBprefix*/collabwatchlistuser
  CHANGE rl_id cw_id integer unsigned NOT NULL;
  
ALTER TABLE /*$wgDBprefix*/collabwatchlistcategory
  CHANGE rl_id cw_id integer unsigned NOT NULL;
