<?php

/**
 * A model that reflects a type of flag that wikia's admins can define for their community.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags\Models;

class FlagType extends FlagsBaseModel {
	private
		$paramsVerified = false;

	/**
	 * Flags are organized in groups. We store this information as integers in the database.
	 * Let's translate the numbers into something more readable!
	 * @var array
	 */
	public static $flagGroups = [
		1 => 'spoiler',
		2 => 'disambig',
		3 => 'canon',
		4 => 'stub',
		5 => 'delete',
		6 => 'improvements',
		7 => 'status',
		8 => 'other'
	];

	/**
	 * Flags can be targeted to different user groups.	 *
	 * @var array
	 */
	public static $flagTargeting = [
		1 => 'readers',
		2 => 'contributors'
	];

	/**
	 * Get flag groups mapping
	 * @return array flag groups mapping
	 */
	public function getFlagGroupsMapping() {
		return self::$flagGroups;
	}

	/**
	 * Get flag group name by id
	 * @param $flagGroupId
	 * @return string|null
	 */
	public function getFlagGroupName( $flagGroupId ) {
		return isset( self::$flagGroups[$flagGroupId] ) ? self::$flagGroups[$flagGroupId] : null;
	}

	/**
	 * Get flag group id by name
	 * @param $flagGroupName
	 * @return int|false
	 */
	public function getFlagGroupId ( $flagGroupName ) {
		return array_search( strtolower( $flagGroupName ), self::$flagGroups );
	}

	/**
	 * Get flag user targeting mapping
	 * @return array
	 */
	public function getFlagTargetingMapping() {
		return self::$flagTargeting;
	}

	/*
	 * Get flag user targeting name by id
	 * @return string|null
	 */
	public function getFlagTargetingName( $flagTargetingId ) {
		return isset( self::$flagTargeting[$flagTargetingId] ) ? self::$flagTargeting[$flagTargetingId] : null;
	}

	/**
	 * Get flag user targeting id by name
	 * @param $flagTargetingName
	 * @return string|false
	 */
	public function getFlagTargetingId ( $flagTargetingName ) {
		return array_search( strtolower( $flagTargetingName ), self::$flagTargeting );
	}

	/**
	 * Fetches all types of flags available on a wikia from the database
	 * @param int $wikiId
	 * @return bool|mixed
	 */
	public function getFlagTypesForWikia( $wikiId ) {
		$db = $this->getDatabaseForRead();

		$flagTypesForWikia = ( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::FLAGS_TYPES_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->ORDER_BY( 'flag_name ASC' )
			->runLoop( $db, function( &$flagTypesForWikia, $row ) {
				$flagTypesForWikia[$row->flag_type_id] = get_object_vars( $row );

				/**
				 * Create URLs for a template of the flag
				 */
				$title = \Title::newFromText( $row->flag_view, NS_TEMPLATE );
				$flagTypesForWikia[$row->flag_type_id]['flag_view_url'] = $title->getFullURL();
			} );

		return $flagTypesForWikia;
	}

	/**
	 * Adding types of flags
	 */

	/**
	 * Verify in the fetched array has every required information
	 * before performing an INSERT query.
	 * @param array $params
	 * @return bool
	 */
	public function verifyParamsForAdd( $params ) {
		$required = [ 'wiki_id', 'flagGroup', 'flagName', 'flagView', 'flagTargeting' ];

		foreach ( $required as $requiredField ) {
			if ( !isset( $params[$requiredField] ) ) {
				return false; // Lack of a required parameter
			}
		}

		if ( !isset( self::$flagGroups[$params['flagGroup']] ) ) {
			return false; // Unrecognized flag group
		}

		$this->paramsVerified = true;
		return true;
	}

	/**
	 * If the passed params have been verified,
	 * performs an INSERT query that adds a new type of flags.
	 * @param array $params
	 * @return bool
	 */
	public function addFlagType( $params ) {
		if ( !$this->paramsVerified ) {
			return false;
		}

		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->INSERT( self::FLAGS_TYPES_TABLE )
			->SET( 'wiki_id', $params['wiki_id'] )
			// flag_type_id is auto_increment
			->SET( 'flag_group', $params['flagGroup'] )
			->SET( 'flag_name', $params['flagName'] )
			->SET( 'flag_view', $params['flagView'] )
			->SET( 'flag_targeting', $params['flagTargeting'] );

		if ( $params['flagParamsNames'] !== null  ) {
			$sql->SET('flag_params_names', $params['flagParamsNames'] );
		}

		$sql->run( $db );

		$flagTypeId = $db->insertId();

		$db->commit();

		$this->paramsVerified = false;

		return $flagTypeId;
	}

	/**
	 * Removing types of flags
	 */

	/**
	 * Verifies if a `flagTypeId` has been set
	 * @param array $params
	 * @return bool
	 */
	public function verifyParamsForRemove( $params ) {
		if ( !isset( $params['flag_type_id'] ) ) {
			return false;
		}

		$this->paramsVerified = true;
		return true;
	}

	/**
	 * Performs a DELETE query, removing the given type of flags
	 * @param $params
	 * @return bool
	 */
	public function removeFlagType( $params ) {
		if ( !$this->paramsVerified ) {
			return false;
		}

		$db = $this->getDatabaseForWrite();

		( new \WikiaSQL() )
			->DELETE( self::FLAGS_TYPES_TABLE )
			->WHERE( 'flag_type_id' )->EQUAL_TO( $params['flag_type_id'] )
			->run( $db );

		$status = $db->affectedRows() > 0;

		$db->commit();

		return $status;
	}
}
