<?php

namespace Flags\Models;

class FlagType extends FlagsBaseModel {
	private
		$status,
		$paramsVerified = false;

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

	public function getFlagTypesForWikia( $wikiId ) {
		$db = $this->getDatabaseForRead();

		$flagTypesForWikia = ( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::FLAGS_TYPES_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->ORDER_BY( 'flag_name ASC' )
			->runLoop( $db, function( &$flagTypesForWikia, $row ) {
				$flagTypesForWikia[$row->flag_type_id] = get_object_vars( $row );
			} );

		return $flagTypesForWikia;
	}

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

	public function verifyParamsForRemove( $params ) {
		if ( !isset( $params['flagTypeId'] ) ) {
			return false;
		}

		$this->paramsVerified = true;
		return true;
	}

	/**
	 * @param $params
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

	public function removeFlagType( $params ) {
		if ( !$this->paramsVerified ) {
			return false;
		}

		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->DELETE( self::FLAGS_TYPES_TABLE )
			->WHERE( 'flag_type_id' )->EQUAL_TO( $params['flagTypeId'] )
			->run( $db );

		$this->status = $db->affectedRows() > 0;

		$db->commit();

		return $this->status;
	}
}
