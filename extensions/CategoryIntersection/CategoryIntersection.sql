-- CategoryIntersection sql
-- replace stuff between /* and */ with apropriate stuff
-- or just run the update.php maintence script

CREATE TABLE IF NOT EXISTS /*_*/categoryintersections (
 `ci_page` int(10) unsigned NOT NULL,
 `ci_hash` int(10) unsigned NOT NULL,
 PRIMARY KEY  (`ci_hash`,`ci_page`)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/ci_page ON /*_*/categoryintersections (ci_page);



