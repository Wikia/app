<?php
/**
 * Class containing utility functions for per-user stats
 */
class FRUserCounters {
	/**
	 * Get params for a user ID
	 * @param int $uid
	 * @param int $flags FR_MASTER, FR_FOR_UPDATE
	 * @param string $dBName, optional wiki name
	 * @return array
	 */
	public static function getUserParams( $uid, $flags = 0, $dBName = false ) {
		$p = array();
		$row = self::fetchParamsRow( $uid, $flags, $dBName );
		if ( $row ) {
			$p = self::expandParams( $row->frp_user_params );
		}
		self::setUnitializedFields( $p );
		return $p;
	}

	/**
	 * Get params for a user
	 * @param User $user
	 * @return array|null
	 */
	public static function getParams( User $user ) {
		if ( $user->getId() ) {
			if ( !isset( $user->fr_user_params ) ) { // process cache...
				$user->fr_user_params = self::getUserParams( $user->getId() );
			}
			return $user->fr_user_params;
		}
		return null;
	}

	/**
	 * Initializes unset param fields to their starting values
	 * @param &array $p
	 */
	protected static function setUnitializedFields( array &$p ) {
		if ( !isset( $p['uniqueContentPages'] ) ) {
			$p['uniqueContentPages'] = array();
		}
		if ( !isset( $p['totalContentEdits'] ) ) {
			$p['totalContentEdits'] = 0;
		}
		if ( !isset( $p['editComments'] ) ) {
			$p['editComments'] = 0;
		}
		if ( !isset( $p['revertedEdits'] ) ) {
			$p['revertedEdits'] = 0;
		}
	}

	/**
	 * Get the params row for a user
	 * @param int $uid
	 * @param int $flags FR_MASTER, FR_FOR_UPDATE
	 * @param string $dBName, optional wiki name
	 * @return mixed (false or Row)
	 */
	protected static function fetchParamsRow( $uid, $flags = 0, $dBName = false ) {
		$options = array();
		if ( $flags & FR_MASTER || $flags & FR_FOR_UPDATE ) {
			$db = wfGetDB( DB_MASTER, array(), $dBName );
			if ( $flags & FR_FOR_UPDATE ) $options[] = 'FOR UPDATE';
		} else {
			$db = wfGetDB( DB_SLAVE, array(), $dBName );
		}
		return $db->selectRow( 'flaggedrevs_promote',
			'frp_user_params',
			array( 'frp_user_id' => $uid ),
			__METHOD__,
			$options
		);
	}

	/**
	 * Save params for a user
	 * @param int $uid
	 * @param array $params
	 * @param string $dBName, optional wiki name
	 * @return bool success
	 */
	public static function saveUserParams( $uid, array $params, $dBName = false ) {
		$dbw = wfGetDB( DB_MASTER, array(), $dBName );
		$dbw->replace( 'flaggedrevs_promote',
			array( 'frp_user_id' ),
			array( 'frp_user_id' => $uid,
				'frp_user_params' => self::flattenParams( $params ) ),
			__METHOD__
		);
		return ( $dbw->affectedRows() > 0 );
	}

	/**
	 * Increments a count for a user
	 * @param int $uid User id
	 * @param string $param Count name
	 * @return string
	 */
	public static function incCount( $uid, $param ) {
		$p = self::getUserParams( $uid, FR_FOR_UPDATE );
		if ( !isset( $p[$param] ) ) {
			$p[$param] = 0;
		}
		$p[$param]++;
		FRUserCounters::saveUserParams( $uid, $p );
	}

	/**
	 * Flatten params for a user for DB storage
	 * Note: param values must be integers
	 * @param array $params
	 * @return string
	 */
	protected static function flattenParams( array $params ) {
		$flatRows = array();
		foreach ( $params as $key => $value ) {
			if ( strpos( $key, '=' ) !== false || strpos( $key, "\n" ) !== false ) {
				throw new MWException( "flattenParams() - key cannot use '=' or newline" );
			}
			if ( $key === 'uniqueContentPages' ) { // list
				$value = implode( ',', array_map( 'intval', $value ) );
			} else {
				$value = intval( $value );
			}
			$flatRows[] = trim( $key ) . '=' . $value;
		}
		return implode( "\n", $flatRows );
	}

	/**
	 * Expand params for a user from DB storage
	 * @param string $flatPars
	 * @return array
	 */
	protected static function expandParams( $flatPars ) {
		$p = array(); // init
		$flatPars = explode( "\n", trim( $flatPars ) );
		foreach ( $flatPars as $pair ) {
			$m = explode( '=', trim( $pair ), 2 );
			$key = $m[0];
			$value = isset( $m[1] ) ? $m[1] : null;
			if ( $key === 'uniqueContentPages' ) { // list
				$value = ( $value === '' )
					? array() // explode() would make array( 0 => '')
					: array_map( 'intval', explode( ',', $value ) );
			} else {
				$value = intval( $value );
			}
			$p[$key] = $value;
		}
		return $p;
	}

	/**
	 * Update users params array for a user on edit
	 * @param &array $p user params
	 * @param Page $article the article just edited
	 * @param string $summary edit summary
	 * @return bool anything changed
	 */
	public static function updateUserParams( array &$p, Page $article, $summary ) {
		global $wgFlaggedRevsAutoconfirm, $wgFlaggedRevsAutopromote;
		# Update any special counters for non-null revisions
		$changed = false;
		if ( $article->getTitle()->isContentPage() ) {
			$pages = $p['uniqueContentPages']; // page IDs
			# Don't let this get bloated for no reason
			$maxUniquePages = 50; // some flexibility
			if ( is_array( $wgFlaggedRevsAutoconfirm ) &&
				$wgFlaggedRevsAutoconfirm['uniqueContentPages'] > $maxUniquePages )
			{
				$maxUniquePages = $wgFlaggedRevsAutoconfirm['uniqueContentPages'];
			}
			if ( is_array( $wgFlaggedRevsAutopromote ) &&
				$wgFlaggedRevsAutopromote['uniqueContentPages'] > $maxUniquePages )
			{
				$maxUniquePages = $wgFlaggedRevsAutopromote['uniqueContentPages'];
			}
			if ( count( $pages ) < $maxUniquePages // limit the size of this
				&& !in_array( $article->getId(), $pages ) )
			{
				$pages[] = $article->getId();
				$p['uniqueContentPages'] = $pages;
			}
			$p['totalContentEdits'] += 1;
			$changed = true;
		}
		// Record non-automatic summary tally
		if ( !preg_match( '/^\/\*.*\*\/$/', $summary ) ) {
			$p['editComments'] += 1;
			$changed = true;
		}
		return $changed;
	}
}
