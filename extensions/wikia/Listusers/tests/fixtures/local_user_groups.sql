CREATE TABLE IF NOT EXISTS local_user_groups (
    user_id int(5) NOT NULL,
	wiki_id int NOT NULL,
	group_name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	expiry datetime,
	primary key (wiki_id, user_id, group_name)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
