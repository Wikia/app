<?php
/**
 * StarterWiki
 *
 * @author Daniel Friesen (http://mediawiki.org/wiki/User:Dantman) <mediawiki@danielfriesen.name>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Use the current wiki database (starter) as a base for creating a new one.
 */

$optionsWithArgs = array( 'database' );
$wgUseMasterForMaintenance = true;
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/maintenance/commandLine.inc' );
$wgTitle = Title::newFromText( "StarterWiki Database Creator" );

function usageInfo() {
	echo <<<TEXT
Usage:
	php createWikiDBFromStarter.php --help
	php createWikiDBFromStarter.php --database=<database>

	--help                          : This help message
	--database=<database>           : The name of the database to create.

TEXT;
	exit( 0 );
}

function tryRunCreate( $db ) {
	global $options;
	if ( isset( $options['help'] ) || !isset( $options['database'] ) ) usageInfo();
	if ( doCreateWiki( $db, $options['database'] ) ) {
		echo "Finished...\n";
		exit( 0 );
	} else {
		echo "Failed...\n";
		exit( 1 );
	}
}

function doCreateWiki( $db, $newDB ) {
	global $wgDBname, $wgStarterWikiPageAliases, $wgStarterWikiOmitNamespaces;
	// Create the new Database, and make sure to use the same character set and collation as this one.
	$dbData = $db->selectRow( '`INFORMATION_SCHEMA`.`SCHEMATA`',
		array( "DEFAULT_CHARACTER_SET_NAME AS 'character_set'", "DEFAULT_COLLATION_NAME AS 'collation'" ),
		array( 'SCHEMA_NAME' => $wgDBname ), __METHOD__ );

	if ( (bool) $db->query( "CREATE DATABASE `{$newDB}` CHARACTER SET {$dbData->character_set} COLLATE {$dbData->collation}" ) ) {
		echo "New database created\n";
	} else {
		echo "Could not create the database, it may already exist.\n";
		return false;
	}

	// Copy the structure of all the Starter tables to the new wiki.
	$res = $db->query( "SHOW TABLES FROM `{$wgDBname}`" );
	while ( $row = $db->fetchRow( $res ) ) {
		$table = $row["Tables_in_{$wgDBname}"];
		if ( (bool) $db->query( "CREATE TABLE `{$newDB}`.`{$table}` LIKE `{$wgDBname}`.`{$table}`" ) ) {
			echo "Cloned structure for table `{$table}` from starter.\n";
		} else {
			echo "Failed to clone structure for table `{$table}` from starter.\n";
			return false;
		}
	}

	// We need a common time to add things in at.
	$now = $db->timestamp( time() );
	if ( isset( $wgStarterWikiOmitNamespaces ) && is_array( $wgStarterWikiOmitNamespaces ) ) {
		// Output a nice SELECT statment that gives us only the starter data we need.
		$notNamespaces = $db->makeList( $wgStarterWikiOmitNamespaces, LIST_COMMA );
		if ( $notNamespaces != '' ) {
			$notNamespaces = "AND page_namespace NOT IN ({$notNamespaces})";
		}
	}
	$res = $db->query( "
SELECT
	page_namespace AS namespace,
	page_title AS title,
	page_restrictions AS restrictions,
	0 AS page_counter,
	page_is_redirect AS is_redirect,
	0 AS page_is_new,
	page_random AS random,
	rev_comment AS comment,
	rev_len AS length,
	old_text AS text,
	old_flags AS flags
FROM
	`{$wgDBname}`.`page`,
	`{$wgDBname}`.`revision`,
	`{$wgDBname}`.`text`
WHERE
	page_id=rev_page
	AND page_latest=rev_id
	AND rev_text_id=old_id
	{$notNamespaces}
GROUP BY page_id ASC
ORDER BY rev_id DESC" );

	while ( $row = $db->fetchObject( $res ) ) {
		// Don't copy overrided pages.
		if ( in_array( "{$row->namespace}:{$row->title}", $wgStarterWikiPageAliases ) ) continue;

		// Insert Text Data into the Database.
		$oldId = $db->nextSequenceValue( 'text_old_id_seq' );
		$db->insert( "`{$newDB}`.`text`", array(
			'old_id'    => $oldId,
			'old_text'  => $row->text,
			'old_flags' => $row->flags
		) );
		$oldId = $db->insertId();
		if ( $db->affectedRows() > 0 ) {
			echo "Inserted text data for {$row->namespace}:{$row->title}\n";
		} else {
			echo "Failed to insert text data for {$row->namespace}:{$row->title}\n";
			return false;
		}
		// Insert Revision Data into the Database.
		$revId = $db->nextSequenceValue( 'revision_rev_id_seq' );
		$db->insert( "`{$newDB}`.`revision`", array(
				'rev_id'        => $revId,
				'rev_text_id'   => $oldId,
				'rev_comment'   => $row->comment,
				'rev_user'      => 0,
				'rev_user_text' => "MediaWiki default",
				'rev_timestamp' => $now,
				'rev_len'       => $row->length
			) );
		$revId = $db->insertId();
		if ( $db->affectedRows() > 0 ) {
			echo "Created initial revision for {$row->namespace}:{$row->title}\n";
		} else {
			echo "Failed to create initial revision for {$row->namespace}:{$row->title}\n";
			return false;
		}
		// Insert Page Data into the Database.
		$pageId = $db->nextSequenceValue( 'page_page_id_seq' );
		$alias = null;
		if ( isset( $wgStarterWikiPageAliases["{$row->namespace}:{$row->title}"] ) ) {
			$alias = array();
			list( $alias['namespace'], $alias['title'] ) = explode( ':', $wgStarterWikiPageAliases["{$row->namespace}:{$row->title}"], 2 );
		}
		$db->insert( "`{$newDB}`.`page`", array(
				'page_id'           => $pageId,
				'page_namespace'    => isset( $alias ) ? $alias['namespace'] : $row->namespace,
				'page_title'        => isset( $alias ) ? $alias['title'] : $row->title,
				'page_is_redirect'  => $row->is_redirect,
				'page_random'       => $row->random,
				'page_touched'      => $now,
				'page_latest'       => $revId,
				'page_len'          => $row->length
			) );
		$pageId = $db->insertId();
		if ( $db->affectedRows() > 0 ) {
			echo "Inserted page row for {$row->namespace}:[]$row->title}\n";
		} else {
			echo "Failed to insert page row for {$row->namespace}:[]$row->title}\n";
			return false;
		}
		if ( $db->set( "`{$newDB}`.`revision`",
				'rev_page', $pageId,
				"rev_id = {$revId}" ) ) {
			echo "Set rev_id for {$row->namespace}:{$row->title} to the correct value.\n";
		} else {
			echo "Failed to set rev_id for {$row->namespace}:{$row->title} to the correct value.\n";
		}
	}
	return true;
}

tryRunCreate( wfGetDB( DB_MASTER ) );
