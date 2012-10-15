<?php
/**
 * This file aims to provide efficient mechanism for fetching translation completion stats.
 *
 * @file
 * @author Wikia http://trac.wikia-code.com/browser/wikia/trunk/extensions/wikia/TranslationStatistics
 * @author Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * This class abstract MessageGroup statistics calculation and storing.
 * You can access stats easily per language or per group.
 * Stat array for each item is of format array( total, translate, fuzzy ).
 *
 * @ingroup Stats MessageGroups
 */
class MessageGroupStats {
	/// Name of the database table
	const TABLE = 'translate_groupstats';

	const TOTAL = 0;
	const TRANSLATED = 1;
	const FUZZY = 2;

	/// @var float
	protected static $timeStart = null;
	/// @var float
	protected static $limit = null;

	/**
	 * Set the maximum time statistics are calculated.
	 * If the time limit is exceeded, the missing
	 * entries will be null.
	 * @param $limit float time in seconds
	 */
	public static function setTimeLimit( $limit ) {
		self::$timeStart = microtime( true );
		self::$limit = $limit;
	}

	/**
	 * Returns stats for given group in given language.
	 * @param $id string Group id
	 * @param $code string Language code
	 * @return Array
	 */
	public static function forItem( $id, $code ) {
		$res = self::selectRowsIdLang( $id, $code );
		$stats = self::extractResults( $res );

		$group = MessageGroups::getGroup( $id );

		if ( !isset( $stats[$id][$code] ) ) {
			$stats[$id][$code] = self::forItemInternal( $stats, $group, $code );
		}

		return $stats[$id][$code];
	}

	/**
	 * Returns stats for all groups in given language.
	 * @param $code string Language code
	 * @return Array
	 */
	public static function forLanguage( $code ) {
		$stats = self::forLanguageInternal( $code );
		$flattened = array();
		foreach ( $stats as $group => $languages ) {
			$flattened[$group] = $languages[$code];
		}
		return $flattened;
	}

	/**
	 * Returns stats for all languages in given group.
	 * @param $id string Group id
	 * @return Array
	 */
	public static function forGroup( $id ) {
		$group = MessageGroups::getGroup( $id );
		if ( $group === null ) {
			return array();
		}
		$stats = self::forGroupInternal( $group );
		return $stats[$id];
	}

	/**
	 * Returns stats for all group in all languages.
	 * Might be slow, might use lots of memory.
	 * Returns two dimensional array indexed by group and language.
	 * @return Array
	 */
	public static function forEverything() {
		$groups = MessageGroups::singleton()->getGroups();
		$stats = array();
		foreach ( $groups as $g ) {
			$stats = self::forGroupInternal( $g, $stats );
		}
		return $stats;
	}

	public static function clear( MessageHandle $handle ) {
		$dbw = wfGetDB( DB_MASTER );
		$conds = array(
			'tgs_group' => $handle->getGroupIds(),
			'tgs_lang' => $handle->getCode(),
		);

		$dbw->delete( self::TABLE, $conds, __METHOD__ );
		wfDebugLog( 'messagegroupstats', "Cleared " . serialize( $conds ) );
	}

	public static function clearGroup( $id ) {
		if ( !count( $id ) ) return;
		$dbw = wfGetDB( DB_MASTER );
		$conds = array( 'tgs_group' => $id );
		$dbw->delete( self::TABLE, $conds, __METHOD__ );
		wfDebugLog( 'messagegroupstats', "Cleared " . serialize( $conds ) );
	}

	public static function clearLanguage( $code ) {
		if ( !count( $code ) ) return;
		$dbw = wfGetDB( DB_MASTER );
		$conds = array( 'tgs_lang' => $code );
		$dbw->delete( self::TABLE, $conds, __METHOD__ );
		wfDebugLog( 'messagegroupstats', "Cleared " . serialize( $conds ) );
	}

