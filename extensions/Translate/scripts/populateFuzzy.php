<?php
/**
 * A script to populate fuzzy tags to revtag table.
 *
 * @author Niklas Laxstrom
 * @copyright Copyright © 2009-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

/// @cond

require( dirname( __FILE__ ) . '/cli.inc' );

$db = wfGetDB( DB_MASTER );

$id = $db->selectField( 'revtag_type', 'rtt_id', array( 'rtt_name' => 'fuzzy' ), __METHOD__ );
if ( $id === false ) {
	echo "Fuzzy tag is not registered\n";
	exit();
}

$count = $db->selectField( 'page', 'count(*)', array( 'page_namespace' => $wgTranslateMessageNamespaces ), __METHOD__ );
if ( !$count ) {
	echo "Nothing to update";
	exit();
}

$tables = array( 'page', 'text', 'revision' );
$fields = array( 'page_id', 'page_title', 'page_namespace', 'rev_id', 'old_text', 'old_flags' );
$conds = array(
	'page_latest = rev_id',
	'old_id = rev_text_id',
	'page_namespace' => $wgTranslateMessageNamespaces,
);

$limit = max( 1000, intval( $count / 100 ) );
$offset = 0;
while ( true ) {
	$inserts = array();
	echo "$offset/$count\n";
	$options = array( 'LIMIT' => $limit, 'OFFSET' => $offset );
	$res = $db->select( $tables, $fields, $conds, __METHOD__, $options );

	if ( !$res->numRows() ) {
		break;
	}

	foreach ( $res as $r ) {
		$text = Revision::getRevisionText( $r );
		if ( strpos( $text, TRANSLATE_FUZZY ) !== false ) {
			$inserts[] = array(
				'rt_page' => $r->page_id,
				'rt_revision' => $r->rev_id,
				'rt_type' => $id
			);
		}
	}

	$offset += $limit;

	$db->replace( 'revtag', 'rt_type_page_revision', $inserts, __METHOD__ );
}

/// @endcond
