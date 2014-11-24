-- Add columns, about 14s in dev (844966 rows each)
ALTER TABLE user_fbconnect ADD COLUMN user_fb_app_id bigint(20) DEFAULT 0;
ALTER TABLE user_fbconnect ADD COLUMN user_fb_biz_token varchar(255) DEFAULT '';

-- Take care of dup wikia user IDs, about 3s (126 rows)
UPDATE
        user_fbconnect AS orig,
        (SELECT user_id, min(time) AS min_time, count(*)
         FROM user_fbconnect GROUP BY user_id HAVING count(*) > 1) AS dup
SET user_fb_app_id = 1
WHERE orig.user_id = dup.user_id AND
      orig.time = dup.min_time;

-- Add constraints, about 7s
ALTER TABLE user_fbconnect ADD UNIQUE KEY (user_id, user_fb_app_id);
ALTER TABLE user_fbconnect ADD UNIQUE KEY (user_fbid, user_fb_app_id);

-- Remove old constraint about 12s (844966 rows)
ALTER TABLE user_fbconnect DROP PRIMARY KEY;
