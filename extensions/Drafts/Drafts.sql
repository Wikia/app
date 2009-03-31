-- 
-- SQL for Drafts Extension
-- 
-- Table for storing working changes to pages that
-- users have yet to commit.
CREATE TABLE /*$wgDBPrefix*/drafts (
    -- Unique ID for drafts
    draft_id INTEGER AUTO_INCREMENT,
    -- Unique value generated at edit time to prevent duplicate submissions
    draft_token INTEGER,
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
    draft_minoredit BOOL,
    PRIMARY KEY (draft_id),
    INDEX draft_user_savetime ( draft_user, draft_savetime ),
    INDEX draft_user_page_savetime (
        draft_user,
        draft_page,
        draft_namespace,
        draft_title,
        draft_savetime
    ),
    INDEX draft_savetime (draft_savetime)
) /*$wgDBTableOptions*/;
