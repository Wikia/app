CREATE SEQUENCE cr_code_repo_seq;

CREATE TABLE code_repo (
  repo_id INTEGER NOT NULL PRIMARY KEY DEFAULT nextval('cr_code_repo_seq'),

  repo_name TEXT NOT NULL,

  repo_path TEXT NOT NULL,

  repo_viewvc TEXT,

  repo_bugzilla TEXT
);

CREATE INDEX code_repo_repo_name ON code_repo (repo_name);

CREATE TABLE code_rev (
  cr_repo_id INTEGER NOT NULL,

  cr_id INTEGER NOT NULL,

  cr_timestamp TIMESTAMPTZ,

  cr_author TEXT,

  cr_message TEXT,

  cr_status TEXT NOT NULL DEFAULT 'new',

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
