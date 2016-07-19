<?php

use Wikia\Logger\WikiaLogger;

/**
 * Class WikiaMapsPoiCategoryController
 * AJAX entry points for points of interest's categories (POI category) manipulations
 */
class WikiaMapsPoiCategoryController extends WikiaMapsBaseController {
	private $logEntries = [];

	/**
	 * Returns parent/default POI categories received from the service
	 */
	public function getParentPoiCategories() {
		$parentPoiCategoriesResponse = $this->getModel()->getParentPoiCategories();
		$this->setVal( 'results', $parentPoiCategoriesResponse );
	}

	/**
	 * Entry point to save POI categories
	 *
	 * @requestParam Integer $mapId an unique map id
	 * @requestParam Array $poiCategoriesToCreate an array of POI categories to create
	 * @requestParam Array $poiCategoriesToUpdate an array of POI categories to update
	 * @requestParam Array $poiCategoriesToDelete an array of POI categories ids to delete
	 *
	 * @throws WikiaMapsPermissionException
	 * @throws BadRequestApiException
	 */
	public function editPoiCategories() {
		// Temporary change required for ad purpose - https://wikia-inc.atlassian.net/browse/DAT-4051.
		// We need to limit contribution options on protected maps related to the ad campaign only to stuff
		// users.
		// TODO: remove this as a part of https://wikia-inc.atlassian.net/browse/DAT-4055
		if ( $this->shouldDisableProtectedMapEdit( $this->request->getInt( 'mapId' ) ) ) {
			return;
		}

		$this->setData( 'userName', $this->wg->User->getName() );

		$this->organizePoiCategoriesData();
		$this->validatePoiCategoriesData();
		$this->createPoiCategories();
		$this->updatePoiCategories();
		$this->deletePoiCategories();

		WikiaMapsLogger::addLogEntries( $this->logEntries );
		$this->logEntries = [];

		$results = [
			'success' => true,
			'content' => $this->getResultsContent()
		];
		
		$this->setVal( 'results', $results );
	}

	/**
	 * Cleans up POI category data
	 *
	 * @param array $poiCategory
	 * @return array
	 */
	public function cleanUpPoiCategoryData( $poiCategory ) {
		if ( empty( $poiCategory[ 'id' ] ) ) {
			unset( $poiCategory[ 'id' ] );
		} else {
			$poiCategory[ 'id' ] = (int) $poiCategory[ 'id' ];
		}

		if ( isset( $poiCategory[ 'name' ] ) ) {
			$poiCategory[ 'name' ] = trim( $poiCategory[ 'name' ] );
		}

		$poiCategory[ 'parent_poi_category_id' ] = ( !empty( $poiCategory[ 'parent_poi_category_id' ] ) ) ?
			(int) $poiCategory[ 'parent_poi_category_id' ] :
			$this->getModel()->getDefaultParentPoiCategory();

		// if user didn't upload marker then this is empty string. we don't want to send it to api.
		if ( empty( $poiCategory [ 'marker' ] ) ) {
			unset( $poiCategory [ 'marker' ] );
		}

		return $poiCategory;
	}

	/**
	 * Prepares data from request for processing
	 */
	private function organizePoiCategoriesData() {
		$mapId = $this->request->getInt( 'mapId' );
		$this->setData( 'mapId', $mapId );

		$poiCategoriesToCreate = $this->request->getArray( 'poiCategoriesToCreate' );
		foreach ( $poiCategoriesToCreate as &$poiCategory ) {
			$poiCategory = $this->cleanUpPoiCategoryData( $poiCategory );
			$poiCategory[ 'map_id' ] = $mapId;
			$poiCategory[ 'created_by' ] = $this->getData( 'userName' );
		}
		$this->setData( 'poiCategoriesToCreate', $poiCategoriesToCreate );

		$poiCategoriesToUpdate = $this->request->getArray( 'poiCategoriesToUpdate' );
		foreach ( $poiCategoriesToUpdate as &$poiCategory ) {
			$poiCategory = $this->cleanUpPoiCategoryData( $poiCategory );
		}
		$this->setData( 'poiCategoriesToUpdate', $poiCategoriesToUpdate );

		$poiCategoriesToDelete = $this->request->getArray( 'poiCategoriesToDelete' );
		$this->setData( 'poiCategoriesToDelete', $poiCategoriesToDelete );
	}

