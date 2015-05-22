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
		$status,
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

	public function getFlagGroupsMapping() {
		return self::$flagGroups;
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
		$required = [ 'wikiId', 'flagGroup', 'flagName', 'flagView', 'flagTargeting' ];

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
			->SET( 'wiki_id', $params['wikiId'] )
			// flag_type_id is auto_increment
			->SET( 'flag_group', $params['flagGroup'] )
			->SET( 'flag_name', $params['flagName'] )
			->SET( 'flag_view', $params['flagView'] )
			->SET( 'flag_targeting', $params['flagTargeting'] );

		if ( $params['flagParamsNames'] !== null  ) {
			$sql->SET('flag_params_names', $params['flagParamsNames'] );
		}

		$sql->run( $db );

		$this->status = $db->affectedRows() > 0;

		$db->commit();

		return $this->status;
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

		$this->status = $db->affectedRows() > 0;

		$db->commit();

		return $this->status;
	}
}
