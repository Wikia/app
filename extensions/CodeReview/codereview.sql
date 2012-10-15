CREATE TABLE /*_*/code_repo (
  -- Unique internal ID for the repository.
  -- We may cover multiple repos in one wiki,
  -- so need to tell them apart.
  repo_id int not null primary key auto_increment,

  -- User-presentable name of the repository.
  -- 'MediaWiki'
  repo_name varchar(255) binary not null,

  -- Subversion repository base URL, such as:
  -- 'http://svn.wikimedia.org/svnroot/mediawiki'
  repo_path varchar(255) binary not null,

  -- Base URL of ViewVC repository to make prettier view links
  -- 'http://svn.wikimedia.org/viewvc/mediawiki'
  repo_viewvc varchar(255) binary,

  -- Bug tracker URL, used for linking bugs in commit summaries.
  -- 'https://bugzilla.wikimedia.org/show_bug.cgi?id=$1'
  repo_bugzilla varchar(255) binary
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/repo_name ON /*_*/code_repo (repo_name);

--
-- Representation of basic metadata for a single code revision.
-- Most of this comes straight out of 'svn log'
--
CREATE TABLE /*_*/code_rev (
  -- Repository ID
  cr_repo_id int not null,
  -- Native ID number of this revision within the repository.
  cr_id int not null,

  -- Timestamp of the code commit, in MediaWiki format.
  cr_timestamp binary(14) not null default '',

  -- Native repository username of the author.
  -- code_authors table gives us relations to local usernames.
  cr_author varchar(255) binary,

  -- Text-format description from the repo.
  -- This is *not* wikitext, but will get some light formatting
  -- on display...
  cr_message blob,

  -- Status key for how this thang is...
  -- 'new': Hasn't yet been reviewed
  -- 'fixme': This revision has some problem which needs to be resolved
  -- 'reverted': Was completely reverted by a later revision
  -- 'resolved': Issues with this rev have been since resolved
  -- 'ok': Reviewed, no issues spotted
  -- 'deferred': Not reviewed at this time (usually non-Wikimedia extension)
  -- 'old': Predates the extension/doesn't require review
  -- See CodeRevision::getPossibleStates() (in backend/CodeRevision.php) for most up to date list
  cr_status varchar(25) not null default 'new',

  -- Base path of this revision :
  -- * if the revision change only one file, the file path
  -- * else, common directory for all changes (e.g. trunk/phase3/includes/ )
  cr_path varchar(255) binary,

  -- Text of the diff or ES url
  cr_diff mediumblob NULL,
  -- Text flags: gzip,utf-8,external
  cr_flags tinyblob NOT NULL,

  primary key (cr_repo_id, cr_id)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/cr_repo_id ON /*_*/code_rev (cr_repo_id, cr_timestamp);
CREATE INDEX /*i*/cr_repo_author ON /*_*/code_rev (cr_repo_id, cr_author, cr_timestamp);
CREATE INDEX /*i*/cr_repo_status_author ON /*_*/code_rev (cr_repo_id, cr_status, cr_author);

--
-- Allow us to match up repository usernames
-- with local MediaWiki user accounts.
-- Not all usernames will be matched.
--
CREATE TABLE /*_*/code_authors (
  -- Repository ID
  ca_repo_id int not null,

  -- "Native" author name in the repo
  ca_author varchar(255) binary,

  -- Local wiki username, if any, to tie the edits to instead
  -- Using a username instead of ID so we don't have to worry
  -- about SUL accounts which haven't been copied over.
  ca_user_text varchar(255) binary,

  primary key (ca_repo_id, ca_author)
) /*$wgDBTableOptions*/;

 -- Note that multiple authors on the same repo may point to
 -- a single local user in some cases...
CREATE UNIQUE INDEX /*i*/ca_user_text ON /*_*/code_authors (ca_user_text, ca_repo_id, ca_author);

--
-- List of which files were changed in a given code revision.
-- This lets us make nice summary views and links to details.
--
CREATE TABLE /*_*/code_paths (
  -- -> repo_id
  cp_repo_id int not null,
  -- -> cr_id
  cp_rev_id int not null,

  -- Relative path from the root, eg
  -- '/trunk/phase3/RELEASE_NOTES'
  cp_path varchar(255) not null,

  -- Update type: Modify (M), Add (A), Delete (D), Replace (R)
  cp_action char(1) not null,

  primary key (cp_repo_id, cp_rev_id, cp_path)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/repo_path ON /*_*/code_paths (cp_repo_id, cp_path);

-- And for our commenting system...
-- To specify follow-up relationships...
CREATE TABLE /*_*/code_relations (
  cf_repo_id int not null,
  -- -> cr_id
  cf_from int not null,
  -- -> cr_id
  cf_to int not null,

  primary key (cf_repo_id, cf_from, cf_to)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/repo_to_from ON /*_*/code_relations (cf_repo_id, cf_to, cf_from);

-- And for our commenting system...
-- To specify bug relationships...
CREATE TABLE /*_*/code_bugs (
  cb_repo_id int not null,
  -- -> cr_id
  cb_from int not null,
  -- -> bug ID number
  cb_bug int not null,

  primary key (cb_repo_id, cb_from, cb_bug)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/cb_repo_id ON /*_*/code_bugs (cb_repo_id, cb_bug, cb_from);

-- Freetext tagging for revisions
CREATE TABLE /*_*/code_tags (
  ct_repo_id int not null,
  ct_rev_id int not null,
  ct_tag varbinary(255) not null,

  primary key (ct_repo_id,ct_rev_id,ct_tag)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/ct_repo_id ON /*_*/code_tags (ct_repo_id,ct_tag,ct_rev_id);

CREATE TABLE /*_*/code_comment (
  -- Unique ID of the comment within the system.
  cc_id int not null primary key auto_increment,

  -- Repo and code revision this comment is attached to
  cc_repo_id int not null,
  cc_rev_id int not null,

  -- Wikitext blob of the comment.
  -- FIXME: Consider using standard text store?
  cc_text blob,

  -- cc_id of parent comment if a threaded child, otherwise NULL
  cc_parent int,

  -- User id/name of the commenter
  cc_user int not null,
  cc_user_text varchar(255) not null,

  cc_timestamp binary(14) not null,

  -- Timestamps of threaded parent and self to present a
  -- convenient threaded sort order:
  -- "20080130123456"
  -- "20080130123456,20080230123456"
  -- "20080430123456"
  --
  -- Allows 17 levels of nesting before we hit the length limit.
  -- Could redo more compactly to get 31 or 63 levels.
  cc_sortkey varbinary(255)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/cc_repo_id ON /*_*/code_comment (cc_repo_id,cc_rev_id,cc_sortkey);
CREATE INDEX /*i*/cc_repo_time ON /*_*/code_comment (cc_repo_id,cc_timestamp);
CREATE INDEX /*i*/cc_author ON /*_*/code_comment (cc_repo_id, cc_user_text, cc_timestamp);

--
-- Changes to review metadata for a single code revision.
--
CREATE TABLE /*_*/code_prop_changes (
  -- Repository ID
  cpc_repo_id int not null,
  -- Native ID number of this revision within the repository.
  cpc_rev_id int not null,

  -- The item that was changed
  cpc_attrib varchar(10) not null,
  -- How it was changed
  cpc_removed blob,
  cpc_added blob,

  -- Timestamp of the change, in MediaWiki format.
  cpc_timestamp binary(14) not null default '',

  -- User id/name of the commenter
  cpc_user int not null,
  cpc_user_text varchar(255) not null
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/cpc_repo_rev_time ON /*_*/code_prop_changes (cpc_repo_id, cpc_rev_id, cpc_timestamp);
CREATE INDEX /*i*/cpc_repo_time ON /*_*/code_prop_changes (cpc_repo_id, cpc_timestamp);
CREATE INDEX /*i*/cpc_author ON /*_*/code_prop_changes (cpc_repo_id, cpc_user_text, cpc_timestamp);

CREATE TABLE /*_*/code_signoffs (
  -- Repository ID and revision ID
  cs_repo_id int not null,
  cs_rev_id int not null,

  -- User that signed off
  cs_user int not null,
  cs_user_text varchar(255) not null,

  -- Type of signoff. Current values: 'inspected', 'tested'
  -- See CodeRevision::getPossibleFlags() (in backend/CodeRevision.php) for most up to date list
  cs_flag varchar(25) not null,

  -- Timestamp of the sign-off
  cs_timestamp binary(14) not null default '',

  -- Timestamp the sign-off was struck, or Block::infinity() if not struck
  cs_timestamp_struck varbinary(14) not null default 'infinity'
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/cs_repo_rev_user_flag_tstruck ON /*_*/code_signoffs (cs_repo_id, cs_rev_id, cs_user_text, cs_flag, cs_timestamp_struck);
CREATE INDEX /*i*/cs_repo_repo_rev_timestamp ON /*_*/code_signoffs (cs_repo_id, cs_rev_id, cs_timestamp);
