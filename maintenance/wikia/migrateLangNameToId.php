<?php
/**
 * Remove unused user accounts from the database
 * An unused account is one which has made no edits
 *
 * @file
 * @ingroup Maintenance
 * @author Rob Church <robchur@gmail.com>
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
$IP = $GLOBALS["IP"];
require_once( "commandLine.inc" );
$fname = 'migrateLangNameToId';

/*
CREATE TABLE `city_lang` (
  `lang_id` int(8) NOT NULL auto_increment,
  `lang_code` char(8) NOT NULL,
  `lang_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`lang_id`),
  KEY `lang_code_idx` (`lang_code`)
) ENGINE=InnoDB;
*/

# Do an initial scan for inactive accounts and report the result
echo( "Get language names...\n" );
$languages = Language::getLanguageNames();
$del = array();
$db1 = wfGetDB( DB_MASTER, 'stats', $wgExternalSharedDB );

if (!empty($languages)) :
	echo print_r($languages, true);
	echo "Insert " . count($languages) . " records to city_lang \n";
	foreach ( $languages as $id => $lang ) :
		$db1->insert(
			"city_lang",
			array(
			  'lang_id' => NULL,
			  'lang_code' => $id,
			  'lang_name' => $lang
			)
		);
	endforeach;	
endif;

echo "end \n";
