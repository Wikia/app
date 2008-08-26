CREATE TABLE /*$wgDBprefix*/metis (
	metis_id int unsigned NOT NULL auto_increment,

	-- http://vg02.met.vgwort.de/na/d0a9f05e8f900e660f61
	metis_pixel varchar(80) NOT NULL,
	metis_author_pixel varchar(80),
	PRIMARY KEY metis_id (metis_id)
	
) 

	
