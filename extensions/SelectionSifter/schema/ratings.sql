-- Replace /*_*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

CREATE TABLE IF NOT EXISTS /*_*/ratings (    
    r_id             int not null auto_increment,
    -- id, for pagination

	r_project               varchar(63)  not null,
	-- project name

	r_namespace             int unsigned not null,
	-- article namespace

	r_article               varchar(255) not null,
	-- article title

	r_quality               varchar(63),
	-- quality rating

	r_quality_timestamp     binary(14),
	-- time when quality rating was assigned
	--   NOTE: a revid can be obtained from timestamp via API
	--  a wiki-format timestamp

	r_importance            varchar(63),
	-- importance rating

	r_importance_timestamp  binary(14),
	-- time when importance rating was assigned
	-- a wiki-style timestamp

	primary key (r_project, r_namespace, r_article),
    key (r_id)
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/r_id ON /*_*/ratings (r_id);
CREATE INDEX /*i*/r_article ON /*_*/ratings (r_namespace, r_article);
CREATE INDEX /*i*/r_project ON /*_*/ratings (r_project);
