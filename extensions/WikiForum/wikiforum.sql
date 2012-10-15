-- SQL schema for WikiForum extension
-- Rewritten by Jack Phoenix <jack@countervandalism> in December 2010
-- the "formerly" comments refer to the names that Michael Chlebek, the
-- original author of WikiForum, called those columns
--
-- Most table names are quite self-explanatory, and the same goes for the
-- fields.
--
-- This schema should be SQLite-friendly, too.
-- I followed this commit by Mark when making the changes:
-- http://www.mediawiki.org/wiki/Special:Code/MediaWiki/77272

CREATE TABLE IF NOT EXISTS /*_*/wikiforum_category (
	`wfc_category` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT, -- formerly: pkCategory
	`wfc_category_name` varchar(50) NOT NULL, -- formerly: Category_name
	`wfc_sortkey` mediumint(5) NOT NULL DEFAULT '9', -- formerly: SortKey
	`wfc_added_timestamp` binary(14) NOT NULL DEFAULT '', -- formerly: Added
	`wfc_added_user` int(10) NOT NULL DEFAULT '0', -- formerly: AddedBy
	`wfc_edited` int(10) NOT NULL DEFAULT '0', -- formerly: Edited
	`wfc_edited_user` int(10) NOT NULL DEFAULT '0', -- formerly: EditedBy
	`wfc_deleted` int(10) NOT NULL DEFAULT '0', -- formerly: Deleted
	`wfc_deleted_user` int(10) NOT NULL DEFAULT '0' -- formerly: DeletedBy
)/*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*_*/wikiforum_forums (
	`wff_forum` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT, -- formerly: pkForum
	`wff_forum_name` varchar(50) NOT NULL, -- formerly: Forum_name
	`wff_description` varchar(255) NOT NULL, -- formerly: Description
	`wff_category` int(10) NOT NULL, -- formerly: fkCategory
	`wff_sortkey` mediumint(5) NOT NULL DEFAULT '9', -- formerly: SortKey
	`wff_thread_count` int(10) NOT NULL DEFAULT '0', -- formerly: num_threads
	`wff_reply_count` int(10) NOT NULL DEFAULT '0', -- formerly: num_articles
	`wff_last_post_user` int(10) NOT NULL DEFAULT '0', -- formerly: lastpost_user
	`wff_last_post_timestamp` binary(14) NOT NULL DEFAULT '', -- formerly: lastpost_time
	`wff_added_timestamp` binary(14) NOT NULL DEFAULT '', -- formerly: Added
	`wff_added_user` int(10) NOT NULL DEFAULT '0', -- formerly: AddedBy
	`wff_edited_timestamp` binary(14) NOT NULL DEFAULT '', -- formerly: Edited
	`wff_edited_user` int(10) NOT NULL DEFAULT '0', -- formerly: EditedBy
	`wff_deleted` int(10) NOT NULL DEFAULT '0', -- formerly: Deleted
	`wff_deleted_user` int(10) NOT NULL DEFAULT '0', -- formerly: DeletedBy
	`wff_announcement` tinyint(2) NOT NULL DEFAULT '0' -- new in version 1.2; previously called "Announcement"
)/*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*_*/wikiforum_threads (
	`wft_thread` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT, -- formerly: pkThread
	`wft_thread_name` varchar(255) NOT NULL, -- formerly: Thread_name
	`wft_text` text NOT NULL, -- formerly: Text
	`wft_sticky` tinyint(1) NOT NULL DEFAULT '0', -- formerly: Sticky
	`wft_posted_timestamp` binary(14) NOT NULL DEFAULT '', -- formerly: Posted
	`wft_user` int(10) NOT NULL DEFAULT '0', -- formerly: PostedBy
	`wft_deleted` int(10) NOT NULL DEFAULT '0', -- formerly: Deleted
	`wft_deleted_user` int(10) NOT NULL DEFAULT '0', -- formerly: DeletedBy
	`wft_edit_timestamp` binary(14) NOT NULL DEFAULT '', -- formerly: Edit
	`wft_edit_user` int(10) NOT NULL DEFAULT '0', -- formerly: EditBy
	`wft_closed` int(10) NOT NULL DEFAULT '0', -- formerly: Closed
	`wft_closed_user` int(10) NOT NULL DEFAULT '0', -- formerly: ClosedBy
	`wft_forum` int(10) NOT NULL DEFAULT '0', -- formerly: fkForum
	`wft_reply_count` int(10) NOT NULL DEFAULT '0', -- formerly: num_answers
	`wft_view_count` int(10) NOT NULL DEFAULT '0', -- formerly: num_calls
	`wft_last_post_user` int(10) NOT NULL DEFAULT '0', -- formerly: lastpost_user
	`wft_last_post_timestamp` binary(14) NOT NULL DEFAULT '' -- formerly: lastpost_time
)/*$wgDBTableOptions*/;

-- formerly: wikiforum_comments
CREATE TABLE IF NOT EXISTS /*_*/wikiforum_replies (
	`wfr_reply_id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT, -- formerly: pkComment
	`wfr_reply_text` text NOT NULL, -- formerly: Comment
	`wfr_posted_timestamp` binary(14) NOT NULL DEFAULT '', -- formerly: Posted
	`wfr_user` int(10) NOT NULL DEFAULT '0', -- formerly: PostedBy
	`wfr_deleted` int(10) NOT NULL DEFAULT '0', -- formerly: Deleted
	`wfr_deleted_user` int(10) NOT NULL DEFAULT '0', -- formerly: DeletedBy
	`wfr_edit_timestamp` binary(14) NOT NULL DEFAULT '', -- formerly: Edit
	`wfr_edit_user` int(10) NOT NULL DEFAULT '0', -- formerly: EditBy
	`wfr_thread` int(10) NOT NULL -- formerly: fkThread
)/*$wgDBTableOptions*/;