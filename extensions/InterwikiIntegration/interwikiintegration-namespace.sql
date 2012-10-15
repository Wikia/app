BEGIN;

CREATE TABLE integration_namespace (
    -- Just a meaningless primary key
    integration_namespace_id                int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    -- Database of namespace's wiki
    integration_dbname                  varchar(256) binary NOT NULL,
    -- Same as page_namespace
    integration_namespace_index             int NOT NULL,
    -- E.g., "File" for namespace_index 6
    integration_namespace_title             varchar(256) binary NOT NULL
)
CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- Index to be created when it becomes evident what searches are most common

COMMIT;