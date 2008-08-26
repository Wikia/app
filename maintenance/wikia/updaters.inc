<?php
/**
 * Wikia-specific updaters
 *
 * @addtogroup Maintenance
 * 
 * @author Tomasz Klim <tomek@wikia.com>
 * @copyright Copyright (C) 2007 Tomasz Klim, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */


if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is not a valid entry point\n";
	exit( 1 );
}

$wgRenamedTablesWikia = array(
#       from                    to                  patch file
#	array( 'group',         'groups',           'patch-rename-group.sql' ),
);

$wgNewTablesWikia = array(
#       table                   patch file (in maintenance/wikia/archives)
/**     some examples:
	array( 'hitcounter',    'patch-hitcounter.sql' ),
	array( 'querycache',    'patch-querycache.sql' ),
	array( 'objectcache',   'patch-objectcache.sql' ),
/**/
);

$wgNewFieldsWikia = array(
#       table                   field               patch file (in maintenance/wikia/archives)
/**     some examples:
	array( 'ipblocks',      'ipb_id',           'patch-ipblocks.sql' ),
	array( 'ipblocks',      'ipb_expiry',       'patch-ipb_expiry.sql' ),
	array( 'recentchanges', 'rc_type',          'patch-rc_type.sql' ),
	array( 'recentchanges', 'rc_ip',            'patch-rc_ip.sql' ),
	array( 'recentchanges', 'rc_id',            'patch-rc_id.sql' ),
/**/
);


function rename_table_wikia( $from, $to, $patch ) {
	global $wgDatabase;
	if ( $wgDatabase->tableExists( $from ) ) {
		if ( $wgDatabase->tableExists( $to ) ) {
			echo "...can't move table $from to $to, $to already exists.\n";
		} else {
			echo "Moving table $from to $to...";
			dbsource( archive_wikia($patch), $wgDatabase );
			echo "ok\n";
		}
	} else {
		// Source table does not exist
		// Renames are done before creations, so this is typical for a new installation
		// Ignore silently
	}
}

function add_table_wikia( $name, $patch ) {
	global $wgDatabase;
	if ( $wgDatabase->tableExists( $name ) ) {
		echo "...$name table already exists.\n";
	} else {
		echo "Creating $name table...";
		dbsource( archive_wikia($patch), $wgDatabase );
		echo "ok\n";
	}
}

function add_field_wikia( $table, $field, $patch ) {
	global $wgDatabase;
	if ( !$wgDatabase->tableExists( $table ) ) {
		echo "...$table table does not exist, skipping new field patch\n";
	} elseif ( $wgDatabase->fieldExists( $table, $field ) ) {
		echo "...have $field field in $table table.\n";
	} else {
		echo "Adding $field field to table $table...";
		dbsource( archive_wikia($patch) , $wgDatabase );
		echo "ok\n";
	}
}


function do_wikia_updates( $shared = false, $purge = true ) {
	global $wgNewTablesWikia, $wgNewFieldsWikia, $wgRenamedTablesWikia, $wgSharedDB, $wgDatabase;

	$doUser = !$wgSharedDB || $shared;

	# Rename tables
	foreach ( $wgRenamedTablesWikia as $tableRecord ) {
		rename_table_wikia( $tableRecord[0], $tableRecord[1], $tableRecord[2] );
	}

	# Add missing tables
	foreach ( $wgNewTablesWikia as $tableRecord ) {
		add_table_wikia( $tableRecord[0], $tableRecord[1] );
		flush();
	}

	# Add missing fields
	foreach ( $wgNewFieldsWikia as $fieldRecord ) {
		if ( $fieldRecord[0] != 'user' || $doUser ) {
			add_field_wikia( $fieldRecord[0], $fieldRecord[1], $fieldRecord[2] );
		}
		flush();
	}

	echo "Done\n"; flush();
}


function archive_wikia($name) {
	global $wgDBtype, $IP;
	switch ($wgDBtype) {
	// @fixme: add mysql5 and postgres items or....?
	default:
		return "$IP/maintenance/wikia/archives/$name";
	}
}


?>
