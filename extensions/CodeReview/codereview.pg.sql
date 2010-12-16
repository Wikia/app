CREATE SEQUENCE cr_code_repo_seq;

CREATE TABLE code_repo (
  repo_id INTEGER NOT NULL PRIMARY KEY DEFAULT nextval('cr_code_repo_seq'),

  repo_name TEXT NOT NULL,

  repo_path TEXT NOT NULL,

  repo_viewvc TEXT,

  repo_bugzilla TEXT
);

CREATE INDEX code_repo_repo_name ON code_repo (repo_name);

CREATE TYPE cr_cr_status AS ENUM ('new', 'fixme', 'reverted', 'resolved', 'ok', 'verified', 'deferred');
CREATE TABLE code_rev (
  cr_repo_id INTEGER NOT NULL,

  cr_id INTEGER NOT NULL,

  cr_timestamp TIMESTAMPTZ,

  cr_author TEXT,

  cr_message TEXT,

  cr_status CR_CR_STATUS NOT NULL DEFAULT 'new',

  cr_path TEXT,

  cr_diff TEXT NULL,

  cr_flags TEXT NOT NULL DEFAULT '',
  
  PRIMARY KEY (cr_repo_id, cr_id)
);

CREATE INDEX cr_repo_ts ON code_rev (cr_repo_id, cr_timestamp);
CREATE INDEX cr_repo_author ON code_rev (cr_repo_id, cr_author, cr_timestamp);

CREATE TABLE code_authors (
  ca_repo_id INTEGER NOT NULL,

  ca_author TEXT,

  ca_user_text TEXT,

  primary key (ca_repo_id, ca_author),

  unique (ca_user_text, ca_repo_id, ca_author)
);

CREATE TYPE code_path_action AS ENUM ('M', 'A', 'D', 'R');
CREATE TABLE code_paths (
  cp_repo_id INTEGER NOT NULL,
  cp_rev_id INTEGER NOT NULL,

  cp_path TEXT NOT NULL,

  cp_action CODE_PATH_ACTION,

  primary key (cp_repo_id, cp_rev_id, cp_path)
);


CREATE TABLE code_relations (
  cf_repo_id INTEGER NOT NULL,

  cf_from INTEGER NOT NULL,

  cf_to INTEGER NOT NULL,

  primary key (cf_repo_id, cf_from, cf_to)
);
CREATE INDEX cr_repo_to_from ON code_relations (cf_repo_id, cf_to, cf_from);

CREATE TABLE code_bugs (
  cb_repo_id INTEGER NOT NULL,

  cb_from INTEGER NOT NULL,

  cb_bug INTEGER NOT NULL,

  primary key (cb_repo_id, cb_from, cb_bug)
);
CREATE INDEX cb_repo_bug ON code_bugs (cb_repo_id, cb_bug, cb_from);

CREATE TABLE code_tags (
  ct_repo_id INTEGER NOT NULL,
  ct_rev_id INTEGER NOT NULL,
  ct_tag TEXT NOT NULL,

  primary key (ct_repo_id,ct_rev_id,ct_tag)
);
CREATE INDEX ct_repo_tag ON code_tage (ct_repo_id,ct_tag,ct_rev_id);

CREATE SEQUENCE cc_id_seq;
CREATE TABLE code_comment (
  cc_id INTEGER NOT NULL DEFAULT nextval('cc_id_seq'),

  cc_repo_id INTEGER NOT NULL,
  cc_rev_id INTEGER NOT NULL,

  cc_text TEXT,

  cc_parent INTEGER,

  cc_user INTEGER NOT NULL,
  cc_user_text TEXT NOT NULL,

  cc_timestamp TIMESTAMPTZ NOT NULL,

  cc_sortkey TEXT,

  cc_review INTEGER,

  primary key (cc_id)
);
CREATE INDEX cc_repo_id_rev ON code_comment (cc_repo_id,cc_rev_id,cc_sortkey);
CREATE INDEX cc_repo_time ON code_comment (cc_repo_id,cc_timestamp);

CREATE TYPE cp_attrib AS ENUM ('status','tags');
CREATE TABLE code_prop_changes (
  cpc_repo_id INTEGER NOT NULL,
  cpc_rev_id INTEGER NOT NULL,

  cpc_attrib CP_ATTRIB NOT NULL,

  cpc_removed TEXT,
  cpc_added TEXT,

  cpc_timestamp TIMESTAMPTZ NOT NULL default now(),

  cpc_user INTEGER NOT NULL,
  cpc_user_text TEXT NOT NULL

);

CREATE INDEX cpc_repo_rev_time ON code_prop_changes (cpc_repo_id, cpc_rev_id, cpc_timestamp);
CREATE INDEX cpc_repo_time ON code_prop_changes (cpc_repo_id, cpc_timestamp);

DROP TABLE IF EXISTS code_test_suite;

CREATE SEQUENCE ct_ctsuite_id_seq;
CREATE TABLE code_test_suite (
  ctsuite_id INTEGER PRIMARY KEY NOT NULL DEFAULT nextval('ct_ctsuite_id_seq'),
  
  ctsuite_repo_id INTEGER NOT NULL,
  
  ctsuite_branch_path TEXT NOT NULL,
  
  ctsuite_name TEXT NOT NULL,
  
  ctsuite_desc TEXT NOT NULL
);

DROP TABLE IF EXISTS code_test_case;

CREATE SEQUENCE ct_ctcase_id_seq;
CREATE TABLE code_test_case (
  ctcase_id INTEGER PRIMARY KEY NOT NULL DEFAULT nextval('ct_ctcase_id_seq'),
  ctcase_suite_id INTEGER NOT NULL,
  ctcase_name TEXT NOT NULL

);

CREATE INDEX ct_ctcase_id ON code_test_case (ctcase_suite_id, ctcase_id);

DROP TABLE IF EXISTS code_test_run;

CREATE SEQUENCE ct_ctrun_id_seq;
CREATE TYPE code_test_status AS ENUM('running','complete','abort');
CREATE TABLE code_test_run (
  ctrun_id INTEGER PRIMARY KEY NOT NULL DEFAULT nextval('ct_ctrun_id_seq'),
  
  ctrun_suite_id INTEGER NOT NULL,
  ctrun_rev_id INTEGER NOT NULL,
  
  ctrun_status CODE_TEST_STATUS,
  
  ctrun_count_total INTEGER,
  ctrun_count_success INTEGER
);

CREATE INDEX suite_rev ON code_test_run (ctrun_suite_id, ctrun_rev_id);

DROP TABLE IF EXISTS code_test_result;
CREATE SEQUENCE ct_ctresult_id_seq;
CREATE TABLE code_test_result (
  ctresult_id INTEGER PRIMARY KEY NOT NULL DEFAULT nextval('ct_ctresult_id_seq'),
  
  ctresult_run_id INTEGER NOT NULL,
  ctresult_case_id INTEGER NOT NULL,
  
  ctresult_success bool NOT NULL,
  
  ctresult_details TEXT
);

CREATE INDEX run_id ON code_test_result (ctresult_run_id, ctresult_id);
