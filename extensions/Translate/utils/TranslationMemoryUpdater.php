<?php
/**
 * Contains classes for updating the local translation memory.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 *  Class for updating the tmserver from translate toolkit during runtime.
 */
class TranslationMemoryUpdater {
	/**
	 * @static
	 * @param $article Article
	 * @param $user User
	 * @param  $text
	 * @param  $summary
	 * @param  $minor
	 * @param  $_
	 * @param  $_
	 * @param  $flags
	 * @param  $revision
	 * @return bool
	 */
	public static function update( $article, $user, $text, $summary, $minor, $_, $_, $flags, $revision ) {
		global $wgContLang;

		$dbw = self::getDatabaseHandle();
		// Not in use or misconfigured
		if ( $dbw === null ) {
			return true;
		}

		$title = $article->getTitle();
		// Something we are not interested in at all
		if ( !TranslateEditAddons::isMessageNamespace( $title ) ) {
			return true;
		}

		list( $key, $code, $group ) = TranslateEditAddons::getKeyCodeGroup( $title );
		// Unknown message, we cannot handle. We need definition.
		if ( !$group || !$code ) {
			return true;
		}

		// Skip definitions to not slow down mass imports etc.
		// These will be added when first translation is made
		if ( $code === 'en' ) {
			return true;
		}

		// Skip fuzzy messages
		if ( TranslateEditAddons::hasFuzzyString( $text ) ) {
			return true;
		}

		$ns_text = $wgContLang->getNsText( $group->getNamespace() );
		$definition = $group->getMessage( $key, 'en' );
		if ( !is_string( $definition ) || !strlen( $definition ) ) {
			wfDebugLog( 'tmserver', "Unable to get definition for $ns_text:$key/$code" );
			return true;
		}

		$tmDefinition = array(
			'text' => $definition,
			'context' => "$ns_text:$key",
			'length' => strlen( $definition ),
			'lang' => 'en'
		);

		// Check that the definition exists, add it if not
		$source_id = $dbw->selectField( '`sources`', 'sid', $tmDefinition, __METHOD__ );
		if ( $source_id === false ) {
			$dbw->insert( '`sources`', $tmDefinition, __METHOD__ );
			$source_id = $dbw->insertId();
			wfDebugLog( 'tmserver', "Inserted new tm-definition for $ns_text:$key:\n$definition\n----------" );
		}

		$delete = array(
			'sid' => $source_id,
			'lang' => $code,
		);

		$insert = $delete + array(
			'text' => $text,
			'time' => wfTimestamp(),
		);

		// Purge old translations for this message
		$dbw->delete( '`targets`', $delete, __METHOD__ );
		// We only do SQlite which does not need to know unique indexes
		$dbw->replace( '`targets`', null, $insert, __METHOD__ );
		wfDebugLog( 'tmserver', "Inserted new tm-translation for $ns_text:$key/$code" );

		return true;
	}

	/**
	 * Return a handle to tmserver database.
	 * Tmserver uses a sqlite database, which we access trough MediaWiki's
	 * SQLite database handler.
	 * @return DatabaseSqlite or null
	 */
	public static function getDatabaseHandle() {
		global $wgTranslateTranslationServices;

		$database = null;

		foreach ( $wgTranslateTranslationServices as $config ) {
			if ( $config['type'] === 'tmserver' && isset( $config['database'] ) ) {
				$database = $config['database'];
				break;
			}
		}

		if ( $database === null ) return null;

		if ( !is_string( $database ) ) {
			wfDebugLog( 'tmserver', 'Database configuration is not a string' );
			return null;
		}

		if ( !file_exists( $database ) ) {
			wfDebugLog( 'tmserver', 'Database file does not exist' );
			return null;
		}

		if ( !is_writable( $database ) ) {
			wfDebugLog( 'tmserver', 'Database file is not writable' );
			return null;
		}

		return new DatabaseSqliteStandalone( $database );
	}
}