	/**
	 * Purges all cached stats.
	 */
	public static function clearAll() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( self::TABLE, '*' );
		wfDebugLog( 'messagegroupstats', "Cleared everything :(" );
	}

	protected static function extractResults( $res, $stats = array() ) {
		foreach ( $res as $row ) {
			$stats[$row->tgs_group][$row->tgs_lang] = self::extractNumbers( $row );
		}
		return $stats;
	}

	public static function update( MessageHandle $handle, $changes = array() ) {
		$dbw = wfGetDB( DB_MASTER );
		$conds = array(
			'tgs_group' => $handle->getGroupIds(),
			'tgs_lang' => $handle->getCode(),
		);

		$values = array();
		foreach ( array( 'total', 'translated', 'fuzzy' ) as $type ) {
			if ( !isset( $changes[$type] ) ) {
				$values[] = "tgs_$type=tgs_$type" .
					self::stringifyNumber( $changes[$type] );
			}
		}

		$dbw->update( self::TABLE, $values, $conds, __METHOD__ );
	}

	/**
	 * Returns an array of needed database fields.
	 * @param $row
	 * @return array
	 */
	protected static function extractNumbers( $row ) {
		return array(
			(int)$row->tgs_total,
			(int)$row->tgs_translated,
			(int)$row->tgs_fuzzy
		);
	}

	protected static function forLanguageInternal( $code, $stats = array() ) {
		$res = self::selectRowsIdLang( null, $code );
		$stats = self::extractResults( $res, $stats );

		$groups = MessageGroups::singleton()->getGroups();
		foreach ( $groups as $id => $group ) {
			if ( isset( $stats[$id][$code] ) ) continue;
			$stats[$id][$code] = self::forItemInternal( $stats, $group, $code );
		}
		return $stats;
	}

	protected static function expandAggregates( MessageGroup $group ) {
		$flattened = array( $group->getId() );
		if ( $group instanceof AggregateMessageGroup ) {
			foreach ( $group->getGroups() as $subgroup ) {
				$flattened = array_merge( $flattened, self::expandAggregates( $subgroup ) );
			}
		}
		return $flattened;
	}

	protected static function forGroupInternal( $group, $stats = array() ) {
		$id = $group->getId();
		$res = self::selectRowsIdLang( $id, null );
		$stats = self::extractResults( $res, $stats );

		# Go over each language filling missing entries
		$languages = array_keys( Language::getLanguageNames( false ) );
		// This is for calculating things in correct order
		sort( $languages );
		foreach ( $languages as $code ) {
			if ( isset( $stats[$id][$code] ) ) continue;
			$stats[$id][$code] = self::forItemInternal( $stats, $group, $code );
		}

		// This is for sorting the values added later in correct order
		foreach ( array_keys( $stats ) as $key ) {
			ksort( $stats[$key] );
		}

		return $stats;
	}

	protected static function selectRowsIdLang( $ids = null, $codes = null ) {
		$conds = array();
		if ( $ids !== null ) {
			$conds['tgs_group'] = $ids;
		}

		if ( $codes !== null ) {
			$conds['tgs_lang'] = $codes;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( self::TABLE, '*', $conds, __METHOD__ );
		return $res;
	}

	protected static function forItemInternal( &$stats, $group, $code ) {
		$id = $group->getId();

		if ( self::$timeStart !== null && ( microtime( true ) - self::$timeStart ) > self::$limit ) {
			return $stats[$id][$code] = array( null, null, null );
		}

		if ( $group instanceof AggregateMessageGroup ) {
			$ids = array_unique( self::expandAggregates( $group ) );
			$res = self::selectRowsIdLang( $ids, $code );
			$stats = self::extractResults( $res, $stats );

			$aggregates = array( 0, 0, 0 );
			foreach ( $group->getGroups() as $sid => $subgroup ) {
				# Discouraged groups may belong to a another group, usually if there
				# is a aggregate group for all translatable pages. In that case
				# calculate and store the statistics, but don't count them as part of
				# the aggregate group, so that the numbers in Special:LanguageStats
				# add up. The statistics for discouraged groups can still be viewed
				# through Special:MessageGroupStats.
				if ( !isset( $stats[$sid][$code] ) ) {
					$stats[$sid][$code] = self::forItemInternal( $stats, $subgroup, $code );
				}
				if ( MessageGroups::getPriority( $subgroup ) !== 'discouraged' ) {
					$aggregates = self::multiAdd( $aggregates, $stats[$sid][$code] );
				}
			}
			$stats[$id][$code] = $aggregates;
		} else {
			$aggregates = self::calculateGroup( $group, $code );
		}

		list( $total, $translated, $fuzzy ) = $aggregates;

		// Don't add nulls to the database, causes annoying warnings
		if ( $total === null ) {
			return $aggregates;
		}

		$data = array(
			'tgs_group' => $id,
			'tgs_lang' => $code,
			'tgs_total' => $total,
			'tgs_translated' => $translated,
			'tgs_fuzzy' => $fuzzy,
		);

		$dbw = wfGetDB( DB_MASTER );
		$errors = $dbw->ignoreErrors( true );
		$dbw->insert(
			self::TABLE,
			$data,
			__METHOD__
		);

		$dbw->ignoreErrors( $errors );
		return $aggregates;
	}

	public static function multiAdd( &$a, $b ) {
		if ( $a[0] === null || $b[0] === null ) {
			return array_fill( 0, count( $a ), null );
		}
		foreach ( $a as $i => &$v ) {
			$v += $b[$i];
		}
		return $a;
	}

	protected static function calculateGroup( $group, $code ) {
		global $wgTranslateDocumentationLanguageCode;
		# Calculate if missing and store in the db
		$collection = $group->initCollection( $code );


		if ( $code === $wgTranslateDocumentationLanguageCode ) {
			$ffs = $group->getFFS();
			if ( $ffs instanceof GettextFFS ) {
				$template = $ffs->read( 'en' );
				$infile = array();
				foreach ( $template['TEMPLATE'] as $key => $data ) {
					if ( isset( $data['comments']['.'] ) ) {
						$infile[$key] = '1';
					}
				}
				$collection->setInFile( $infile );
			}
		}

		$collection->filter( 'ignored' );
		$collection->filter( 'optional' );
		// Store the count of real messages for later calculation.
		$total = count( $collection );

		// Count fuzzy first.
		$collection->filter( 'fuzzy' );
		$fuzzy = $total - count( $collection );

		// Count the completed translations.
		$collection->filter( 'hastranslation', false );
		$translated = count( $collection );

		return array( $total, $translated, $fuzzy );
	}

	/**
	 * Converts input to "+2" "-4" type of string.
	 * @param $number int
	 * @return string
	 */
	protected static function stringifyNumber( $number ) {
		$number = intval( $number );
		return $number < 0 ? "$number" : "+$number";
	}
}
