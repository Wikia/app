-- Replace /*_*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

CREATE TABLE IF NOT EXISTS /*_*/assessment_changelog (    
    l_id             int not null auto_increment,
    -- id, for pagination

    l_project        varchar(63)  not null,   
    -- project name

    l_namespace      int unsigned not null,
    -- article namespace

    l_article        varchar(255) not null,
    -- article name

    l_action         varchar(20) character set ascii not null,
    -- type of log entry (e.g. 'quality')

	l_timestamp      binary(14) not null,
    -- timestamp when log entry was added

    l_old            varchar(63),
    -- old value (e.g. B-Class)

    l_new            varchar(63),
    -- new value (e.g. GA-Class)

    l_revision_timestamp  binary(14)  not null,
    -- timestamp when page was edited
    -- a wiki-format timestamp

    primary key (l_project, l_namespace, l_article, l_action, l_timestamp),
    key (l_article, l_namespace),
    unique key (l_id)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/l_project ON /*_*/assessment_changelog (l_project);
