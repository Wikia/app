CREATE TABLE /*_*/link (
   -- Internal ID number of the link
  `link_id` int(11) NOT NULL PRIMARY KEY auto_increment,
   -- User-supplied link name
  `link_name` varchar(255) NOT NULL,
   -- User-supplied link description
  `link_description` text NOT NULL,
   -- Article ID of the Link: page associated with the current link
  `link_page_id` int(11) NOT NULL default '0',
   -- The actual link URL
  `link_url` text,
   -- One of the integers defined at Link::$link_types or in $wgLinkFilterTypes
  `link_type` int(5) NOT NULL default '0',
   -- 1 = accepted, 2 = rejected
  `link_status` int(5) NOT NULL default '0',
   -- User ID of the person who submitted the link
  `link_submitter_user_id` int(11) NOT NULL default '0',
   -- User name of the person who submitted the link
  `link_submitter_user_name` varchar(255) NOT NULL,
   -- Timestamp indicating when the link was submitted
  `link_submit_date` datetime default NULL,
   -- Timestamp indicating when a privileged user approved the link via the
   -- LinkApprove special page
  `link_approved_date` datetime default NULL,
   -- The amount of comments the link page has
  `link_comment_count` int(11) NOT NULL default '0'
)/*$wgDBTableOptions*/;

CREATE INDEX /*i*/link_approved_date ON /*_*/link (link_approved_date);