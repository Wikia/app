--
-- Create initial database for extensions/gis/database.php
-- Remember to replace /*$wgDBprefix*/ with your local value
--
-- # mysql -u USERNAME -p
-- use wikidb;
-- source gisdb.sql;
-- quit;
--

CREATE TABLE /*$wgDBprefix*/gis (
	gis_page int(8) unsigned NOT NULL,
	gis_latitude_min real NOT NULL,
	gis_latitude_max real NOT NULL,
	gis_longitude_min real NOT NULL,
	gis_longitude_max real NOT NULL,
	gis_globe char(8) binary NOT NULL default '',
	gis_type char(12) binary,
	gis_type_arg real NOT NULL default 0,
	gis_sector int(8) unsigned NOT NULL,

	KEY gis_page (gis_page),
	INDEX gis_globe (gis_globe),
	INDEX gis_type (gis_type),
	INDEX gis_type_arg (gis_type_arg),
	INDEX gid_sector_lat (gis_sector, gis_latitude_min)
);
