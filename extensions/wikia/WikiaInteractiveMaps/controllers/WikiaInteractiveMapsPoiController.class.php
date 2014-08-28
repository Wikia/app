<?php
/**
 * Class WikiaInteractiveMapsPoiController
 * AJAX entry points for points of interest (POI) manipulations
 */
class WikiaInteractiveMapsPoiController extends WikiaInteractiveMapsBaseController {

	const ACTION_CREATE = 'create';
	const ACTION_UPDATE = 'update';
	const ACTION_DELETE = 'delete';

	const POI_ARTICLE_IMAGE_THUMB_SIZE = 85;

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
		$this->setData( 'articleTitle', $this->request->getVal( 'link_title' ), '' );
		$this->setData( 'lat', (float) $this->request->getVal( 'lat' ) );
		$this->setData( 'lon', (float) $this->request->getVal( 'lon' ) );
		$this->setData( 'description', $this->request->getVal( 'description' ) );
		$this->setData( 'imageUrl', $this->request->getVal( 'imageUrl' ), '' );

		if ( $poiId > 0 ) {
			$this->setAction( self::ACTION_UPDATE );
			$this->validatePoiData();
			$results = $this->updatePoi();
		} else {
			$this->setAction( self::ACTION_CREATE );
			$this->validatePoiData();
			$results = $this->createPoi();
		}

