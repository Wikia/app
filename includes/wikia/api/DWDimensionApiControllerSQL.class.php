<?php

class DWDimensionApiControllerSQL {

	const DIMENSION_WIKIS_QUERY = '
      SELECT 
           city.city_id            AS wiki_id,
           city.city_dbname        AS dbname,
           city.city_sitename      AS sitename,
           city.city_url 		   AS url,
           city.city_title         AS title,
           city.city_founding_user AS founding_user_id,
           city.city_public        AS public,
           city.city_lang          AS lang,
           lang.lang_id            AS lang_id,
           CASE WHEN tag.tag_id = 100422 THEN \'Entertainment\'
                WHEN tag.tag_id = 100378 THEN \'Gaming\' ELSE null END AS ad_tag,
           m.cat_id               AS category_id,
           city.city_vertical      AS vertical_id,
           IFNULL(city.city_cluster, \'c1\') AS cluster,
           city.city_created       AS created_at,
           0                       AS deleted
      FROM city_list city
      LEFT JOIN city_cat_mapping m
        ON m.city_id = city.city_id  
      LEFT JOIN city_lang lang
        ON lang.lang_code = city.city_lang
      LEFT JOIN city_tag_map tag
        ON tag.city_id = city.city_id
       AND tag.tag_id IN (100422, 100378)
      WHERE city.city_id > $city_id
      ORDER BY city.city_id      
      LIMIT $limit';

	const DIMENSION_WIKI_EMBEDS = '
		select
			il.il_from AS article_id,
			v.video_title,
			v.added_at,
			v.added_by,
			v.duration,
			v.premium,
			v.hdfile,
			v.removed,
			v.views_30day,
			v.views_total
		FROM imagelinks il
		JOIN video_info v
		ON v.video_title = il.il_to';
}
