<?php

namespace Flags\Models;

class Flag extends FlagsBaseModel {
	private
		$paramsVerified = false;

	/**
	 * GET methods
	 */

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
			foreach ( $flagsParams as $flagTypeId => $flagParams ) {
				$flagsForPage[$flagTypeId]['params'] = $flagParams;
			}
		}

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
				$flagsTypes[$row->flag_type_id] = get_object_vars( $row );
			} );

		return $flagsTypes;
	}

	private function getParamsForFlags( $flagsWithParams ) {
		$db = $this->getDatabaseForRead();

		$flagsParams = ( new \WikiaSQL() )
			->SELECT( 'flag_type_id', 'param_name', 'param_value' )
			->FROM( 'flags_params' )
			->WHERE( 'flag_id' )->IN( $flagsWithParams )
			->runLoop( $db, function( &$flagsParams, $row ) {
				$flagsParams[$row->flag_type_id][$row->param_name] = $row->param_value;
			} );

		return $flagsParams;
	}

	/**
	 * POST methods
	 */

	/**
	 * Adding flags
	 */

	public function verifyParamsForAdd( $params ) {
		if ( !isset( $params['wikiId'] )
			|| !isset( $params['pageId'] )
			|| ( !isset( $params['flags'] ) && !is_array( $params['flags'] ) )
		) {
			return false;
		}

		foreach( $params['flags'] as $flag ) {
			if ( !isset( $flag['flagTypeId'] ) ) {
				return false;
			}
		}

		$this->paramsVerified = true;
		return true;
	}

	public function addFlagsToPage( $params ) {
		if ( !$this->paramsVerified ) {
			return false;
		}

		$status = [];

		foreach ( $params['flags'] as $i => $flag ) {
			$status[$i] = $this->addFlag( $flag['flagTypeId'], $params['wikiId'], $params['pageId'], $flag['params'] );
		}

		return $status;
	}

	private function addFlag( $flagTypeId, $wikiId, $pageId, Array $params = [] ) {
		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->INSERT( self::FLAGS_TO_PAGES_TABLE )
			// flag_id is auto_increment
			->SET( 'flag_type_id', $flagTypeId )
			->SET( 'wiki_id', $wikiId )
			->SET( 'page_id', $pageId )
			->run( $db );

		$flagId = $db->insertId();

		$db->commit();

		if ( $flagId && !empty( $params ) ) {
			$paramsModel = new FlagParameter();
			$status = $paramsModel->createParametersForFlag( $flagId, $flagTypeId, $wikiId, $pageId, $params );
		}

		$this->paramsVerified = false;

		return $flagId && $status;
	}

	/**
	 * Removing flags
	 */

	public function removeFlagsFromPage( $params ) {
		if ( !$this->paramsVerified ) {
			return false;
		}

		$status = $this->removeFlags( $params['flagsIds'] );
		return $status;
	}

	public function verifyParamsForRemove( $params ) {
		if ( !isset( $params['flagsIds'] ) || !is_array( $params['flagsIds'] ) ) {
			$this->paramsVerified = false;
			return false;
		}

		$this->paramsVerified = true;
		return true;
	}

	private function removeFlags( Array $flagsIds ) {
		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->DELETE( self::FLAGS_TO_PAGES_TABLE )
			->WHERE( 'flag_id' )->IN( $flagsIds )
			->run( $db );

		$status = $db->affectedRows() > 0;
		$db->commit();

		return $status;
	}

	public function updateFlagsForPage( $flags ) {
		$status = [];

		$flagParameterModel = new FlagParameter();
		foreach ( $flags as $flag ) {
			$status[] = $flagParameterModel->updateParametersForFlag( $flag['flag_id'], $flag['params'] );
		}

		return $status;
	}
}
