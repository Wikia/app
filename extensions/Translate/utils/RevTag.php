<?php
/**
 * Code related to revtag database table
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2011 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Abstraction for revtag table to handle new and old schemas during migration.
 */
class RevTag {
	protected static $schema = false;

	/**
	 * Determines the schema version.
	 *
	 * @return int
	 */
	public static function checkSchema() {
		if ( self::$schema !== false ) {
			return self::$schema;
		} else {
			$dbr = wfGetDB( DB_SLAVE );
			if ( $dbr->tableExists( 'revtag_type' ) ) {
				return self::$schema = 1;
			} else {
				return self::$schema = 2;
			}
		}
	}

	/**
	 * Returns value suitable for rt_type field.
	 * @param $tag string tag name
	 * @return int|string
	 */
	public static function getType( $tag ) {
		if ( self::checkSchema() === 2 ) {
			return $tag;
		}

		$tags = self::loadTags();

		if ( isset( $tags[$tag] ) ) {
			return $tags[$tag];
		} else {
			throw new MWException( "Unknown revtag $tag. Known are " . implode( ', ', array_keys( $tags ) ) );
		}
	}


	/**
	 * Converts rt_type field back to the tag name.
	 * @param $tag int rt_type value
	 * @return string
	 */
	public static function typeToTag( $tag ) {
		if ( self::checkSchema() === 2 ) {
			return $tag;
		}

		$tags = self::loadTags();
		$tags = array_flip( $tags );

		if ( isset( $tags[$tag] ) ) {
			return $tags[$tag];
		} else {
			throw new MWException( "Unknown revtag type $tag. Known are " . implode( ', ', array_keys( $tags ) ) );
		}
	}

	/**
	 * Loads the list of tags from database using the old schema
	 * @return array tag names => tag id
	 */
	protected static function loadTags() {
		static $tags = null;
		if ( $tags === null ) {
			$tags = array();

			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'revtag_type',
				array( 'rtt_name', 'rtt_id' ),
				array(),
				__METHOD__
			);

			foreach ( $res as $row ) {
				$tags[$row->rtt_name] = $row->rtt_id;
			}
		}
		return $tags;
	}

}