		if ( true === $results[ 'success' ] ) {
			$results = $this->decorateResults( $results, [ 'link', 'photo' ] );

			WikiaMapsLogger::addLogEntry(
				( $this->isUpdate() ? WikiaMapsLogger::ACTION_UPDATE_PIN : WikiaMapsLogger::ACTION_CREATE_PIN ),
				$mapId,
				$name
			);
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

		$results = $this->getModel()->deletePoi( $this->getData( 'poiId' ) );
		if ( true === $results[ 'success' ] ) {
			WikiaMapsLogger::addLogEntry(
				WikiaMapsLogger::ACTION_DELETE_PIN,
				$mapId,
				$poiId,
				[
					$this->wg->User->getName(),
				]
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
		return $this->getModel()->savePoi( $this->getSanitizedData() );
	}

	/**
	 * Updates an existing point of interest
	 *
	 * @return Array
	 */
	private function updatePoi() {
		return $this->getModel()->updatePoi(
			$this->getData( 'poiId' ),
			$this->getSanitizedData()
		);
	}

	/**
	 * Returns parent/default POI categories recieved from the service
	 */
	public function getParentPoiCategories() {
		$parentPoiCategoriesResponse = $this->getModel()->getParentPoiCategories();
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

		//TODO after merging with MOB-1778 (batch methods for categories) it has to be changed anyway
		$this->setVal( 'results', [
			'success' => true
		] );
	}

	/**
	 * Prepare data from request for processing
	 */
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
				$this->getModel()->getDefaultParentPoiCategory();

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

		if ( !$this->isUserAllowed() ) {
			throw new WikiaInteractiveMapsPermissionException();
		}

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
	}

	/**
	 * Validates POI category data
	 *
	 * @param array $poiCategory
	 * @throws InvalidParameterApiException
	 */
	private function validatePoiCategory( $poiCategory ) {
		$poiCategoryName = trim( $poiCategory[ 'name' ] );

		if ( empty( $poiCategoryName ) ) {
			throw new InvalidParameterApiException( 'poiCategoryNames' );
		}
	}

	/**
	 * Validates list of POI categories ids to delete
	 *
	 * @return bool
	 */
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
		$response = $this->getModel()->savePoiCategory( $poiCategory );

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
		$response = $this->getModel()->updatePoiCategory( $poiCategoryId, $poiCategory );

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
		$poiCategoriesDeleted = $this->getData( 'poiCategoriesDeleted' );

		foreach ( $poiCategoriesDeleted as $poiCategoryId ) {
			$response = $this->getModel()->deletePoiCategory( $poiCategoryId );

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
		if ( ( $this->isCreate() || $this->isUpdate() ) && !$this->isValidEditData() ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}

		if ( ( $this->isCreate() || $this->isUpdate() ) && !$this->isValidArticleTitle() ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-edit-poi-wrong-article-name' )->params( $this->getData( 'articleTitle' ) )->plain() );
		}

		if ( $this->isDelete() && !$this->isValidDeleteData() ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}

		if ( !$this->isUserAllowed() ) {
			throw new WikiaInteractiveMapsPermissionException();
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

		return !( empty( $name ) || empty( $poiCategoryId ) || empty( $mapId ) || empty( $lat ) || empty( $lon ) );
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
	 * Helper method for validation article title - check if article exist
	 *
	 * @return bool
	 */
	public function isValidArticleTitle() {
		$articleTitle = $this->getData( 'articleTitle' );
		$valid = false;

		if ( ( !empty( $articleTitle ) && Title::newFromText( $articleTitle )->exists() ) || empty( $articleTitle ) ) {
			$valid = true;
		}

		return $valid;
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
			'lon' => $this->getData( 'lon' )
		];

		$userName = $this->wg->User->getName();

		if ( $this->isCreate() ) {
			$poiData[ 'map_id' ] = $this->getData( 'mapId' );
			$poiData[ 'created_by' ] = $userName;
		}

		if ( $this->isUpdate() ) {
			$poiData[ 'updated_by' ] = $userName;
		}

		$description = $this->getData( 'description' );
		if ( !empty( $description ) ) {
			$poiData[ 'description' ] = $description;
		}

		$linkTitle = $this->getData( 'articleTitle', '' );
		$photo = $this->getData( 'imageUrl' );
		$link = '';
		$poiData[ 'photo' ] = '';
		if ( !empty( $linkTitle ) ) {
			$link = $this->getArticleUrl( $linkTitle );

			if ( !empty( $photo ) ) {
				// save photo only when article is chosen
				$poiData[ 'photo' ] = $photo;
			}
		}

		$poiData[ 'link_title' ] = $linkTitle;
		$poiData[ 'link' ] = $link;

		return $poiData;
	}

	/**
	 * Returns article suggestions
	 *
	 * @requestParam string $query - search keyword
	 */
	public function getSuggestedArticles() {
		$results = [];
		$query = $this->request->getVal( 'query' );

		if ( empty( $query ) ) {
			$results[ 'responseText' ] = wfMessage( 'wikia-interactive-maps-edit-poi-article-suggest-no-search-term' )->plain();
		} else {
			$results = array_map( 
				function( $item ) {
					$imageUrl = $this->getModel()->getArticleImage(
						$item[ 0 ][ 'title' ],
						self::POI_ARTICLE_IMAGE_THUMB_SIZE,
						self::POI_ARTICLE_IMAGE_THUMB_SIZE
					);

					if ( !empty( $imageUrl ) ) {
						$item[ 0 ][ 'imageUrl' ] = $imageUrl;
					}

					return $item;
				},
				$this->getSuggestions( $query )
			);
		}

		$this->response->setVal( 'results', $results );
	}

	/**
	 * Get article suggestions
	 *
	 * @param string $query - search term
	 *
	 * @return array - list of suggestions
	 */
	private function getSuggestions( $query ) {
		$params = [
			'query' => $query
		];

		return $this->sendRequest( 'SearchSuggestionsApi', 'getList', $params )->getData();
	}

	/**
	 * Helper function, returns article URL
	 *
	 * @param string $title - article title
	 *
	 * @return string - full article URL or empty string if article doesn't exist
	 */
	private function getArticleUrl( $title ) {
		$article = Title::newFromText( $title );
		$link = '';

		if ( !is_null( $article ) ) {
			$link = $article->getFullURL();
		}

		return $link;
	}

	/**
	 * Helper method which adds additional data to API results
	 *
	 * @param Array $results
	 * @param Array $fieldsList
	 *
	 * @return Array results array
	 */
	private function decorateResults( $results, $fieldsList ) {
		$response = $this->getModel()->sendGetRequest( $results[ 'content' ]->url );

		foreach ( $fieldsList as $field ) {
			if ( !empty( $response[ 'content' ]->$field ) ) {
				$results[ 'content' ]->$field = $response[ 'content' ]->$field;
			}
		}

		return $results;
	}
}
