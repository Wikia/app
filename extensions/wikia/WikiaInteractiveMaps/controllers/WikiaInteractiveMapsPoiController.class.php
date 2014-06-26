<?php
/**
 * Class WikiaInteractiveMapsPoiController
 * AJAX entry points for points of interest (POI) manipulations
 */
class WikiaInteractiveMapsPoiController extends WikiaInteractiveMapsBaseController {

	const ACTION_CREATE = 'create';
	const ACTION_UPDATE = 'update';
	const ACTION_DELETE = 'delete';

	private $currentAction;
	private $logEntries = [];

	/**
	 * Entry point to create/edit point of interest
	 *
	 * @requestParam Integer $id an unique POI id if not set then we're creating a new POI
	 * @requestParam Integer $mapId an unique map id
	 * @requestParam String $name an array of POI categories names
	 * @requestParam String $poi_category_id an unique poi category id
	 * @requestParam String $link a link to wikia article
	 * @requestParam Float $lat
	 * @requestParam Float $lon
	 * @requestParam String $description a POI description
	 * @requestParam String $photo an image URL
	 *
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 */
	public function editPoi() {
		$poiId = $this->request->getInt( 'id' );
		$mapId = $this->request->getInt( 'mapId' );
		$name = $this->request->getVal( 'name' );
		$this->setData( 'poiId', $poiId );
		$this->setData( 'mapId', $mapId );
		$this->setData( 'name', $name );
		$this->setData( 'poiCategoryId', $this->request->getInt( 'poi_category_id' ) );
		$this->setData( 'articleLink', $this->request->getVal( 'link' ) );
		$this->setData( 'lat', (float) $this->request->getVal( 'lat' ) );
		$this->setData( 'lon', (float) $this->request->getVal( 'lon' ) );
		$this->setData( 'description', $this->request->getVal( 'description' ) );
		$this->setData( 'imageUrl', $this->request->getVal( 'photo' ) );

		$this->validatePoiData();

		if( $poiId > 0 ) {
			$results = $this->updatePoi();
			if ( true === $results[ 'success' ] ) {
				WikiaMapsLogger::addLogEntry(
					WikiaMapsLogger::ACTION_UPDATE_PIN,
					$mapId,
					$name
				);
			}
		} else {
			$results = $this->createPoi();
			if ( true === $results[ 'success' ] ) {
				WikiaMapsLogger::addLogEntry(
					WikiaMapsLogger::ACTION_CREATE_PIN,
					$mapId,
					$name
				);
			}
		}

		$this->setVal( 'results', $results );
	}

	/**
	 * Entry point to delete a poi
	 *
	 * @requestParam Integer id an unique POI id
	 *
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 */
	public function deletePoi() {
		$this->setAction( self::ACTION_DELETE );
		$poiId = $this->request->getInt( 'id' );
		$mapId = $this->request->getInt( 'mapId' );
		$this->setData( 'poiId', $poiId );

		$this->validatePoiData();

		$results = $this->mapsModel->deletePoi( $this->getData( 'poiId' ) );
		if ( true === $results[ 'success' ] ) {
			WikiaMapsLogger::addLogEntry(
				WikiaMapsLogger::ACTION_DELETE_PIN,
				$mapId,
				$poiId
			);
		}
		$this->setVal( 'results', $results );
	}

	/**
	 * Creates a new point of interest
	 *
	 * @return Array
	 */
	private function createPoi() {
		$this->setAction( self::ACTION_CREATE );
		return $this->mapsModel->savePoi( $this->getSanitizedData() );
	}

	/**
	 * Updates an existing point of interest
	 *
	 * @return Array
	 */
	private function updatePoi() {
		$this->setAction( self::ACTION_UPDATE );

		return $this->mapsModel->updatePoi(
			$this->getData( 'poiId' ),
			$this->getSanitizedData()
		);
	}

	/**
	 * Returns parent/default POI categories recieved from the service
	 */
	public function getParentPoiCategories() {
		$parentPoiCategoriesResponse = $this->mapsModel->cachedRequest( 'getParentPoiCategories', [] );
		$this->setVal( 'results', $parentPoiCategoriesResponse );
	}

