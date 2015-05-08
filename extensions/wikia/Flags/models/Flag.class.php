<?php

namespace Flags\Models;

class Flag extends FlagsModel {
	const FLAG_ACTION_ADD = 'add';
	const FLAG_ACTION_REMOVE = 'remove';

	private
		$paramsVerified = false,
		$status;

	public function getFlagsForPage( $wikiId, $pageId ) {
		/**
		 * 1. Get flags data for the page
		 */
		$flagsForPage = $this->getFlagsTypesForPage( $wikiId, $pageId );


		/**
		 * 2. Get parameters for flags that need them
		 */
		$flagsWithParams = [];
		foreach ( $flagsForPage as $flag ) {
			if ( !empty( $flag['flag_params_names'] ) ) {
				$flagsWithParams[] = $flag['flag_id'];
			}
		}

		if ( !empty( $flagsWithParams ) ) {
			$flagsParams = $this->getParamsForFlags( $flagsWithParams );
			foreach ( $flagsParams as $flagId => $flagParams ) {
				$flagsForPage[ $flagId ]['params'] = $flagParams;
			}
		}

		var_dump( $flagsForPage );

		/**
		 * 3. Return the ready table
		 */
		return $flagsForPage;
	}

	private function getFlagsTypesForPage( $wikiId, $pageId ) {
		$db = $this->getDatabaseForRead();

		$flagsTypes = ( new \WikiaSQL() )
			->SELECT_ALL( 'flags_to_pages', 'flags_types' )
			->FROM( 'flags_to_pages' )
			->INNER_JOIN( 'flags_types' )
				->ON( 'flags_types.flag_type_id', 'flags_to_pages.flag_type_id' )
			->WHERE( 'flags_to_pages.wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'flags_to_pages.page_id' )->EQUAL_TO( $pageId )
			->runLoop( $db, function( &$flagsTypes, $row ) {
				$flagsTypes[ $row->flag_id ] = get_object_vars( $row );
			} );

		return $flagsTypes;
	}

	private function getParamsForFlags( $flagsWithParams ) {
		$db = $this->getDatabaseForRead();

		$flagsParams = ( new \WikiaSQL() )
			->SELECT( 'flag_id', 'param_name', 'param_value' )
			->FROM( 'flags_params' )
			->WHERE( 'flag_id' )->IN( $flagsWithParams )
			->runLoop( $db, function( &$flagsParams, $row ) {
				$flagsParams[ $row->flag_id ][ $row->param_name ] = $row->param_value;
			} );

		return $flagsParams;
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
			case self::FLAG_ACTION_ADD:
				$flagParams = [];
				if ( isset( $params['flagParams'] ) ) {
					$flagParams = json_decode( $params['flagParams'] );
				}
				$this->status = $this->addFlag( $params['flagTypeId'], $params['wikiId'], $params['pageId'], $flagParams );
				break;
			case self::FLAG_ACTION_REMOVE:
				$this->status = $this->removeFlag( $params['flagId'] );
				break;
		}

		return $this->status;
	}

	public function verifyParamsForAction( $action, $params ) {
		$this->debug( [ $action, $params ] );
		switch ( $action ) {
			case self::FLAG_ACTION_ADD:
				$required = [ 'flagTypeId', 'wikiId', 'pageId' ];
				break;
			case self::FLAG_ACTION_REMOVE:
				$required = [ 'flag_id' ];
				break;
			default:
				return false; // Unknown action
		}

		foreach ( $required as $requiredField ) {
			if ( !isset( $params[ $requiredField ] ) ) {
				return false; // Lack of a required parameter
			}
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
	 * @param $pageId
	 * @param $flagTypeId
	 * @param array $params
	 * @return bool
	 */

	private function addFlag( $flagTypeId, $wikiId, $pageId, Array $params = [] ) {

		$this->debug( [ $wikiId, $pageId, $flagTypeId ] );

		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->INSERT( self::FLAGS_TO_PAGES_TABLE )
				// flag_id is auto_increment
				->SET( 'flag_type_id', $flagTypeId )
				->SET( 'wiki_id', $wikiId )
				->SET( 'page_id', $pageId )
			->run( $db );

		$db->commit();

		$status = $db->affectedRows() > 0;

		if ( $status && !empty( $params ) ) {
			$flagId = $db->insertId();
			$paramsModel = new FlagParameter();
			$status = $paramsModel->createParametersForFlag( $flagId, $wikiId, $pageId, $flagTypeId, $params );
		}

		return $status;
	}

	private function removeFlag( $flagId, $removeParams = false ) {
		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->DELETE( self::FLAGS_TO_PAGES_TABLE )
			->WHERE( 'flag_id' )->EQUAL_TO( $flagId )
			->run( $db );

		$db->commit();

		$status = $db->affectedRows() > 0;

		if ( $status && $removeParams ) {
			$paramsModel = new FlagParameter();
			$status = $paramsModel->deleteParametersForFlag( $flagId );
		}

		return $status;
	}
}
