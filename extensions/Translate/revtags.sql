-- These tables could go into core someday

-- Revision tag type list
CREATE TABLE /*$wgDBprefix*/revtag_type (
  rtt_id int not null primary key auto_increment,
  rtt_name varbinary(60) not null
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/rtt_name ON /*$wgDBprefix*/revtag_type (rtt_name);

-- Revision tags
CREATE TABLE /*$wgDBprefix*/revtag (
  -- Link to revtag_type.rtt_id
  rt_type int not null,

  -- Link to page.page_id
  rt_page int not null,

  -- Link to revision.rev_id
  rt_revision int not null,

  rt_value blob null
) /*$wgDBTableOptions*/;
-- Index for finding all revisions in a page with a given tag
CREATE UNIQUE INDEX /*i*/rt_type_page_revision ON /*$wgDBprefix*/revtag
(rt_type, rt_page, rt_revision);
-- Index for finding the tags on a given revision
CREATE INDEX /*i*/rt_revision_type ON /*$wgDBprefix*/revtag (rt_revision, rt_type);