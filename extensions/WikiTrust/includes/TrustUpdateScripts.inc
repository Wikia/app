<?php

global $wgDBprefix, $wgDBuser;

// These scripts hold the SQL to create and remove tables.
$create_scripts[$wgDBprefix.'wikitrust_global'] = 
  array("
CREATE TABLE ".$wgDBprefix."wikitrust_global (
       median                     float,
       rep_0                      float,
       rep_1                      float,
       rep_2                      float,
       rep_3                      float,
       rep_4                      float,
       rep_5                      float,
       rep_6                      float,
       rep_7                      float,
       rep_8                      float,
       rep_9                      float
) ENGINE=InnoDB",
        "GRANT ALL ON ".$wgDBprefix."wikitrust_global TO '$wgDBuser'",
        "INSERT INTO ".$wgDBprefix."wikitrust_global VALUES (0,0,0,0,0,0,0,0,0,0,0)");

$create_scripts[$wgDBprefix.'wikitrust_page'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_page (
       page_id             int PRIMARY KEY,
       page_title          varbinary(255) UNIQUE,
       page_info           text NOT NULL,
       last_blob           int DEFAULT 8
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_page TO '$wgDBuser'","
CREATE INDEX ".$wgDBprefix."wikitrust_page_title_idx ON ".$wgDBprefix."wikitrust_page (page_title)
");

$create_scripts[$wgDBprefix.'wikitrust_vote'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_vote (
       revision_id         int NOT NULL,
       page_id             int NOT NULL,   
       voter_name          varbinary(255) NOT NULL,
       voted_on            varchar(32) NOT NULL,
       processed           bool DEFAULT false,
       PRIMARY KEY (revision_id, voter_name)
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_vote TO '$wgDBuser'","
CREATE INDEX ".$wgDBprefix."wikitrust_voted_processed_idx ON ".$wgDBprefix."wikitrust_vote (voted_on, processed)
");

$create_scripts[$wgDBprefix.'wikitrust_revision'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_revision (
        revision_id             int PRIMARY KEY,
        page_id                 int,
        text_id                 int,
        time_string             binary(14),
        user_id                 int, 
        username                varchar(255), 
        is_minor                tinyint(3) unsigned, 
        quality_info            text NOT NULL, 
        blob_id                 int NOT NULL,
        reputation_delta        float DEFAULT 0.0,
        overall_trust           float DEFAULT 0.0,
        overall_quality         float
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_revision TO '$wgDBuser'","
CREATE INDEX ".$wgDBprefix."wikitrust_revision_id_timestamp_idx ON "
. $wgDBprefix . "wikitrust_revision (page_id, time_string, revision_id)
");

$create_scripts[$wgDBprefix.'wikitrust_blob'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_blob (
        blob_id                 decimal(24) PRIMARY KEY, 
        blob_content            longblob NOT NULL
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_blob TO '$wgDBuser'","
");

$create_scripts[$wgDBprefix.'wikitrust_user'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_user (
       user_id     serial PRIMARY KEY,
       username    varchar(255),
       user_rep    float DEFAULT 0.0
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_user TO '$wgDBuser'", "
CREATE INDEX " . $wgDBprefix . "wikitrust_usernames_idx ON "
               . $wgDBprefix . "wikitrust_user (username)
");

$create_scripts[$wgDBprefix.'wikitrust_queue'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_queue (
       page_id         int NOT NULL,
       page_title      varchar(255) PRIMARY KEY, 
       requested_on    timestamp DEFAULT now(),
       processed       ENUM('unprocessed', 'processing', 'processed') NOT NULL DEFAULT 'unprocessed',
       priority        int unsigned DEFAULT 0
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_queue TO '$wgDBuser'", "
CREATE INDEX " . $wgDBprefix . "wikitrust_queue_idx ON "
               . $wgDBprefix . "wikitrust_queue (processed, requested_on)
");

$create_scripts[$wgDBprefix.'wikitrust_text_cache'] = array("
CREATE TABLE ".$wgDBprefix."wikitrust_text_cache (
       revision_id     int PRIMARY KEY,
       page_id         int,
       time_string     binary(14),
       revision_text   longtext NOT NULL
) ENGINE=InnoDB","
GRANT ALL ON ".$wgDBprefix."wikitrust_text_cache TO '$wgDBuser'", "
CREATE INDEX " . $wgDBprefix . "wikitrust_text_cache ON "
               . $wgDBprefix . "wikitrust_text_cache (revision_id, time_string, page_id)
");

$create_index_scripts[$wgDBprefix . "revision"]['wt_revision_id_timestamp_idx'] = "CREATE INDEX wt_revision_id_timestamp_idx ON " . $wgDBprefix . "revision (rev_id, rev_timestamp)";

$remove_scripts[$wgDBprefix.'wikitrust_vote'] = array("DROP TABLE ".$wgDBprefix."wikitrust_vote");
$remove_scripts[$wgDBprefix.'wikitrust_global'] = array("DROP TABLE ".$wgDBprefix."wikitrust_global");
$remove_scripts[$wgDBprefix.'wikitrust_page'] = array("DROP TABLE ".$wgDBprefix."wikitrust_page");
$remove_scripts[$wgDBprefix.'wikitrust_revision'] = array("DROP TABLE ".$wgDBprefix."wikitrust_revision");
$remove_scripts[$wgDBprefix.'wikitrust_blob'] = array("DROP TABLE ".$wgDBprefix."wikitrust_blob");
$remove_scripts[$wgDBprefix.'wikitrust_user'] = array("DROP TABLE ".$wgDBprefix."wikitrust_user");
$remove_scripts[$wgDBprefix.'wikitrust_queue'] = array("DROP TABLE ".$wgDBprefix."wikitrust_queue");
$remove_scripts[$wgDBprefix.'wikitrust_text_cache'] = array("DROP TABLE ".$wgDBprefix."wikitrust_text_cache");

$remove_index_scripts[$wgDBprefix . "revision"]['wt_revision_id_timestamp_idx'] = "DROP INDEX wt_revision_id_timestamp_idx ON ".$wgDBprefix."revision";

?>