	/**
	 * Validates process of creating POI categories
	 *
	 * @throws WikiaMapsPermissionException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	public function validatePoiCategoriesData() {
		$mapId = $this->getData( 'mapId' );
		$poiCategoriesToCreate = $this->getData( 'poiCategoriesToCreate' );
		$poiCategoriesToUpdate = $this->getData( 'poiCategoriesToUpdate' );

		if ( !$this->isUserAllowed() ) {
			throw new WikiaMapsPermissionException();
		}

		if ( !( $mapId > 0 ) ) {
			throw new InvalidParameterApiException( 'mapId' );
		}

		if ( !$this->validatePoiCategories( $poiCategoriesToCreate ) ) {
			throw new InvalidParameterApiException( 'poiCategoriesToCreate' );
		}

		if ( !$this->validatePoiCategories( $poiCategoriesToUpdate ) ) {
			throw new InvalidParameterApiException( 'poiCategoriesToUpdate' );
		}

		if ( !$this->validatePoiCategoriesToDelete() ) {
			throw new InvalidParameterApiException( 'poiCategoriesToDelete' );
		}
	}

	/**
	 * Validates POI categories data
	 *
	 * @param array $poiCategories
	 * @return bool
	 */
	public function validatePoiCategories( $poiCategories ) {
		foreach ( $poiCategories as $poiCategory ) {
			if ( empty( $poiCategory[ 'name' ] ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Validates list of POI categories ids to delete
	 *
	 * @return bool
	 */
	public function validatePoiCategoriesToDelete() {
		$poiCategoriesToDelete = $this->getData( 'poiCategoriesToDelete' );

		if ( !is_array( $poiCategoriesToDelete ) ) {
			$this->setData( 'poiCategoriesToDelete', [] );
			return true;
		}

		foreach ( $poiCategoriesToDelete as $poiCategoryId ) {
			if ( !( $poiCategoryId > 0 ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Sends create POI category requests to service
	 */
	private function createPoiCategories() {
		$poiCategoriesToCreate = $this->getData( 'poiCategoriesToCreate' );
		$poiCategoriesCreated = [];

		foreach ( $poiCategoriesToCreate as $poiCategory ) {
			$response = $this->getModel()->savePoiCategory( $poiCategory );

			if ( true === $response[ 'success' ] ) {
				$poiCategoryId = $response[ 'content' ]->id;

				$this->addLogEntry( WikiaMapsLogger::newLogEntry(
					WikiaMapsLogger::ACTION_CREATE_PIN_TYPE,
					$this->wg->User,
					$this->getData( 'mapId' ),
					$poiCategory[ 'name' ],
					[ '4::poi_category_id' => $poiCategoryId ]
				) );

				$poiCategory[ 'id' ] = $poiCategoryId;
				unset( $poiCategory[ 'created_by' ] );

				$poiCategoriesCreated[] = $poiCategory;
			} else {
				WikiaLogger::instance()->error( 'WikiaMaps tried to create POI category and failed', [
					'poiCategory' => $poiCategory,
					'response' => $response
				] );
			}
		}

		$this->setData( 'poiCategoriesCreated', $poiCategoriesCreated );
	}

	/**
	 * Sends update POI category requests to service
	 */
	private function updatePoiCategories() {
		$poiCategoriesToUpdate = $this->getData( 'poiCategoriesToUpdate' );
		$poiCategoriesUpdated = [];

		foreach ( $poiCategoriesToUpdate as $poiCategory ) {
			$poiCategoryId = $poiCategory[ 'id' ];
			unset( $poiCategory[ 'id' ] ); // API doesn't allow it in request
			$response = $this->getModel()->updatePoiCategory( $poiCategoryId, $poiCategory );

			if ( true === $response[ 'success' ] ) {
				$this->addLogEntry( WikiaMapsLogger::newLogEntry(
					WikiaMapsLogger::ACTION_UPDATE_PIN_TYPE,
					$this->wg->User,
					$this->getData( 'mapId' ),
					$poiCategory[ 'name' ],
					[ '4::poi_category_id' => $poiCategoryId ]
				) );

				$poiCategoriesUpdated[] = $poiCategoryId;
			} else {
				$poiCategory[ 'id' ] = $poiCategoryId;
				WikiaLogger::instance()->error( 'WikiaMaps tried to update POI category and failed', [
					'poiCategory' => $poiCategory,
					'response' => $response
				] );
			}
		}

		$this->setData( 'poiCategoriesUpdated', $poiCategoriesUpdated );
	}

	/**
	 * Sends delete POI category requests to service
	 */
	private function deletePoiCategories() {
		$poiCategoriesToDelete = $this->getData( 'poiCategoriesToDelete' );
		$poiCategoriesDeleted = [];

		foreach ( $poiCategoriesToDelete as $poiCategoryId ) {
			$response = $this->getModel()->deletePoiCategory( $poiCategoryId );

			if ( true === $response[ 'success' ] ) {
				$poiCategoriesDeleted[] = (int) $poiCategoryId;

				$this->addLogEntry( WikiaMapsLogger::newLogEntry(
					WikiaMapsLogger::ACTION_DELETE_PIN_TYPE,
					$this->wg->User,
					$this->getData( 'mapId' ),
					$poiCategoryId,
					[ '4::poi_category_id' => $poiCategoryId ]
				) );
			} else {
				WikiaLogger::instance()->error( 'WikiaMaps tried to delete POI category and failed', [
					'poiCategoryId' => $poiCategoryId,
					'response' => $response
				] );
			}
		}

		$this->setData( 'poiCategoriesDeleted', $poiCategoriesDeleted );
	}

	/**
	 * Formats POI categories save result
	 *
	 * @return array
	 */
	private function getResultsContent() {
		$resultsContent = [];
		$sections = [ 'poiCategoriesCreated', 'poiCategoriesUpdated', 'poiCategoriesDeleted' ];

		foreach ( $sections as $section ) {
			$sectionData = $this->getData( $section );
			if ( !empty( $sectionData ) ) {
				$resultsContent[ $section ] = $sectionData;
			}
		}

		return $resultsContent;
	}

	/**
	 * Adds log entry to class property
	 *
	 * @param $logEntry
	 */
	private function addLogEntry( $logEntry ) {
		$this->logEntries[] = $logEntry;
	}
}
