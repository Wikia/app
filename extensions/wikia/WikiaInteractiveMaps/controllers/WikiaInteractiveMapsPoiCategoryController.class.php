<?php
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
	 * @requestParam Array $createPoiCategories an array of POI categories to create
	 * @requestParam Array $updatePoiCategories an array of POI categories to update
	 * @requestParam Array $deletePoiCategories an array of POI categories ids to delete
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

		//TODO after merging with MOB-1778 (batch methods for categories) it has to be changed anyway
		$this->setVal( 'results', [
			'success' => true
		] );
	}

	private function cleanUpPoiCategoryData( $poiCategory ) {
		// id
		if ( empty( $poiCategory[ 'id' ] ) ) {
			unset( $poiCategory[ 'id' ] );
		} else {
			$poiCategory[ 'id' ] = (int) $poiCategory[ 'id' ];
		}

		// parent category
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
	 * Prepare data from request for processing
	 */
	private function organizePoiCategoriesData() {
		$mapId = $this->request->getInt( 'mapId' );
		$this->setData( 'mapId', $mapId );

		$createPoiCategories = $this->request->getArray( 'createPoiCategories' );
		foreach ( $createPoiCategories as &$poiCategory ) {
			$poiCategory = $this->cleanUpPoiCategoryData( $poiCategory );
			$poiCategory[ 'map_id' ] = $mapId;
			$poiCategory[ 'created_by' ] = $this->getData( 'userName' );
		}
		$this->setData( 'createPoiCategories', $createPoiCategories );

		$updatePoiCategories = $this->request->getArray( 'updatePoiCategories' );
		foreach ( $updatePoiCategories as &$poiCategory ) {
			$poiCategory = $this->cleanUpPoiCategoryData( $poiCategory );
		}
		$this->setData( 'updatePoiCategories', $updatePoiCategories );

		$deletePoiCategories =  $this->request->getArray( 'deletePoiCategories' );
		$this->setData( 'deletePoiCategories', $deletePoiCategories );
	}

	/**
	 * Validates process of creating POI categories
	 *
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	private function validatePoiCategories() {
		$mapId = $this->getData( 'mapId' );
		$createPoiCategories = $this->getData( 'createPoiCategories' );
		$updatePoiCategories = $this->getData( 'updatePoiCategories' );

		if ( !$this->wg->User->isLoggedIn() ) {
			throw new PermissionsException( WikiaInteractiveMapsController::PAGE_RESTRICTION );
		}

		if ( !( $mapId > 0 ) ) {
			throw new InvalidParameterApiException( 'mapId' );
		}

		foreach ( $createPoiCategories as $poiCategory ) {
			$this->validatePoiCategory( $poiCategory );
		}

		foreach ( $updatePoiCategories as $poiCategory ) {
			$this->validatePoiCategory( $poiCategory );
		}

		if ( !$this->validateDeletePoiCategories() ) {
			throw new InvalidParameterApiException( 'deletePoiCategories' );
		}
	}

	/**
	 * Validates POI category data
	 *
	 * @param array $poiCategory
	 * @throws BadRequestApiException
	 */
	private function validatePoiCategory( $poiCategory ) {
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
	private function validateDeletePoiCategories() {
		$deletePoiCategories = $this->getData( 'deletePoiCategories' );

		if ( !is_array( $deletePoiCategories ) ) {
			$this->setData( 'deletePoiCategories', [] );
			return true;
		}

		foreach ( $deletePoiCategories as $poiCategoryId ) {
			if ( !$poiCategoryId > 0 ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Goes through the list of create/update POI categories and calls responsible methods to save them
	 */
	private function savePoiCategories() {
		$createPoiCategories = $this->getData( 'createPoiCategories' );
		$updatePoiCategories = $this->getData( 'updatePoiCategories' );

		foreach ( $createPoiCategories as $poiCategory ) {
			$this->createPoiCategory( $poiCategory );
		}

		foreach ( $updatePoiCategories as $poiCategory ) {
			$this->updatePoiCategory( $poiCategory );
		}
	}

	/**
	 * Sends create POI category request to service
	 *
	 * @param array $poiCategory
	 */
	private function createPoiCategory( $poiCategory ) {
		$response = $this->mapsModel->savePoiCategory( $poiCategory );

		if ( true === $response[ 'success' ] ) {
			$this->addLogEntry( WikiaMapsLogger::newLogEntry(
				WikiaMapsLogger::ACTION_CREATE_PIN_TYPE,
				$this->getData( 'mapId' ),
				$poiCategory[ 'name' ],
				[ $this->wg->User->getName(), $response->id ]
			) );
		}
	}

	/**
	 * Sends update POI category request to service
	 *
	 * @param array $poiCategory
	 */
	private function updatePoiCategory( $poiCategory ) {
		$poiCategoryId = $poiCategory[ 'id' ];
		unset( $poiCategory[ 'id' ] );
		$response = $this->mapsModel->updatePoiCategory( $poiCategoryId, $poiCategory );

		if ( true === $response[ 'success' ] ) {
			$this->addLogEntry( WikiaMapsLogger::newLogEntry(
				WikiaMapsLogger::ACTION_UPDATE_PIN_TYPE,
				$this->getData( 'mapId' ),
				$poiCategory[ 'name' ],
				[ $this->wg->User->getName(), $poiCategoryId ]
			) );
		}
	}

	/**
	 * Adds log entry to class property
	 *
	 * @param $logEntry
	 */
	private function addLogEntry( $logEntry ) {
		$this->logEntries[] = $logEntry;
	}

	/**
	 * Sends delete POI category requests to service
	 */
	private function deletePoiCategories() {
		$deletePoiCategories = $this->getData( 'deletePoiCategories' );

		foreach ( $deletePoiCategories as $poiCategoryId ) {
			$response = $this->mapsModel->deletePoiCategory( $poiCategoryId );

			if ( true === $response[ 'success' ] ) {
				$this->addLogEntry( WikiaMapsLogger::newLogEntry(
					WikiaMapsLogger::ACTION_DELETE_PIN_TYPE,
					$this->getData( 'mapId' ),
					$poiCategoryId,
					[ $this->wg->User->getName(), $poiCategoryId ]
				) );
			}
		}
	}
}
