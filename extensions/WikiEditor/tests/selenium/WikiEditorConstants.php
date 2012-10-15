<?php
define ( 'WIKI_TEST_WAIT_TIME', "3000" ); // Waiting time

// tool bar, buttons , links
// commonly using links
define ( 'LINK_MAIN_PAGE', "link=Main page" );
define ( 'LINK_RANDOM_PAGE', "link=Random article" );
define ( 'TEXT_PAGE_HEADING', "firstHeading" );
define ( 'LINK_START', "link=" );
define ( 'LINK_EDITPAGE', "//li[@id='ca-edit']/a/span" );
define ( 'TEXT_EDITOR', "wpTextbox1" );
define ( 'LINK_PREVIEW', "wpPreview" );

define ( 'WIKI_SEARCH_PAGE', "Hair (musical)" ); // Page name to search
define ( 'WIKI_TEXT_SEARCH', "TV" ); // Text to search
define ( 'WIKI_INTERNAL_LINK', "Wikieditor-Fixture-Page" ); // Exisiting page name to add as an internal tag
define ( 'WIKI_EXTERNAL_LINK', "www.google.com" ); // External web site name
define ( 'WIKI_EXTERNAL_LINK_TITLE', "Google" ); // Page title of the external web site name
define ( 'WIKI_CODE_PATH', getcwd() ); // get the current path of the program
define ( 'WIKI_SCREENSHOTS_PATH', "screenshots" ); // the folder the error screen shots will be saved
define ( 'WIKI_SCREENSHOTS_TYPE', "png" ); // screen print type
define ( 'WIKI_TEMP_NEWPAGE', "TestWikiPage" ); // temporary creating new page name
// for WikiCommonFunction_TC

// for WikiSearch_TC
define ( 'INPUT_SEARCH_BOX', "searchInput" );
define ( 'BUTTON_SEARCH', "mw-searchButton" );
define ( 'TEXT_SEARCH_RESULT_HEADING', " - Search results - Wikipedia, the free encyclopedia" );

// for WikiWatchUnWatch_TC
define ( 'LINK_WATCH_PAGE', "link=Watch" );
define ( 'LINK_WATCH_LIST', "link=My watchlist" );
define ( 'LINK_WATCH_EDIT', "link=View and edit watchlist" );
define ( 'LINK_UNWATCH', "link=Unwatch" );
define ( 'BUTTON_WATCH', "wpWatchthis" );
define ( 'BUTTON_SAVE_WATCH', "wpSave" );
define ( 'TEXT_WATCH', "Watch" );
define ( 'TEXT_UNWATCH', "Unwatch" );

// for WikiCommonFunction_TC
define ( 'TEXT_LOGOUT', "Log out" );
define ( 'LINK_LOGOUT', "link=Log out" );
define ( 'LINK_LOGIN', "link=Log in / create account" );
define ( 'TEXT_LOGOUT_CONFIRM', "Log in / create account" );
define ( 'INPUT_USER_NAME', "wpName1" );
define ( 'INPUT_PASSWD', "wpPassword1" );
define ( 'BUTTON_LOGIN', "wpLoginAttempt" );
define ( 'TEXT_HEADING', "Heading" );
define ( 'LINK_ADVANCED', "link=Advanced" );

// for WikiDialogs_TC
define ( 'LINK_ADDLINK', "//div[@id='wikiEditor-ui-toolbar']/div[1]/div[2]/span[2	]" );
define ( 'TEXT_LINKNAME', "wikieditor-toolbar-link-int-target" );
define ( 'TEXT_LINKDISPLAYNAME', "wikieditor-toolbar-link-int-text" );
define ( 'TEXT_LINKDISPLAYNAME_APPENDTEXT', " Test" );
define ( 'ICON_PAGEEXISTS', "wikieditor-toolbar-link-int-target-status-exists" );
define ( 'ICON_PAGEEXTERNAL', "wikieditor-toolbar-link-int-target-status-external" );
define ( 'OPT_INTERNAL', "wikieditor-toolbar-link-type-int" );
define ( 'OPT_EXTERNAL', "wikieditor-toolbar-link-type-ext" );
define ( 'BUTTON_INSERTLINK', "//div[10]/div[11]/button[1]" );
define ( 'LINK_ADDTABLE', "//div[@id='wikiEditor-ui-toolbar']/div[3]/div[1]/div[4]/span[2]" );
define ( 'CHK_HEADER', "wikieditor-toolbar-table-dimensions-header" );
define ( 'CHK_BOARDER', "wikieditor-toolbar-table-wikitable" );
define ( 'CHK_SORT', "wikieditor-toolbar-table-sortable" );
define ( 'TEXT_ROW', "wikieditor-toolbar-table-dimensions-rows" );
define ( 'TEXT_COL', "wikieditor-toolbar-table-dimensions-columns" );
define ( 'BUTTON_INSERTABLE', "//div[3]/button[1]" );
define ( 'TEXT_HEADTABLE_TEXT', "Header text" );
define ( 'TEXT_TABLEID_WITHALLFEATURES', "//table[@id='sortable_table_id_0']/tbody/" );
define ( 'TEXT_TABLEID_OTHER', "//div[@id='wikiPreview']/table/tbody/" );
define ( 'TEXT_VALIDATE_TABLE_PART1', "tr[" );
define ( 'TEXT_VALIDATE_TABLE_PART2', "]/td[" );
define ( 'TEXT_VALIDATE_TABLE_PART3', "]" );
define ( 'LINK_SEARCH', "//div[@id='wikiEditor-ui-toolbar']/div[3]/div[1]/div[5]/span" );
define ( 'INPUT_SEARCH', "wikieditor-toolbar-replace-search" );
define ( 'INPUT_REPLACE', "wikieditor-toolbar-replace-replace" );
define ( 'BUTTON_REPLACEALL', "//button[3]" );
define ( 'BUTTON_REPLACENEXT', "//button[2]" );
define ( 'BUTTON_CANCEL', "//button[4]" );
define ( 'TEXT_PREVIEW_TEXT1', "//div[@id='wikiPreview']/p[1]" );
define ( 'TEXT_PREVIEW_TEXT2', "//div[@id='wikiPreview']/p[2]" );
define ( 'TEXT_PREVIEW_TEXT3', "//div[@id='wikiPreview']/p[3]" );


