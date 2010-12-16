<?php
/**
 * Creates a database of keys in all groups, so that namespace and key can be
 * used to get the group they belong to. This is used as a fallback when
 * loadgroup parameter is not provided in the request, which happens if someone
 * reaches a messages from somewhere else than Special:Translate.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2008-2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

class MessageIndexRebuilder {
	public static function execute() {
		$groups = MessageGroups::singleton()->getGroups();

		$hugearray = array();
		$postponed = array();

		STDOUT( "Working with ", 'main' );

		foreach ( $groups as $g ) {
			if ( !$g->exists() ) continue;
			# Skip meta thingies
			if ( $g->isMeta() ) {
				$postponed[] = $g;
				continue;
			}

			self::checkAndAdd( $hugearray, $g );
		}

		foreach ( $postponed as $g ) {
			self::checkAndAdd( $hugearray, $g, true );
		}

		global $wgCacheDirectory;
		$filename = "$wgCacheDirectory/translate_messageindex.cdb";
		$writer = CdbWriter::open( $filename );
		$writer->set( 'map', serialize( $hugearray ) );
		$writer->close();
	}

	protected static function checkAndAdd( &$hugearray, $g, $ignore = false ) {
		if ( $g instanceof MessageGroupBase ) {
			$cache = new MessageGroupCache( $g );
			if ( $cache->exists() ) {
				$keys = $cache->getKeys();
			} else {
				$keys = array_keys( $g->load( 'en' ) );
			}
		} else {
			$messages = $g->getDefinitions();
			if ( !is_array( $messages ) ) continue;
			$keys = array_keys( $messages );
		}

		$id = $g->getId();

		STDOUT( "$id ", 'main' );

		$namespace = $g->getNamespace();

		foreach ( $keys as $key ) {
			# Force all keys to lower case, because the case doesn't matter and it is
			# easier to do comparing when the case of first letter is unknown, because
			# mediawiki forces it to upper case
			$key = TranslateUtils::normaliseKey( $namespace, $key );
			if ( isset( $hugearray[$key] ) ) {
				if ( !$ignore ) {
					$to = implode( ', ', (array)$hugearray[$key] );
					STDERR( "Key $key already belongs to $to, conflict with $id" );
				}

				if ( is_array( $hugearray[$key] ) ) {
					// Hard work is already done, just add a new reference
					$hugearray[$key][] = &$id;
				} else {
					// Store the actual reference, then remove it from array, to not
					// replace the references value, but to store a array of new
					// references instead. References are hard!
					$value = &$hugearray[$key];
					unset( $hugearray[$key] );
					$hugearray[$key] = array( &$value, &$id );
				}
			} else {
				$hugearray[$key] = &$id;
			}
		}
		unset( $id ); // Disconnect the previous references to this $id
	}
}
