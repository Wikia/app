-- Table set-up for the SignDocument extension.
-- Author: Daniel Cannon (AmiDaniel)

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

-- 
-- Table structure for table sdoc_form
-- This table contains the configuration of which documents
-- may be signed and how they should be signed.
-- 

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/sdoc_form (
  form_id int(11) NOT NULL auto_increment,

-- What page this form is for.
  form_pageid int(11) NOT NULL default '0',
  form_pagename varchar(255) character set latin1 collate latin1_bin NOT NULL default '',

-- Users signing the document will only see this old 
-- revision of the page.
  form_oldid int(11) NOT NULL default '0',

-- Whether or not signing using this form is enabled.
  form_open tinyint(1) NOT NULL default '0',

-- What usergroup can sign this document.
  form_allowgroup varchar(255) character set latin1 collate latin1_bin NOT NULL default '',

-- A bitfield indicating which fields should and should not
-- be displayed to the signer.
  form_hidden int(11) unsigned NOT NULL default '0',

-- A bitfield indicating which fields are optional
  form_optional int(11) unsigned NOT NULL default '0',

-- A brief introductory text providing instructions to the signer.
  form_intro mediumblob NOT NULL,

  PRIMARY KEY  (form_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table sdoc_signature
-- This table contains the actual signatures.
-- 

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/sdoc_signature (
  sig_id int(11) NOT NULL auto_increment,

-- The form used to create this signature, equivalent to
-- which document the user signed.
  sig_form int(11) NOT NULL default '0',

-- Time and date the user signed it.
  sig_timestamp timestamp NOT NULL default CURRENT_TIMESTAMP,

-- The full name of the signer.
  sig_realname varchar(255) character set latin1 collate latin1_bin NOT NULL default '',

-- Whether or not to list the signer's name anonymously.
  sig_anonymous tinyint(1) NOT NULL default '0',

-- The signer's address.
  sig_address varchar(255) character set latin1 collate latin1_bin NOT NULL default '',

-- Whether or not to list the signer's address anonymously.
  sig_hideaddress tinyint(1) NOT NULL default '0',

-- City, state, country, and zip of the signer.
  sig_city varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  sig_state varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  sig_country varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  sig_zip varchar(255) character set latin1 collate latin1_bin NOT NULL default '',

-- Whether to display the signer's city, state, country, and zip.
  sig_hideextaddress tinyint(1) NOT NULL default '0',

-- Signer's phone number.
  sig_phone varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  sig_hidephone tinyint(1) NOT NULL default '0',

-- Signer's age (not birthday, as the name would suggest). Likely
-- a field name that will need to change.
  sig_bday int(11) NOT NULL default '0',
  sig_hidebday tinyint(1) NOT NULL default '0',

-- Signer's e-mail address.
  sig_email varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  sig_hideemail tinyint(1) NOT NULL default '0',

-- Signer's IP address.
  sig_ip varchar(255) character set latin1 collate latin1_bin NOT NULL default '',

-- Signer's user agent.
  sig_agent varchar(255) NOT NULL default '',

-- Whether the sig was stricken by a moderator.
  sig_stricken tinyint(1) NOT NULL default '0',

-- What moderator reviewed the signature.
  sig_strickenby int(11) NOT NULL default '0',

-- Comment left by reviewer.
  sig_strickencomment varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  PRIMARY KEY  (sig_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
