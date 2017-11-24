<?php

class DWDimensionApiControllerSQL {

	const DIMENSION_WIKIS_QUERY = '
      SELECT 
           city.city_id            AS wiki_id,
           city.city_dbname        AS dbname,
           city.city_sitename      AS sitename,
           REPLACE(REPLACE(city.city_url, \'http://\', \'\'), \'/\', \'\') AS url,
           REPLACE(REPLACE(city.city_url, \'http://\', \'\'), \'/\', \'\') AS domain,
           city.city_title         AS title,
           city.city_founding_user AS founding_user_id,
           city.city_public        AS public,
           city.city_lang          AS lang,
           lang.lang_id            AS lang_id,
           CASE WHEN tag.tag_id = 100422 THEN \'Entertainment\'
                WHEN tag.tag_id = 100378 THEN \'Gaming\' ELSE null END AS ad_tag,
           cat.cat_id              AS category_id,
           cat.cat_name            AS category_name,
           cat.cat_id              AS hub_id,
           cat.cat_name            AS hub_name,
           CASE WHEN vert.vertical_name IN (\'Music\', \'Comics\', \'TV\', \'Movies\', \'Books\')               THEN 3
                WHEN vert.vertical_name = \'Video Games\'                                               THEN 2
                WHEN city.city_id IN (SELECT city_id FROM city_cat_mapping WHERE cat_id = 4)             THEN 4
                WHEN vert.vertical_name = \'Lifestyle\'                                                 THEN 9
                WHEN cat.cat_name IN (\'Entertainment\', \'Music\') THEN 3
                WHEN cat.cat_name = \'Gaming\'                    THEN 2
                WHEN cat.cat_name = \'Wikia\'                     THEN 4
                ELSE 9 END            AS vertical_id,
           CASE WHEN vert.vertical_name IN (\'Music\', \'Comics\', \'TV\', \'Movies\', \'Books\')               THEN \'Entertainment\'
                WHEN vert.vertical_name = \'Video Games\'                                               THEN \'Gaming\'
                WHEN city.city_id IN (SELECT city_id FROM city_cat_mapping WHERE cat_id = 4)             THEN \'Wikia\'
                WHEN vert.vertical_name = \'Lifestyle\'                                                 THEN \'Lifestyle\'
                WHEN cat.cat_name IN (\'Entertainment\', \'Music\') THEN \'Entertainment\'
                WHEN cat.cat_name = \'Gaming\'                    THEN \'Gaming\'
                WHEN cat.cat_name = \'Wikia\'                     THEN \'Wikia\'
                WHEN cat.cat_name = \'Lifestyle\'                 THEN \'Lifestyle\'
                ELSE \'Lifestyle\' END        AS vertical_name,
           IFNULL(city.city_cluster, \'c1\') AS cluster,
           city.city_created       AS created_at,
           0                       AS deleted
      FROM city_list city
      LEFT JOIN city_cat_mapping m
        ON m.city_id = city.city_id  
      LEFT JOIN city_cats cat
        ON cat.cat_id = m.cat_id 
      LEFT JOIN city_verticals vert
        ON vert.vertical_id = city.city_vertical
      LEFT JOIN city_lang lang
        ON lang.lang_code = city.city_lang
      LEFT JOIN city_tag_map tag
        ON tag.city_id = city.city_id
       AND tag.tag_id IN (100422, 100378)
      WHERE city.city_id > $city_id
      ORDER BY city.city_id      
      LIMIT $limit';
}
