-- Replace /*_*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

CREATE TABLE IF NOT EXISTS /*_*/project_stats (    
    ps_id             int not null auto_increment,
    -- id, for pagination

	ps_project         varchar(63) not null,
	-- project name

	ps_timestamp       binary(14) not null,
	-- last time project data was updated

	ps_quality           varchar(63) not null,
	-- quality assessment. lowercase. 
	-- possible values: fa, a, ga, b, b1, b2, b3, b4, b5, b6, c, start, stub, fl, l, unclassified

	ps_count           int unsigned default 0,
	-- how many pages are assessed in project 

	ps_top_icount           int unsigned default 0,
	-- how many pages are assessed in project to be top importance 

	ps_high_icount           int unsigned default 0,
	-- how many pages are assessed in project to be high importance

	ps_mid_icount           int unsigned default 0,
	-- how many pages are assessed in project to be mid importance

	ps_low_icount           int unsigned default 0,
	-- how many pages are assessed in project to be low importance

	ps_bottom_icount           int unsigned default 0,
	-- how many pages are assessed in project to be bottom importance

	ps_no_icount           int unsigned default 0,
	-- how many pages are assessed in project to be of no importance

	ps_unclassified_icount           int unsigned default 0,
	-- how many pages are assessed in project without a classified importance

	ps_qcount          int unsigned default 0,
	-- how many pages have quality assessments in the project

	ps_icount          int unsigned default 0,
	-- how many pages have importance assessments in the project 

	primary key (ps_project, ps_quality),
    key (ps_id)
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ps_id ON /*_*/project_stats (ps_id);
CREATE INDEX /*i*/ps_project ON /*_*/project_stats (ps_project);
