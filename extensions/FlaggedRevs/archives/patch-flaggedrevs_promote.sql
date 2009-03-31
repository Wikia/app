-- This stores user demotions and stats
CREATE TABLE /*$wgDBprefix*/flaggedrevs_promote (
  -- Foreign key to user.user_id
  frp_user_id int(10) NOT NULL,
  frp_user_params mediumblob NOT NULL default '',
  
  PRIMARY KEY (frp_user_id)
) /*$wgDBTableOptions*/;

