-- 
-- SQL for Drafts Extension
-- 
-- Table for storing working changes to pages that
-- users have yet to commit.
CREATE TABLE /*_*/drafts (
    -- Unique ID for drafts
    draft_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    -- Unique value generated at edit time to prevent duplicate submissions
    draft_token VARBINARY(255),
    -- User who made the draft, 0 for anons
    draft_user INTEGER NOT NULL default 0,
    -- Page ID, 0 for proposed new pages
    draft_page INTEGER NOT NULL default 0,
    -- Original page namespace
    draft_namespace INTEGER NOT NULL,
    -- Original page db key
    draft_title VARBINARY(255) NOT NULL default '',
    -- Section ID of the article
    draft_section INTEGER NULL,
    -- Standard edit conflict checking params...
    draft_starttime BINARY(14),
    draft_edittime BINARY(14),
    -- Timestamp when draft was saved...
    draft_savetime BINARY(14),
    -- Textarea scroll position saved from editor
    draft_scrolltop INTEGER,
    -- And of course the page and summary text come in handy
    draft_text mediumblob NOT NULL,
    draft_summary TINYBLOB,
    -- Is this a minor edit?
    draft_minoredit BOOL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/draft_user_savetime ON /*_*/drafts ( draft_user, draft_savetime );
CREATE INDEX /*i*/draft_user_page_savetime ON /*_*/drafts ( draft_user, draft_page, draft_namespace, draft_title, draft_savetime );
CREATE INDEX /*i*/draft_savetime ON /*_*/drafts (draft_savetime);
CREATE INDEX /*i*/draft_page ON /*_*/drafts (draft_page);
