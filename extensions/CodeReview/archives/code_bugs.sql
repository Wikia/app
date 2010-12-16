-- And for our commenting system...
-- To specify bug relationships...
CREATE TABLE /*$wgDBprefix*/code_bugs (
  cb_repo_id int not null,
  -- -> cr_id
  cb_from int not null,
  -- -> bug ID number
  cb_bug int not null,

  primary key (cb_repo_id, cb_from, cb_bug),
  key (cb_repo_id, cb_bug, cb_from)
) /*$wgDBTableOptions*/;
