ALTER TABLE /*$wgDBprefix*/ach_user_badges DROP KEY notified_id;
OPTIMIZE TABLE /*$wgDBprefix*/ach_user_badges;