<?php

/**
 * A model that reflects an instance of a Flag
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
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
		} catch ( \Exception $exception ) {
			if ( $db !== null ) {
				$db->rollback();
			}
			throw $exception;
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
		if ( !$flagId > 0 ) {
			throw new \Exception( 'The database INSERT operation failed.' );
		}
		$status['flag_id'] = $flagId;

		if ( !empty( $params ) ) {
			$paramsModel = new FlagParameter();
			$paramsAdded = $paramsModel->createParametersForFlag( $db, $flagId, $flagTypeId, $params );
			$status['params_added'] = $paramsAdded;
		}

		return $status;
	}

	/**
	 * Verifies if a passed array has all of the required keys and values set
	 * @param array $params An array to analyze
	 * @return bool
	 * @throws \InvalidParameterApiException
	 * @throws \MissingParameterApiException
	 */
	private function verifyParamsForAdd( Array $params ) {
		$this->areParamsSet( $params, [ 'wiki_id', 'page_id', 'flags' ] );
		$this->arePositiveNumbers( [ $params['wiki_id'], $params['page_id'] ] );
		$this->areArrays( [ $params['flags'] ] );

		foreach( $params['flags'] as $flag ) {
			$this->areParamsSet( $flag, [ 'flag_type_id' ] );
			$this->arePositiveNumbers( $flag['flag_type_id'] );
		}

		return true;
	}

	/**
	 * Updating flags
	 */

	/**
	 * Updates parameters of the given flags
	 * @param array $flags Should have flag_id values as indexes
	 * @return array An array of statuses for each flag
	 * @throws \Exception
	 */
	public function updateFlagsForPage( $flags ) {
		try {
			$this->verifyParamsForUpdate( $flags );

			$db = $this->getDatabaseForWrite();

			$flagParameterModel = new FlagParameter();

			foreach ( $flags as $flag ) {
				$modelResponse[$flag['flag_id']] = $flagParameterModel->updateParametersForFlag( $db, $flag['flag_id'], $flag['params'] );
			}

			$db->commit();

			return $modelResponse;
		} catch( \Exception $exception ) {
			if ( $db !== null ) {
				$db->rollback();
			}
			throw $exception;
		}
	}

	/**
	 * Verifies if the passed arguments are valid
	 * @param array $flags An array to analyze
	 * @return bool
	 * @throws \InvalidParameterApiException
	 * @throws \MissingParameterApiException
	 */
	private function verifyParamsForUpdate( $flags ) {
		$this->areArrays( [ $flags ] );
		foreach ( $flags as $flag ) {
			$this->areArrays( [ $flag ] );
			$this->arePositiveNumbers( $flag['flag_id'] );
		}

		return true;
	}

	/**
	 * Removing flags
	 */

	/**
	 * Checks if parameters have been verified and
	 * sends a request to remove flags with the passed IDs
	 * @param array $flags An array of IDs of flags to remove
	 * @return bool
	 * @throws \Exception
	 */
	public function removeFlagsFromPage( Array $flags ) {
		try {
			$this->verifyParamsForRemove( $flags );

			$db = $this->getDatabaseForWrite();

			$flagsIds = [];
			foreach ( $flags as $flag ) {
				$flagsIds[] = $flag['flag_id'];
			}

			if ( $status = $this->removeFlags( $db, $flagsIds ) ) {
				$db->commit();
			}
			return $status;
		} catch( \Exception $exception ) {
			if ( $db !== null ) {
				$db->rollback();
			}
			throw $exception;
		}
	}

	public function getWikisWithFlags() {
		$db = $this->getDatabaseForRead();

		$wikiIds = ( new \WikiaSQL() )
			->SELECT()
			->DISTINCT( 'wiki_id' )
			->FROM( self::FLAGS_TO_PAGES_TABLE )
			->runLoop( $db, function( &$wikiIds, $row ) {
				$wikiIds[] = $row->wiki_id;
			} );

		return $wikiIds;
	}

	/**
	 * Performs a removal SQL query on instances of flags based on the passed flags_ids
	 * @param array $flagsIds
	 * @return bool
	 */
	private function removeFlags( \DatabaseBase $db, Array $flagsIds ) {
		( new \WikiaSQL() )
			->DELETE( self::FLAGS_TO_PAGES_TABLE )
			->WHERE( 'flag_id' )->IN( $flagsIds )
			->run( $db );
		$status = $db->affectedRows() > 0;
		return $status;
	}

	/**
	 * Verifies if parameters have a flags_ids field and if it is an array
	 * @param array $flags Should have a `flags_ids` key that contains an array of IDs
	 * @return bool
	 * @throws \InvalidParameterApiException
	 */
	private function verifyParamsForRemove( $flags ) {
		$this->areArrays( [ $flags ] );
		foreach ( $flags as $flag ) {
			$this->arePositiveNumbers( $flag['flag_id'] );
		}

		return true;
	}
}
