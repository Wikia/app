<?php
/**
 * Creates a database of keys in all groups, so that namespace and key can be
 * used to get the group they belong to. This is used as a fallback when
 * loadgroup parameter is not provided in the request, which happens if someone
 * reaches a messages from somewhere else than Special:Translate.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

require( dirname(__FILE__) . '/cli.inc' );

$groups = MessageGroups::singleton()->getGroups();

$hugearray = array();
$postponed = array();

foreach ( $groups as $g ) {
	# Skip meta thingies
	if ( $g->isMeta() ) {
		$postponed[] = $g;
		continue;
	}

	checkAndAdd( $g );
}

foreach ( $postponed as $g ) {
	checkAndAdd( $g, true );
}

wfMkdirParents( dirname(TRANSLATE_INDEXFILE) );
file_put_contents( TRANSLATE_INDEXFILE, serialize( $hugearray ) );

function checkAndAdd( $g, $ignore = false ) {
	global $hugearray;

	$messages = $g->getDefinitions();
	$id = $g->getId();

	if ( is_array( $messages ) ) {
		STDOUT( "Working with $id" );
	} else {
		STDOUT( "Something wrong with $id... skipping" );
		continue;
	}

	$namespace = $g->namespaces[0];

	foreach ( $messages as $key => $data ) {
		# Force all keys to lower case, because the case doesn't matter and it is
		# easier to do comparing when the case of first letter is unknown, because
		# mediawiki forces it to upper case
		$key = strtolower( "$namespace:$key" );
		if ( isset($hugearray[$key]) ) {
			if ( !$ignore )
				STDOUT( "Key $key already belongs to $hugearray[$key], conflict with $id" );
		} else {
			$hugearray[$key] = &$id;
		}
	}
	unset($id); // Disconnect the previous references to this $id

}