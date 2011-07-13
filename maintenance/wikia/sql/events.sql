CREATE EVENT city_list_cats_summarize
ON SCHEDULE EVERY 1 HOUR
COMMENT 'City list table with categories and number of Wikis per day'
DO
BEGIN
START TRANSACTION;
DELETE FROM stats.city_list_count;
INSERT INTO stats.city_list_count SELECT ifnull(date(city_created), '0000-00-00') as city_created, count(city_id) as count_created FROM wikicities.city_list GROUP BY 1;
COMMIT;

START TRANSACTION;

DELETE FROM stats.city_list_cats WHERE city_id not in ( SELECT city_id FROM wikicities.city_list );
INSERT INTO stats.city_list_cats 
SELECT 
c2.city_id, 
c2.city_dbname, 
c2.city_created, 
c2.city_founding_user, 
c2.city_title, 
c2.city_lang, 
c2.city_last_timestamp, 
c2.city_public,
c1.city_created,
ifnull(c1.count_created, 0), 
cc.cat_name
FROM wikicities.city_list c2
LEFT JOIN stats.city_list_cats c3 on c3.city_id = c2.city_id
LEFT JOIN stats.city_list_count c1 on c1.city_created = date(c2.city_created)
LEFT JOIN wikicities.city_cat_mapping ccm ON (c2.city_id = ccm.city_id)
LEFT JOIN wikicities.city_cats cc ON ccm.cat_id =cc.cat_id
where c2.city_id > 0 and c3.city_dbname is null
ON DUPLICATE KEY UPDATE date_created = values(date_created), city_public = values(city_public), count_created = values(count_created);

COMMIT;
end;
