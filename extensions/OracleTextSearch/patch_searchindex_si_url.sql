define mw_prefix='{$wgDBprefix}';

ALTER TABLE &mw_prefix.searchindex ADD si_url VARCHAR2(512); 

CREATE INDEX &mw_prefix.si_url_idx ON &mw_prefix.searchindex(si_url) INDEXTYPE IS ctxsys.context PARAMETERS ('DATASTORE ctxsys.url_datastore FILTER ctxsys.inso_filter');

