<?php

global $wgDBprefix, $wgDBuser;

// These scripts hold the SQL to create and remove tables.
$create_scripts[$wgDBprefix.'wikitrust_global'] = 
  array("
CREATE TABLE ".$wgDBprefix."wikitrust_global (
       median		          float,
       rep_0			  float,
       rep_1			  float,
       rep_2			  float,
       rep_3			  float,
       rep_4			  float,
       rep_5			  float,
       rep_6			  float,
       rep_7			  float,
       rep_8			  float,
       rep_9			  float
) ENGINE=InnoDB",
	"GRANT ALL ON ".$wgDBprefix."wikitrust_global TO $wgDBuser",
	"INSERT INTO ".$wgDBprefix."wikitrust_global VALUES (0,0,0,0,0,0,0,0,0,0,0)");

$create_scripts[$wgDBprefix.'wikitrust_page'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_page (
       page_id             int PRIMARY KEY,
       deleted_chunks      longtext,
       page_info	   text NOT NULL
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_page TO $wgDBuser
");

$create_scripts[$wgDBprefix.'wikitrust_vote'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_vote (
       revision_id              int NOT NULL,
       page_id             int NOT NULL,   
       voter_id            int NOT NULL,
       voted_on            varchar(32) NOT NULL,
       processed	   bool DEFAULT false,
       PRIMARY KEY (revision_id, voter_id)
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_vote TO $wgDBuser","
CREATE INDEX ".$wgDBprefix."wikitrust_voted_processed_idx ON ".$wgDBprefix."wikitrust_vote (voted_on, processed)
");

$create_scripts[$wgDBprefix.'wikitrust_revision'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_revision (
        revision_id             int PRIMARY KEY,
	page_id                 int,
	text_id			int,
	time_string		binary(14),
	user_id			int, 
	username		varchar(255), 
	is_minor		tinyint(3) unsigned, 
	comment			tinyblob, 	
        quality_info		text NOT NULL, 
	reputation_delta        float DEFAULT 0.0,
	overall_trust           float DEFAULT 0.0
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_revision TO $wgDBuser
");

$create_scripts[$wgDBprefix.'wikitrust_colored_markup'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_colored_markup (
        revision_id     int PRIMARY KEY,
        revision_text   longtext NOT NULL,
	revision_createdon varchar(32) NOT NULL
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_colored_markup TO ".$wgDBuser,"
CREATE INDEX ".$wgDBprefix."wikitrust_colored_markup_createdon_idx ON ".$wgDBprefix."wikitrust_colored_markup (revision_createdon)
");

$create_scripts[$wgDBprefix.'wikitrust_sigs'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_sigs (
       revision_id      int PRIMARY KEY,
       revision_data    longtext NOT NULL
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_sigs TO $wgDBuser
");

$create_scripts[$wgDBprefix.'wikitrust_user'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_user (
       user_id     int PRIMARY KEY   ,
       user_rep    float DEFAULT 0.0
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_user TO $wgDBuser;
");

$create_scripts[$wgDBprefix.'wikitrust_missing_revs'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_missing_revs (
       revision_id     int PRIMARY KEY,
       page_id         int NOT NULL,
       page_title      varchar(255) NOT NULL,
       rev_time        varchar(255) NOT NULL,
       user_id         int NOT NULL,
       requested_on    timestamp DEFAULT now(),
       processed       bool DEFAULT false
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_missing_revs TO $wgDBuser;
");

$create_index_scripts[$wgDBprefix . "revision"]['wikitrust_revision_id_timestamp_idx'] = "CREATE INDEX wikitrust_revision_id_timestamp_idx ON " . $wgDBprefix . "revision (rev_id, rev_timestamp)";

$remove_scripts[$wgDBprefix.'wikitrust_vote'] = array("DROP TABLE ".$wgDBprefix."wikitrust_vote");
$remove_scripts[$wgDBprefix.'wikitrust_global'] = array("DROP TABLE ".$wgDBprefix."wikitrust_global");
$remove_scripts[$wgDBprefix.'wikitrust_page'] = array("DROP TABLE ".$wgDBprefix."wikitrust_page");
$remove_scripts[$wgDBprefix.'wikitrust_revision'] = array("DROP TABLE ".$wgDBprefix."wikitrust_revision");
$remove_scripts[$wgDBprefix.'wikitrust_colored_markup'] = array("DROP TABLE ".$wgDBprefix."wikitrust_colored_markup");
$remove_scripts[$wgDBprefix.'wikitrust_sigs'] = array("DROP TABLE ".$wgDBprefix."wikitrust_sigs");
$remove_scripts[$wgDBprefix.'wikitrust_user'] = array("DROP TABLE
".$wgDBprefix."wikitrust_user");
$remove_scripts[$wgDBprefix.'wikitrust_missing_revs'] = array("DROP TABLE
".$wgDBprefix."wikitrust_missing_revs");

$remove_index_scripts[$wgDBprefix . "revision"]['wikitrust_revision_id_timestamp_idx'] = "DROP INDEX wikitrust_revision_id_timestamp_idx ON ".$wgDBprefix."revision";

?>
