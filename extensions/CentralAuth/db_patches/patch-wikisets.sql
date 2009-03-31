-- Sets of wikis (for things like restricting global groups)
-- May be defined in two ways: only specified wikis or all wikis except opt-outed
CREATE TABLE wikiset (
	-- ID of wikiset
	ws_id int auto_increment,
	-- Display name of wikiset
	ws_name varchar(255) not null,
	-- Type of set: opt-in or opt-out
	ws_type enum ('optin', 'optout'),
	-- Wikis in that set. Why isn't it a separate table?
	-- Because we can just use such simple list, we don't need complicated queries on it
	-- Let's suppose that max length of db name is 31 (32 with ","), then we have space for
	-- 2048 wikis. More than we need
	ws_wikis blob not null,
	
	PRIMARY KEY ws_id (ws_id),
	UNIQUE ws_name (ws_name)
) /*$wgDBTableOptions*/;

-- Allow certain global groups to have their permissions only on certain wikis
CREATE TABLE global_group_restrictions (
	-- Group to restrict
	ggr_group varchar(255) not null,
	-- Wikiset to use
	ggr_set int not null,

	PRIMARY KEY (ggr_group),
	KEY (ggr_set)
) /*$wgDBTableOptions*/;
