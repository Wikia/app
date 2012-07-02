CREATE TABLE /*$wgDBprefix*/reflect_bullet_current (
	blc_id mediumint(9) NOT NULL AUTO_INCREMENT,

	bl_id mediumint(9),
	comment_id mediumint(9),
	bl_rev_id mediumint(9),
	
	PRIMARY KEY blc_id (blc_id),
	FOREIGN KEY (comment_id) REFERENCES /*$wgDBprefix*/comments(comment_ID) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (bl_id) REFERENCES /*$wgDBprefix*/reflect_bullets_revision(bl_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (bl_rev_id) REFERENCES /*$wgDBprefix*/reflect_bullets_revision(bl_rev_id) ON DELETE CASCADE ON UPDATE CASCADE
	
) /*$wgDBTableOptions*/;


CREATE TABLE /*$wgDBprefix*/reflect_bullet_revision (

	bl_rev_id mediumint(9) NOT NULL AUTO_INCREMENT,	
	bl_id mediumint(9) NOT NULL,
	comment_id mediumint(9),
	
	bl_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	bl_user tinytext NOT NULL,
	
	bl_text text NOT NULL,
	
	PRIMARY KEY bl_rev_id (bl_rev_id),
	INDEX (bl_id),
	FOREIGN KEY (comment_id) REFERENCES /*$wgDBprefix*/comments(comment_ID) ON DELETE SET NULL ON UPDATE CASCADE
) /*$wgDBTableOptions*/;


CREATE TABLE /*$wgDBprefix*/reflect_highlight (
	hl_id mediumint(9) NOT NULL AUTO_INCREMENT,
	hl_element tinytext NOT NULL,
	bl_id mediumint(9),
	bl_rev_id mediumint(9),
	
	PRIMARY KEY hl_id (hl_id),
	FOREIGN KEY (bl_id) REFERENCES /*$wgDBprefix*/reflect_bullets_revision(bl_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (bl_rev_id) REFERENCES /*$wgDBprefix*/reflect_bullets_revision(bl_rev_id) ON DELETE CASCADE ON UPDATE CASCADE
	
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/reflect_response_revision (
	rsp_rev_id mediumint(9) NOT NULL AUTO_INCREMENT,

	rsp_id mediumint(9) NOT NULL,			
	bl_id mediumint(9) NOT NULL,

	rsp_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	rsp_user tinytext NOT NULL,
	
	rsp_signal mediumint(9),
	
	rsp_text text NOT NULL,
				
	PRIMARY KEY rsp_rev_id (rsp_rev_id),
	INDEX (rsp_id),
	FOREIGN KEY (bl_id) REFERENCES /*$wgDBprefix*/reflect_bullets_revision(bl_id) ON DELETE CASCADE ON UPDATE CASCADE
			 
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/reflect_response_current(
	rspc_id mediumint(9) NOT NULL AUTO_INCREMENT,
	bl_id mediumint(9),
	rsp_id mediumint(9),
	rsp_rev_id mediumint(9),
	
	PRIMARY KEY rspc_id (rspc_id),
	FOREIGN KEY (bl_id) REFERENCES /*$wgDBprefix*/reflect_bullets_current(bl_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (rsp_id) REFERENCES /*$wgDBprefix*/reflect_response_revision(rsp_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (rsp_rev_id) REFERENCES /*$wgDBprefix*/reflect_response_revision(rsp_rev_id) ON DELETE CASCADE ON UPDATE CASCADE
	
) /*$wgDBTableOptions*/;


