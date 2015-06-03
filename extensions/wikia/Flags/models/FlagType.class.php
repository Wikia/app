<?php

/**
 * A model that reflects a type of flag that wikia's admins can define for their community.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags\Models;

class FlagType extends FlagsBaseModel {

	const FLAG_TARGETING_READERS = 1;
	const FLAG_TARGETING_CONTRIBUTORS = 2;

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
		self::FLAG_TARGETING_READERS => 'readers',
		self::FLAG_TARGETING_CONTRIBUTORS => 'contributors'
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
	public function getFlagTypeIdByTemplate( $wikiId, $flag_view ) {
		$db = $this->getDatabaseForRead();

		$flagTypeId = ( new \WikiaSQL() )
			->SELECT( 'flag_type_id' )
			->FROM( self::FLAGS_TYPES_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'flag_view')->EQUAL_TO( $flag_view )
			->run( $db, function( $result ) {
				$row = $result->fetchObject();
				return $row->flag_type_id;
			} );

		return $flagTypeId;
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
	 * @throws \InvalidParameterApiException
	 * @throws \MissingParameterApiException
	 */
	public function verifyParamsForAdd( $params ) {
		$required = [ 'wiki_id', 'flag_group', 'flag_name', 'flag_view', 'flag_targeting' ];

		foreach ( $required as $requiredField ) {
			if ( !isset( $params[$requiredField] ) ) {
				throw new \MissingParameterApiException( $requiredField ) ;
			}
		}

		if ( !isset( self::$flagGroups[$params['flag_group']] ) ) {
			throw new \InvalidParameterApiException( 'flag_group' );
		}

		return true;
	}

	/**
	 * If the passed params have been verified,
	 * performs an INSERT query that adds a new type of flags.
	 * @param array $params
	 * @return bool
	 */
	public function addFlagType( $params ) {
		$this->verifyParamsForAdd( $params );

		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->INSERT( self::FLAGS_TYPES_TABLE )
			->SET( 'wiki_id', $params['wiki_id'] )
			// flag_type_id is auto_increment
			->SET( 'flag_group', $params['flag_group'] )
			->SET( 'flag_name', $params['flag_name'] )
			->SET( 'flag_view', $params['flag_view'] )
			->SET( 'flag_targeting', $params['flag_targeting'] );

		if ( $params['flag_params_names'] !== null  ) {
			$sql->SET('flag_params_names', $params['flag_params_names'] );
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
	 * @throws \MissingParameterApiException
	 */
	public function verifyParamsForRemove( $params ) {
		if ( !isset( $params['flag_type_id'] ) ) {
			throw new \MissingParameterApiException( 'flag_type_id' );
		}

		return true;
	}

	/**
	 * Performs a DELETE query, removing the given type of flags
	 * @param $params
	 * @return bool
	 */
	public function removeFlagType( $params ) {
		$this->verifyParamsForRemove( $params );

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
