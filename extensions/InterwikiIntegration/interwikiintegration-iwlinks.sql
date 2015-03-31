BEGIN;

-- Track all interwiki links on all wikis in this farm
CREATE TABLE integration_iwlinks (
    -- integration_dbname of the referring wiki
    integration_iwl_from_db varchar(255) binary NOT NULL,

    -- page_id of the referring page
    integration_iwl_from int unsigned NOT NULL default 0,
    
    -- URL of the referring page
    integration_iwl_from_url varchar(511) binary NOT NULL default '',
    
    -- Interwiki prefix code of the target
    integration_iwl_prefix varbinary(20) NOT NULL default '',
    
    -- Title of the target, including namespace
    integration_iwl_title varchar(255) binary NOT NULL default ''
)
CHARACTER SET utf8 COLLATE utf8_unicode_ci;
        
-- Index to be created when it becomes evident what searches are most common
        
COMMIT;