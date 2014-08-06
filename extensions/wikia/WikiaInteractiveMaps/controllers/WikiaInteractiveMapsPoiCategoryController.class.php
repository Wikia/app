<?php

use Wikia\Logger\WikiaLogger;

/**
 * Class WikiaInteractiveMapsPoiCategoryController
 * AJAX entry points for points of interest's categories (POI category) manipulations
 */
class WikiaInteractiveMapsPoiCategoryController extends WikiaInteractiveMapsBaseController {
	private $logEntries = [];

	/**
	 * Returns parent/default POI categories recieved from the service
	 */
	public function getParentPoiCategories() {
		$parentPoiCategoriesResponse = $this->mapsModel->getParentPoiCategories();
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
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 */
	public function editPoiCategories() {
		$this->setData( 'userName', $this->wg->User->getName() );

		$this->organizePoiCategoriesData();
		$this->validatePoiCategories();
		$this->savePoiCategories();
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

		$poiCategory[ 'parent_poi_category_id' ] = ( !empty( $poiCategory[ 'parent_poi_category_id' ] ) ) ?
			(int) $poiCategory[ 'parent_poi_category_id' ] :
			$this->mapsModel->getDefaultParentPoiCategory();

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
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	public function validatePoiCategories() {
		$mapId = $this->getData( 'mapId' );
		$poiCategoriesToCreate = $this->getData( 'poiCategoriesToCreate' );
		$poiCategoriesToUpdate = $this->getData( 'poiCategoriesToUpdate' );

		if ( !$this->wg->User->isLoggedIn() ) {
			throw new PermissionsException( WikiaInteractiveMapsController::PAGE_RESTRICTION );
		}

		if ( !( $mapId > 0 ) ) {
			throw new InvalidParameterApiException( 'mapId' );
		}

		foreach ( $poiCategoriesToCreate as $poiCategory ) {
			$this->validatePoiCategory( $poiCategory );
		}

		foreach ( $poiCategoriesToUpdate as $poiCategory ) {
			$this->validatePoiCategory( $poiCategory );
		}

		if ( !$this->validatePoiCategoriesToDelete() ) {
			throw new InvalidParameterApiException( 'poiCategoriesToDelete' );
		}
	}

	/**
	 * Validates POI category data
	 *
	 * @param array $poiCategory
	 * @throws BadRequestApiException
	 */
	public function validatePoiCategory( $poiCategory ) {
		$poiCategoryName = trim( $poiCategory[ 'name' ] );

		if ( empty( $poiCategoryName ) ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}
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
	 * Goes through the list of create/update POI categories and calls responsible methods to save them
	 */
	private function savePoiCategories() {
		$poiCategoriesToCreate = $this->getData( 'poiCategoriesToCreate' );
		$poiCategoriesToUpdate = $this->getData( 'poiCategoriesToUpdate' );

		$poiCategoriesCreated = [];
		$poiCategoriesUpdated = [];

		foreach ( $poiCategoriesToCreate as $poiCategory ) {
			$poiCategoryCreated = $this->createPoiCategory( $poiCategory );

			if ( !empty( $poiCategoryCreated ) ) {
				$poiCategoriesCreated[] = $poiCategoryCreated;
			}
		}

		foreach ( $poiCategoriesToUpdate as $poiCategory ) {
			$poiCategoryUpdated = $this->updatePoiCategory( $poiCategory );

			if ( !empty( $poiCategoryUpdated ) ) {
				$poiCategoriesUpdated[] = $poiCategoryUpdated;
			}
		}

		$this->setData( 'poiCategoriesCreated', $poiCategoriesCreated );
		$this->setData( 'poiCategoriesUpdated', $poiCategoriesUpdated );
	}

	/**
	 * Sends create POI category request to service
	 *
	 * @param array $poiCategory
	 * @return int - created POI category's id
	 */
	private function createPoiCategory( $poiCategory ) {
		$response = $this->mapsModel->savePoiCategory( $poiCategory );

		if ( true === $response[ 'success' ] ) {
			$poiCategoryId = $response[ 'content' ]->id;

			$this->addLogEntry( WikiaMapsLogger::newLogEntry(
				WikiaMapsLogger::ACTION_CREATE_PIN_TYPE,
				$this->getData( 'mapId' ),
				$poiCategory[ 'name' ],
				[ $this->wg->User->getName(), $poiCategoryId ]
			) );

			$poiCategory[ 'id' ] = $poiCategoryId;
			unset( $poiCategory[ 'created_by' ] );

			return $poiCategory;
		} else {
			WikiaLogger::instance()->error( 'WikiaMaps tried to create POI category and failed', [
				'poiCategory' => $poiCategory,
				'response' => $response
			] );
			return null;
		}
	}

	/**
	 * Sends update POI category request to service
	 *
	 * @param array $poiCategory
	 * @return int - updated POI category's id
	 */
	private function updatePoiCategory( $poiCategory ) {
		$poiCategoryId = $poiCategory[ 'id' ];
		unset( $poiCategory[ 'id' ] ); // API doesn't allow it in request
		$response = $this->mapsModel->updatePoiCategory( $poiCategoryId, $poiCategory );

		if ( true === $response[ 'success' ] ) {
			$this->addLogEntry( WikiaMapsLogger::newLogEntry(
				WikiaMapsLogger::ACTION_UPDATE_PIN_TYPE,
				$this->getData( 'mapId' ),
				$poiCategory[ 'name' ],
				[ $this->wg->User->getName(), $poiCategoryId ]
			) );

			return $poiCategoryId;
		} else {
			WikiaLogger::instance()->error( 'WikiaMaps tried to update POI category and failed', [
				'poiCategory' => $poiCategory,
				'response' => $response
			] );
			return null;
		}
	}

	/**
	 * Sends delete POI category requests to service
	 */
	private function deletePoiCategories() {
		$poiCategoriesToDelete = $this->getData( 'poiCategoriesToDelete' );
		$poiCategoriesDeleted = [];

		foreach ( $poiCategoriesToDelete as $poiCategoryId ) {
			$response = $this->mapsModel->deletePoiCategory( $poiCategoryId );

			if ( true === $response[ 'success' ] ) {
				$poiCategoriesDeleted[] = (int) $poiCategoryId;

				$this->addLogEntry( WikiaMapsLogger::newLogEntry(
					WikiaMapsLogger::ACTION_DELETE_PIN_TYPE,
					$this->getData( 'mapId' ),
					$poiCategoryId,
					[ $this->wg->User->getName(), $poiCategoryId ]
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

		$poiCategoriesCreated = $this->getData( 'poiCategoriesCreated' );
		if ( !empty( $poiCategoriesCreated ) ) {
			$resultsContent[ 'poiCategoriesCreated' ] = $poiCategoriesCreated;
		}

		$poiCategoriesUpdated = $this->getData( 'poiCategoriesUpdated' );
		if ( !empty( $poiCategoriesUpdated ) ) {
			$resultsContent[ 'poiCategoriesUpdated' ] = $poiCategoriesUpdated;
		}

		$poiCategoriesDeleted = $this->getData( 'poiCategoriesDeleted' );
		if ( !empty( $poiCategoriesDeleted ) ) {
			$resultsContent[ 'poiCategoriesDeleted' ] = $poiCategoriesDeleted;
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
