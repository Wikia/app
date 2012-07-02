-- Replace /*_*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

CREATE TABLE IF NOT EXISTS /*_*/selections (
    s_id             int not null auto_increment,
    -- id, for pagination

    s_selection_name        varchar(63)  not null,   
    -- project name

    s_namespace      int unsigned not null,
    -- article namespace

    s_article        varchar(255) not null,
    -- article name

	s_timestamp      binary(14) not null,
    -- timestamp when entry was added

	s_revision       int unsigned,
    -- manually set revision

    primary key (s_selection_name, s_namespace, s_article),
    unique key (s_id)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/s_selection_name ON /*_*/selections (s_selection_name);
