-- Additional, devbox-specific wikis to be added after importing wikicities from production
-- mysqldump -hXXX -uXXX -pXXX  wikicities --tables city_list --where='city_dbname = "devbox"' --no-create-info

BEGIN;
INSERT INTO `city_list` VALUES (79860,'/usr/wikia/docroot/wiki.factory','devbox','devbox','http://devbox.wikia-dev.com','2012-02-27 23:22:52',2084908,0,1,NULL,'Devbox Wiki','Devbox Wiki','owen@wikia-inc.com','en',NULL,NULL,'/usr/wikia/source/wiki','','','',1,'19700101000000','20130326132017',1,'',0,'c2','2012-02-27 23:22:52',0,0);
COMMIT;
