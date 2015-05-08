<?php

namespace Flags\Models;

class FlagType extends FlagsModel {
	const FLAG_TYPE_ACTION_ADD = 'add';
	const FLAG_TYPE_ACTION_REMOVE = 'remove';

	private
		$status,
		$paramsVerified = false,
		$flagGroups = [
			1 => 'Spoiler',
			2 => 'Disambiguation',
			3 => 'Canon',
			4 => 'Stub',
			5 => 'Article management',
			6 => 'Article improvement',
			7 => 'Article status',
			8 => 'For readers',
			9 => 'For contributors',
		];

	public function getFlagGroupsMapping() {
		return $this->flagGroups;
	}

	public function getFlagTypesForWikia( $wikiId ) {

	}

	public function performAction( $action, $params ) {
		/**
		 * The data should be verified in the
		 * verifyParamsForAction() method before
		 * performing an action
		 */
		if ( !$this->paramsVerified ) {
			return false;
		}

		switch ( $action ) {
			case self::FLAG_TYPE_ACTION_ADD:
				$flagParamsNames = null;
				if ( isset( $params['flagParamsNames'] ) ) {
					$flagParamsNames = $params['flagParamsNames'];
				}
				$this->status = $this->addFlagType(
					$params['wikiId'],
					$params['flagGroup'],
					$params['flagName'],
					$params['flagView'],
					$params['flagTargeting'],
					$flagParamsNames
				);
				break;
			case self::FLAG_TYPE_ACTION_REMOVE:
				$this->status = $this->removeFlagType( $params['flagTypeId'] );
				break;
		}

		return $this->status;
	}

	public function verifyParamsForAction( $action, $params ) {
		switch ( $action ) {
			case self::FLAG_TYPE_ACTION_ADD:
				$required = [ 'wikiId', 'flagGroup', 'flagName', 'flagView', 'flagTargeting' ];
				break;
			case self::FLAG_TYPE_ACTION_REMOVE:
				$required = [ 'wiki_id', 'flagTypeId' ];
				break;
			default:
				return false; // Unknown action
		}

		foreach ( $required as $requiredField ) {
			if ( !isset( $params[ $requiredField ] ) ) {
				return false; // Lack of a required parameter
			}
		}

		/**
		 * Check if the given group exists
		 */
		if ( !isset( $this->flagGroups[ $params['flagGroup'] ] ) ) {
			return false; // Unrecognized flag group
		}

		$this->paramsVerified = true;
		return true;
	}

	/**
	 * The following private methods are used to modify data
	 * in databases e.g. perform INSERT, UPDATE and DELETE actions.
	 * They're not meant to be called directly but via the
	 * performAction() method.
	 */

	/**
	 * @param $wikiId
	 * @param $flagGroup
	 * @param $flagName
	 * @param $flagView
	 * @param $flagTargeting
	 * @param $flagParamsNames
	 * @return bool
	 */
	private function addFlagType( $wikiId, $flagGroup, $flagName, $flagView, $flagTargeting, $flagParamsNames ) {
		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->INSERT( self::FLAGS_TYPES_TABLE )
			->SET( 'wiki_id', $wikiId )
			// flag_type_id is auto_increment
			->SET( 'flag_group', $flagGroup )
			->SET( 'flag_name', $flagName )
			->SET( 'flag_view', $flagView )
			->SET( 'flag_targeting', $flagTargeting );
			if ( $flagParamsNames !== null  ) {
				$sql->SET('flag_params_names', $flagParamsNames);
			}
			$sql->run( $db );

		$db->commit();

		$this->status = $db->affectedRows() > 0;

		return $this->status;
	}

	private function removeFlagType( $wikiId, $flagType, $removeParams = false ) {
		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->DELETE( self::FLAGS_TO_PAGES_TABLE )
			->WHERE( 'flag_type_id' )->EQUAL_TO( $flagType )
			->run( $db );

		$db->commit();

		$this->status = $db->affectedRows() > 0;

		if ( $this->status && $removeParams ) {
			$paramsModel = new FlagParameter();
			$this->status = $paramsModel->deleteParametersForFlag( $wikiId, $pageId, $flagType );
		}

		return $this->status;
	}
}
