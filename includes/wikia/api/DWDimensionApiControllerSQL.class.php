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


    const DIMENSION_WIKI_ARTICLES_QUERY = '
        SELECT
            page_wikia_id AS wiki_id,
            page_namespace AS namespace_id,
            page_id AS article_id,
            page_title AS title,
            page_is_redirect AS is_redirect
        FROM 
            pages
        WHERE
            ((page_wikia_id = $wiki_id AND page_id > $article_id) OR 
            (page_wikia_id > $wiki_id)) AND 
            DATE(page_last_edited) >= DATE(\'$last_edited\')
        ORDER BY
            page_wikia_id, page_id
        LIMIT $limit';

	const DIMENSION_USERS = '
		SELECT 
			user_id,
			user_name,
			user_real_name,
			user_email_authenticated,
			user_editcount,
			STR_TO_DATE(user_registration, \'%Y%m%d%H%i%s\') AS user_registration
		FROM user u
		WHERE user_id > $user_id
		ORDER BY user_id      
		LIMIT $limit';

	const DIMENSION_WIKI_EMBEDS = '
		SELECT
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

	const DIMENSION_WIKI_IMAGES = '
		SELECT
			img_name       AS image_name,
			img_user       AS user_id,
			img_minor_mime AS minor_mime,
			img_media_type AS media_type,
			STR_TO_DATE(img_timestamp, \'%Y%m%d%H%i%S\') AS created_at
		FROM image';

	const DIMENSION_WIKI_INFO = '
		SELECT
			ss_total_edits   AS total_edits,
			ss_good_articles AS good_articles,
			ss_total_pages   AS total_pages,
			ss_users         AS users,
			ss_active_users  AS active_users,
			ss_admins        AS admins,
			ss_images        AS images,
			NOW()            AS updated_at
		FROM site_stats';

	const DIMENSION_WIKI_USER_GROUPS = '
		SELECT
			ug_user  AS user_id,
			ug_group AS user_group
		FROM user_groups';
}