	/**
	 * Entry point to save POI categories
	 *
	 * @requestParam Integer $mapId an unique map id
	 * @requestParam String $poiCategoriesDeleted string with comma joined ids of POI categories to delete
	 * @requestParam Array $poiCategoryIds an array of POI categories ids
	 * @requestParam Array $poiCategoryNames an array of POI categories names
	 * @requestParam Array $poiCategoryParents an array of POI categories parents ids
	 * @requestParam Array $poiCategoryMarkers an array of POI categories markers URLs
	 *
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 */
	public function editPoiCategories() {
		$this->setData( 'userName', $this->wg->User->getName() );

		$poiCategoriesDeleted = explode(',', $this->request->getVal( 'poiCategoriesDeleted' ));
		$this->setData( 'poiCategoriesDeleted', $poiCategoriesDeleted );

		$this->organizePoiCategoriesData();
		$this->validatePoiCategories();
		$this->savePoiCategories();
		$this->deletePoiCategories();

		WikiaMapsLogger::addLogEntries($this->logEntries);
		$this->logEntries = [];

		//TODO ?
		$this->setVal( 'results', [
			'success' => true
		] );
	}

	private function organizePoiCategoriesData() {
		$mapId = $this->request->getInt( 'mapId' );
		$this->setData( 'mapId', $mapId );

		$poiCategoriesDeleted = preg_split('@,@', $this->request->getVal( 'poiCategoriesDeleted' ), null, PREG_SPLIT_NO_EMPTY);
		$this->setData( 'poiCategoriesDeleted', $poiCategoriesDeleted );

		$poiCategoryIds = $this->request->getArray( 'poiCategoryIds' );
		$poiCategoryNames = $this->request->getArray( 'poiCategoryNames' );
		$poiCategoryParents = $this->request->getArray( 'poiCategoryParents' );
		$poiCategoryMarkers = $this->request->getArray( 'poiCategoryMarkers' );

		$numberOfPoiCategories = count( $poiCategoryNames ); // names are required, so we can rely on them

		$createPoiCategories = [];
		$updatePoiCategories = [];
		for ( $i = 0; $i < $numberOfPoiCategories; $i++ ) {
			$poiCategoryData = [
				'name' => $poiCategoryNames[ $i ]
			];

			// parent category
			$poiCategoryData[ 'parent_poi_category_id' ] = ( !empty( $poiCategoryParents[ $i ] ) ) ?
				(int) $poiCategoryParents[ $i ] :
				$this->mapsModel->getDefaultParentPoiCategory();

			// if user didn't upload marker then this is empty string. we don't want to send it to api.
			if ( !empty( $poiCategoryMarkers[ $i ] ) ) {
				$poiCategoryData[ 'marker' ] = $poiCategoryMarkers[ $i ];
			}

			// update or create
			if ( $poiCategoryIds[ $i ] > 0 ) {
				$poiCategoryData[ 'id' ] = $poiCategoryIds[ $i ];

				$updatePoiCategories []= $poiCategoryData;
			} else {
				$poiCategoryData[ 'map_id' ] = $mapId;
				$poiCategoryData[ 'created_by' ] = $this->getData( 'userName' );

				$createPoiCategories []= $poiCategoryData;
			}
		}

		$this->setData( 'createPoiCategories', $createPoiCategories );
		$this->setData( 'updatePoiCategories', $updatePoiCategories );
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

		if ( $mapId === 0 && empty( $poiCategoryNames ) ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}

		if ( $mapId === 0 ) {
			throw new InvalidParameterApiException( 'mapId' );
		}

		foreach ( $createPoiCategories as $poiCategory ) {
			$this->validatePoiCategory( $poiCategory );
		}

		foreach ( $updatePoiCategories as $poiCategory ) {
			$this->validatePoiCategory( $poiCategory );
		}

		if ( !$this->validatePoiCategoriesDeleted() ) {
			throw new InvalidParameterApiException( 'poiCategoriesDeleted' );
		}

		if ( !$this->wg->User->isLoggedIn() ) {
			throw new PermissionsException( 'interactive maps' );
		}
	}

	private function validatePoiCategory( $poiCategory ) {
		$poiCategoryName = trim( $poiCategory[ 'name' ] );

		if ( empty( $poiCategoryName ) ) {
			throw new InvalidParameterApiException( 'poiCategoryNames' );
		}
	}

	private function validatePoiCategoriesDeleted() {
		$poiCategoriesDeleted = $this->getData( 'poiCategoriesDeleted' );

		if ( !is_array( $poiCategoriesDeleted ) ) {
			$this->setData( 'poiCategoriesDeleted', [] );
			return true;
		}

		foreach ($poiCategoriesDeleted as $poiCategoryId) {
			if ( !$poiCategoryId > 0 ) {
				return false;
			}
		}

		return true;
	}

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

	private function createPoiCategory( $poiCategory ) {
		$response = $this->mapsModel->savePoiCategory( $poiCategory );

		if ( true === $response[ 'success' ] ) {
			$this->addLogEntry( WikiaMapsLogger::newLogEntry(
				WikiaMapsLogger::ACTION_CREATE_PIN_TYPE,
				$this->getData( 'mapId' ),
				$poiCategory[ 'name' ],
				[ $response->id ]
			) );
		}
	}

