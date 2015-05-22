<?php

/**
 * A model that reflects an instance of a Flag
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags\Models;

class Flag extends FlagsBaseModel {
	private
		$paramsVerified = false;

	/**
	 * GET methods
	 */

	/**
	 * Retrieves instances of flags for the given page with associated parameters.
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @return bool|mixed
	 */
	public function getFlagsForPage( $wikiId, $pageId ) {
		/**
		 * 1. Get flags data for the page from a database
		 */
		$flagsForPage = $this->getFlagsForPageFromDatabase( $wikiId, $pageId );


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

	/**
	 * Do an actual SQL query to retrieve the instances of flags for the given page
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @return bool|mixed
	 * @throws \FluentSql\Exception\SqlException
	 */
	private function getFlagsForPageFromDatabase( $wikiId, $pageId ) {
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

				/**
				 * Create URLs for a template of the flag
				 */
				$title = \Title::newFromText( $row->flag_view, NS_TEMPLATE );
				$flagsTypes[$row->flag_type_id]['flag_view_url'] = $title->getFullURL();
			} );

		return $flagsTypes;
	}

	/**
	 * Fetches parameters for a set of flags
	 * @param array $flagsIds An array of IDs of flags to get params for
	 * @return bool|array An array with IDs of flags as indexes
	 */
	private function getParamsForFlags( $flagsIds ) {
		$db = $this->getDatabaseForRead();

		$flagsParams = ( new \WikiaSQL() )
			->SELECT( 'flag_type_id', 'param_name', 'param_value' )
			->FROM( 'flags_params' )
			->WHERE( 'flag_id' )->IN( $flagsIds )
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

	/**
	 * Verifies if a passed array has all of the required keys and values set
	 * @param array $params An array to analyze
	 * @return bool
	 */
	public function verifyParamsForAdd( Array $params ) {
		if ( !isset( $params['wiki_id'] )
			|| !isset( $params['page_id'] )
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

	/**
	 * Wrapper for an addition of multiple flags
	 * @param array $params
	 * @return array|bool Returns an array of status codes or false if params have not been verified
	 */
	public function addFlagsToPage( $params ) {
		if ( !$this->paramsVerified ) {
			return false;
		}

		$status = [];

		foreach ( $params['flags'] as $i => $flag ) {
			$status[$i] = $this->addFlag( $flag['flagTypeId'], $params['wiki_id'], $params['page_id'], $flag['params'] );
		}

		return $status;
	}

	/**
	 * Adds an instance of a flag. Performs an SQL query to the flags_to_pages table
	 * and then adds flags parameters if they are fetched, using the last inserted flag_id.
	 * @param int $flagTypeId
	 * @param int $wikiId
	 * @param int $pageId
	 * @param array $params
	 * @return bool
	 */
	private function addFlag( $flagTypeId, $wikiId, $pageId, Array $params = [] ) {
		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->INSERT( self::FLAGS_TO_PAGES_TABLE )
			// flag_id is auto_increment
			->SET( 'flag_type_id', $flagTypeId )
			->SET( 'wiki_id', $wikiId )
			->SET( 'page_id', $pageId )
			->run( $db );

		$status = $db->affectedRows() > 0;
		$flagId = $db->insertId();

		$db->commit();

		if ( $status && !empty( $params ) ) {
			$paramsModel = new FlagParameter();
			$status = $paramsModel->createParametersForFlag( $flagId, $flagTypeId, $wikiId, $pageId, $params );
		}

		return $status;
	}

	/**
	 * Updating flags
	 */

	/**
	 * Updates parameters of the given flags
	 * @param array $flags Should have flag_id values as indexes
	 * @return array An array of statuses for each flag
	 */
	public function updateFlagsForPage( $flags ) {
		$status = [];

		$flagParameterModel = new FlagParameter();
		foreach ( $flags as $flag ) {
			$status[] = $flagParameterModel->updateParametersForFlag( $flag['flag_id'], $flag['params'] );
		}

		return $status;
	}

	/**
	 * Removing flags
	 */

	/**
	 * Checks if parameters have been verified and
	 * sends a request to remove flags with the passed IDs
	 * @param array $params An array of IDs of flags to remove under a `flagsIds` key
	 * @return bool
	 */
	public function removeFlagsFromPage( Array $params ) {
		if ( !$this->paramsVerified ) {
			return false;
		}

		$status = $this->removeFlags( $params['flagsIds'] );
		return $status;
	}

	/**
	 * Verifies if parameters have a flagsIds field and if it is an array
	 * @param array $params Should have a `flagsIds` key that contains an array of IDs
	 * @return bool
	 */
	public function verifyParamsForRemove( $params ) {
		if ( !isset( $params['flagsIds'] ) || !is_array( $params['flagsIds'] ) ) {
			$this->paramsVerified = false;
			return false;
		}

		$this->paramsVerified = true;
		return true;
	}

	/**
	 * Performs a removal SQL query on instances of flags based on the passed flagsIds
	 * @param array $flagsIds
	 * @return bool
	 */
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
}
