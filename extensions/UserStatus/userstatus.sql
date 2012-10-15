-- Author: Jack Phoenix <jack@countervandalism.net>
-- Date: 11 August 2011
-- License: public domain to the extent that it is possible
CREATE TABLE /*_*/user_status (
	-- Unique ID number of the status update
	`us_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	-- User ID of the person who posted this status update
	`us_user_id` int(11) NOT NULL default '0',
	-- User name of the person who posted this status update
	`us_user_name` varchar(255) NOT NULL default '',
	-- Sports ID (see the SportsTeams extension and its tables) that is
	-- associated with this status update
	`us_sport_id` int(11) NOT NULL default '0',
	-- See above, except that this is an individual sports team (i.e.
	-- New York Mets)
	`us_team_id` int(11) NOT NULL default '0',
	-- Actual text of the status update
	`us_text` text,
	-- Timestamp indicating when the status update was posted
	`us_date` datetime default null,
	-- How many up/plus votes the status update has?
	`us_vote_plus` int(11) NOT NULL default '0',
	-- How many down/minus votes the status update has?
	`us_vote_minus` int(11) NOT NULL default '0'
)/*$wgDBTableOptions*/;

CREATE TABLE /*_*/user_status_vote (
	-- Unique ID number of the vote, I suppose;
	-- @see UserStatusClass.php, function addStatusVote()
	`sv_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	-- User ID of the person who voted for the status update
	`sv_user_id` int(11) NOT NULL default '0',
	-- User name of the person who voted for the status update
	`sv_user_name` varchar(255) NOT NULL default '',
	-- ID of the status update
	`sv_us_id` int(11) NOT NULL default '0',
	--
	`sv_vote_score` int(3) NOT NULL default '0',
	-- Timestamp indicating when the vote was cast
	`sv_date` datetime default null
)/*$wgDBTableOptions*/;