	private function updatePoiCategory( $poiCategory ) {
		$poiCategoryId = $poiCategory[ 'id' ];
		unset( $poiCategory[ 'id' ] );
		$response = $this->mapsModel->updatePoiCategory( $poiCategoryId, $poiCategory );

		if ( true === $response[ 'success' ] ) {
			$this->addLogEntry( WikiaMapsLogger::newLogEntry(
				WikiaMapsLogger::ACTION_UPDATE_PIN_TYPE,
				$this->getData( 'mapId' ),
				$poiCategory[ 'name' ],
				[ $poiCategoryId ]
			) );
		}
	}

	private function addLogEntry( $logEntry ) {
		$this->logEntries []= $logEntry;
	}

	private function deletePoiCategories() {
		$poiCategoriesDeleted = $this->getData( 'poiCategoriesDeleted' );

		foreach ( $poiCategoriesDeleted as $poiCategoryId ) {
			$this->mapsModel->deletePoiCategory( $poiCategoryId );
		}
	}

	/**
	 * Sets current action being executed on POI
	 *
	 * @param String $action
	 * @throws Exception
	 */
	private function setAction( $action ) {
		$availableActions = [
			self::ACTION_CREATE => true,
			self::ACTION_UPDATE => true,
			self::ACTION_DELETE => true,
		];

		if( isset( $availableActions[ $action ] ) ) {
			$this->currentAction = $action;
		} else {
			throw new Exception( sprintf( 'Invalid action (%s)', $action ) );
		}
	}

	/**
	 * Getter returns current action
	 *
	 * @return String
	 */
	private function getAction() {
		return $this->currentAction;
	}

	/**
	 * Helper method returns true if current action is an update
	 *
	 * @return bool
	 */
	private function isUpdate() {
		return ( $this->getAction() === self::ACTION_UPDATE );
	}

	/**
	 * Helper method returns true if current action is a create
	 *
	 * @return bool
	 */
	private function isCreate() {
		return ( $this->getAction() === self::ACTION_CREATE );
	}

	/**
	 * Helper method returns true if current action is a delete
	 *
	 * @return bool
	 */
	private function isDelete() {
		return ( $this->getAction() === self::ACTION_DELETE );
	}

	/**
	 * Validates data needed for creating/updating POI
	 */
	private function validatePoiData() {
		if( ( $this->isCreate() || $this->isUpdate() ) && !$this->isValidEditData() ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}

		if( $this->isDelete() && !$this->isValidDeleteData() ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}

		if( !$this->wg->User->isLoggedIn() ) {
			throw new PermissionsException( 'interactive maps' );
		}
	}

	/**
	 * Helper methods returns true if data is valid for create or update
	 *
	 * @return bool
	 */
	private function isValidEditData() {
		$name = $this->getData( 'name' );
		$poiCategoryId = $this->getData( 'poiCategoryId' );
		$mapId = $this->getData( 'mapId' );
		$lat = $this->getData( 'lat' );
		$lon = $this->getData( 'lon' );

		return ( empty( $name ) || empty( $poiCategoryId ) || empty( $mapId ) || empty( $lat ) || empty( $lon ) );
	}

	/**
	 * Helper methods returns true if data is valid for delete
	 *
	 * @return bool
	 */
	private function isValidDeleteData() {
		$poiId = $this->getData( 'poiId' );
		return $poiId > 0;
	}

	/**
	 * Depending on a current action prepares proper data for POST requests (create, edit)
	 *
	 * @return array
	 */
	private function getSanitizedData() {
		$poiData = [
			'name' => $this->getData( 'name' ),
			'poi_category_id' => $this->getData( 'poiCategoryId' ),
			'lat' => $this->getData( 'lat' ),
			'lon' => $this->getData( 'lon' ),
		];

		$userName = $this->wg->User->getName();

		if( $this->isCreate() ) {
			$poiData['map_id'] = $this->getData( 'mapId' );
			$poiData['created_by'] = $userName;
		}

		if( $this->isUpdate() ) {
			$poiData['updated_by'] = $userName;
		}

		$description = $this->getData( 'description' );
		if( !empty( $description ) ) {
			$poiData['description'] = $description;
		}

		$link = $this->getData( 'articleLink' );
		if( !empty( $link ) ) {
			$poiData['link'] = $link;
		}

		$photo = $this->getData( 'imageUrl' );
		if( !empty( $photo ) ) {
			$poiData['photo'] = $photo;
		}

		return $poiData;
	}
}
