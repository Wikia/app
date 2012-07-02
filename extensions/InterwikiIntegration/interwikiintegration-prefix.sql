BEGIN;

-- Track prefixes of local wikis, for foreign wikis' benefit; probably soon to be deprecated
CREATE TABLE integration_prefix (
    -- Wiki prefix
    integration_prefix                  varchar(255) binary NOT NULL PRIMARY KEY,
    -- Wiki database name
    integration_dbname                  varchar(255) binary NOT NULL,
    -- Does this wiki use pure wiki deletion?
    integration_pwd                         tinyint unsigned NOT NULL default 0
)
CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- Index to be created when it becomes evident what searches are most common

COMMIT;