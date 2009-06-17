<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

$dbr = WikiFactory::db( DB_SLAVE );
$dbw = wfGetDB( DB_SLAVE );

/**
 * find dbs not defined in city_variables
 **/
print "Checking for databases defined in RDBS but not in city_list\n";
$sth = $dbr->select(
	array( "city_variables" ),
	array( "cv_value" ),
	array( "cv_variable_id = (SELECT cv_id FROM city_variables_pool WHERE cv_name='wgDBname')" ),
	__FILE__,
	array( "ORDER BY" => "cv_value" )
);

$DB_NAMES = array();
while( $row = $dbr->fetchObject( $sth ) ) {
	$db_name = unserialize($row->cv_value);
	if ( !empty($db_name) ) {
		$DB_NAMES[$db_name] = 1;
	}
};
$dbr->freeResult( $sth );

$sth = $dbw->select(
	array( "INFORMATION_SCHEMA.SCHEMATA" ),
	array( "distinct(SCHEMA_NAME) as dbname " ),
	false,
	__FILE__,
	array( "ORDER BY" => "1" )
);

while( $row = $dbw->fetchObject( $sth ) ) {
	if ( !isset($DB_NAMES[$row->dbname]) ) {
		print "{$row->dbname} exists, but is not used in city_variables\n";
	}
}
$dbw->freeResult( $sth );

/**
 * find duplicates of city_dbname in city_list
 */
print "Checking for duplicates in city_list\n";
$sth = $dbr->select(
	array( "city_list" ),
	array( "city_dbname", "count(city_dbname) as count" ),
	false,
	__FILE__,
	array( "GROUP BY" => "city_dbname" )
);
while( $row = $dbr->fetchObject( $sth ) ) {
	if( $row->count != 1 ) {
		print "{$row->city_dbname} is used more than once in city_list";
	}
}

$dbr->freeResult( $sth );

/**
 * find duplicates in city_variables
 */
print "Checking for duplicates in city_variables\n";
$sth = $dbr->select(
	array( "city_variables" ),
	array( "cv_value", "count(cv_value) as count" ),
	array( "cv_variable_id = (SELECT cv_id FROM city_variables_pool WHERE cv_name='wgDBname')" ),
	__FILE__,
	array( "GROUP BY" => "cv_value" )
);
while( $row = $dbr->fetchObject( $sth ) ) {
	if( $row->count != 1 ) {
		print "{$row->cv_value} is used more than once in city_variables";
	}
}

$dbr->freeResult( $sth );

/**
 * check if archived images directories are not removed
 *
 * first, take data from archive wgUploadDirectory => cv_variable_id = 17
 */
print "Checking for orphaned image directories\n";
$dirs = array();
$dba = wfGetDB( DB_SLAVE, array(), "archive" );
$stha = $dba->select(
	array( "city_variables" ),
	array( "*" ),
	array( "cv_variable_id" => 17 ),
	__FILE__
);
while( $row = $dba->fetchObject( $stha ) ) {
	$dirs[ unserialize( $row->cv_value ) ] = $row->cv_city_id;
}

foreach( $dirs as $dir => $city_id ) {
	if( file_exists( $dir ) && is_dir( $dir ) ) {
		/**
		 * check if is connected to any wiki alive or not
		 */
		$row = $dbr->selectRow(
			array( "city_variables" ),
			array( "cv_city_id" ),
			array( "cv_variable_id" => 17, "cv_value" => serialize( $dir ) ),
			__FILE__
		);
		if( !empty( $row->cv_city_id ) ) {
			$wiki = WikiFactory::getWikiByID( $row->cv_city_id );
			print "Directory {$dir} is taken by {$wiki->city_id}:{$wiki->city_url} which status is {$wiki->city_public}\n";
		}
		else {
			print "Directory {$dir} exists but is not connected to any wiki\n";
		}
	}
}


/**
 * compare values stored in city_list and city_variables
 */
print "Compare values stored in city_list and city_variables\n";
$sth = $dbr->select(
	array( "city_list" ),
	array( "city_dbname", "city_id", "city_public" ),
	false,
	__FILE__,
	array( "ORDER BY" => "city_id" )
);

while( $row = $dbr->fetchObject( $sth ) ) {
	$variable = $dbr->selectRow(
		array( "city_variables" ),
		array( "cv_value" ),
		array(
			"cv_city_id" => $row->city_id,
			"cv_variable_id = (SELECT cv_id FROM city_variables_pool WHERE cv_name='wgDBname')"
		),
		__FILE__
	);

	if( !empty( $variable->cv_value ) ) {
		if( unserialize( $variable->cv_value ) !== $row->city_dbname ) {
			print "wgDBname different than city_dbname in city_id={$row->city_id} city_public={$row->city_public}\n";
		}
		else {
			/**
			 * check if such database exists
			 */
			$exists = $dbw->selectRow(
				array( "INFORMATION_SCHEMA.SCHEMATA" ),
 				array( "count(SCHEMA_NAME) as count" ),
				array( "SCHEMA_NAME" => $row->city_dbname ),
				__FILE__
			);
			if( !$exists->count ) {
				print "city_dbname={$row->city_dbname} defined but not exists for city_id={$row->city_id} city_public={$row->city_public}\n";
			}
		}
	}
	else {
		print "wgDBname is not defined in city_id={$row->city_id} city_public={$row->city_public}\n";
	}
}
