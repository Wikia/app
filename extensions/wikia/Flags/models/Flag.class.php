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
		foreach ( $flagsForPage as $flagTypeId => $flag ) {
			if ( !empty( $flag['flag_params_names'] ) ) {
				$flagsWithParams[] = $flag['flag_id'];
			} else {
				$flagsForPage[$flagTypeId]['params'] = [];
			}
		}

		if ( !empty( $flagsWithParams ) ) {
			$flagsParams = $this->getParamsForFlags( $flagsWithParams );
			foreach ( $flagsParams as $flagTypeId => $flagParams ) {
				$flagsForPage[$flagTypeId]['params'] = $flagParams;
			}
		}

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

		$flagsWithTypes = ( new \WikiaSQL() )
			->SELECT_ALL( 'flags_to_pages', 'flags_types' )
			->FROM( 'flags_to_pages' )
			->INNER_JOIN( 'flags_types' )
				->ON( 'flags_types.flag_type_id', 'flags_to_pages.flag_type_id' )
			->WHERE( 'flags_to_pages.wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'flags_to_pages.page_id' )->EQUAL_TO( $pageId )
			->runLoop( $db, function( &$flagsWithTypes, $row ) {
				$flagsWithTypes[$row->flag_type_id] = get_object_vars( $row );

				/**
				 * Get a URL for a template of the flag.
				 * If the template under flag_view does not exist - we will just
				 * display a red link so there is no need to check if $title exists.
				 */
				$title = \Title::newFromText( $row->flag_view, NS_TEMPLATE );
				$flagsWithTypes[$row->flag_type_id]['flag_view_url'] = $title->getFullURL();
			} );

		return $flagsWithTypes;
	}

	/**
	 * Fetches parameters for a set of flags
	 * @param array $flags_ids An array of IDs of flags to get params for
	 * @return bool|array An array with IDs of flags as indexes
	 */
	private function getParamsForFlags( $flags_ids ) {
		$db = $this->getDatabaseForRead();

		$flagsParams = ( new \WikiaSQL() )
			->SELECT( 'flag_type_id', 'param_name', 'param_value' )
			->FROM( 'flags_params' )
			->WHERE( 'flag_id' )->IN( $flags_ids )
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
	 * @throws \InvalidParameterApiException
	 * @throws \MissingParameterApiException
	 */
	public function verifyParamsForAdd( Array $params ) {
		if ( !isset( $params['wiki_id'] ) ) throw new \MissingParameterApiException( 'wiki_id' );
		if ( !isset( $params['page_id'] ) ) throw new \MissingParameterApiException( 'page_id' );
		if ( !isset( $params['flags'] ) ) throw new \MissingParameterApiException( 'flags' );

		if ( !is_numeric( $params['wiki_id'] ) ) throw new \InvalidParameterApiException( 'wiki_id' );
		if ( !is_numeric( $params['page_id'] ) ) throw new \InvalidParameterApiException( 'page_id' );
		if ( !is_array( $params['flags'] ) ) throw new \InvalidParameterApiException( 'flags' );

		foreach( $params['flags'] as $flag ) {
			if ( !isset( $flag['flag_type_id'] ) ) throw new \MissingParameterApiException( 'flag_type_id' );
			if ( !is_numeric( $flag['flag_type_id'] ) ) throw new \InvalidParameterApiException( 'flag_type_id' );
		}

		return true;
	}

	/**
	 * Wrapper for an addition of multiple flags
	 * @param array $params
	 * @return array|bool Returns an array of status codes or false if params have not been verified
	 * @throws \Exception
	 * @throws \InvalidParameterApiException
	 * @throws \MissingParameterApiException
	 */
	public function addFlagsToPage( $params ) {
		try {
			$this->verifyParamsForAdd( $params );

			$db = $this->getDatabaseForWrite();

			$addedFlags = [];
			foreach ( $params['flags'] as $flag ) {
				$addedFlags[] = $this->addFlag( $db, $flag[ 'flag_type_id' ], $params[ 'wiki_id' ], $params[ 'page_id' ], $flag[ 'params' ] );
			}

			$db->commit();

			return $addedFlags;
		} catch ( \Exception $e ) {
			$db->rollback();
			throw $e;
		}
	}

	/**
	 * Adds an instance of a flag. Performs an SQL query to the flags_to_pages table
	 * and then adds flags parameters if they are fetched, using the last inserted flag_id.
	 * @param \DatabaseBase $db
	 * @param int $flagTypeId
	 * @param int $wikiId
	 * @param int $pageId
	 * @param array $params
	 * @return bool
	 * @throws \Exception
	 */
	private function addFlag( \DatabaseBase $db, $flagTypeId, $wikiId, $pageId, Array $params = [] ) {
		$status = [];

		( new \WikiaSQL() )
			->INSERT( self::FLAGS_TO_PAGES_TABLE )
			// flag_id is auto_increment
			->SET( 'flag_type_id', $flagTypeId )
			->SET( 'wiki_id', $wikiId )
			->SET( 'page_id', $pageId )
			->run( $db );

		$flagId = $db->insertId();
		if ( !$flagId > 0 ) throw new \Exception( 'The database INSERT operation failed.' );
		$status['flag_id'] = $flagId;

		if ( !empty( $params ) ) {
			$paramsModel = new FlagParameter();
			$paramsAdded = $paramsModel->createParametersForFlag( $db, $flagId, $flagTypeId, $params );
			$status['params_added'] = $paramsAdded;
		}

		$this->paramsVerified = false;

		return $flagId && $status;
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
		$flagParameterModel = new FlagParameter();
		foreach ( $flags as $flag ) {
			$modelResponse[$flag['flag_id']] = $flagParameterModel->updateParametersForFlag( $flag['flag_id'], $flag['params'] );
		}

		return $modelResponse;
	}

	/**
	 * Removing flags
	 */

	/**
	 * Verifies if parameters have a flags_ids field and if it is an array
	 * @param array $flags Should have a `flags_ids` key that contains an array of IDs
	 * @return bool
	 * @throws \InvalidParameterApiException
	 */
	public function verifyParamsForRemove( $flags ) {
		if ( !is_array( $flags ) ) throw new \InvalidParameterApiException( 'flags' );
		foreach ( $flags as $flagId ) {
			if ( !is_numeric( $flagId ) ) throw new \InvalidParameterApiException( 'flags' );
		}

		return true;
	}

	/**
	 * Checks if parameters have been verified and
	 * sends a request to remove flags with the passed IDs
	 * @param array $flags An array of IDs of flags to remove
	 * @return bool
	 */
	public function removeFlagsFromPage( Array $flags ) {
		if ( $this->verifyParamsForRemove( $flags ) ) {
			$status = $this->removeFlags( $flags );
			return $status;
		}
	}

	/**
	 * Performs a removal SQL query on instances of flags based on the passed flags_ids
	 * @param array $flags
	 * @return bool
	 */
	private function removeFlags( Array $flags ) {
		$db = $this->getDatabaseForWrite();

		( new \WikiaSQL() )
			->DELETE( self::FLAGS_TO_PAGES_TABLE )
			->WHERE( 'flag_id' )->IN( $flags )
			->run( $db );
		$status = $db->affectedRows() > 0;
		$db->commit();

		return $status;
	}
}
