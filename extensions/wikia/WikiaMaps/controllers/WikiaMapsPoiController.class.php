<?php
/**
 * Class WikiaMapsPoiController
 * AJAX entry points for points of interest (POI) manipulations
 */
class WikiaMapsPoiController extends WikiaMapsBaseController {

	const ACTION_CREATE = 'create';
	const ACTION_UPDATE = 'update';
	const ACTION_DELETE = 'delete';

	const POI_ARTICLE_IMAGE_THUMB_SIZE = 85;

	private $currentAction;

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

		// Temporary change required for ad purpose - https://wikia-inc.atlassian.net/browse/DAT-4051.
		// We need to limit contribution options on protected maps related to the ad campaign only to stuff
		// users.
		// TODO: remove this as a part of https://wikia-inc.atlassian.net/browse/DAT-4055
		if ( $this->shouldDisableProtectedMapEdit( $mapId ) ) {
			return;
		}

		$this->setData( 'poiId', $poiId );
		$this->setData( 'mapId', $mapId );
		$this->setData( 'name', $name );
		$this->setData( 'poiCategoryId', $this->request->getInt( 'poi_category_id' ) );
		$this->setData( 'articleTitleOrExternalUrl', $this->request->getVal( 'link_title' ) );
		$this->setData( 'lat', (float) $this->request->getVal( 'lat' ) );
		$this->setData( 'lon', (float) $this->request->getVal( 'lon' ) );
		$this->setData( 'description', $this->request->getVal( 'description' ) );
		$this->setData( 'imageUrl', $this->request->getVal( 'imageUrl' ) );

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
				$this->wg->User,
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
			WikiaMapsLogger::addLogEntry( WikiaMapsLogger::ACTION_DELETE_PIN, $this->wg->User, $mapId, $poiId );
		}
		$this->setVal( 'results', $results );
	}

	/**
	 * Creates a new point of interest
	 *
	 * @return array
	 */
	private function createPoi() {
		return $this->getModel()->savePoi( $this->getSanitizedData() );
	}

	/**
	 * Updates an existing point of interest
	 *
	 * @return array
	 */
	private function updatePoi() {
		return $this->getModel()->updatePoi(
			$this->getData( 'poiId' ),
			$this->getSanitizedData()
		);
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

		if ( ( $this->isCreate() || $this->isUpdate() ) && !$this->isValidArticleTitle() && !$this->isValidUrl( new WikiaValidatorUrl() ) ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-edit-poi-wrong-article-name-or-url' )->params( $this->getData( 'articleTitleOrExternalUrl' ) )->plain() );
		}

		if ( $this->isDelete() && !$this->isValidDeleteData() ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}

		if ( !$this->isUserAllowed() ) {
			throw new WikiaMapsPermissionException();
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
		$articleTitleText = $this->getData( 'articleTitleOrExternalUrl' );
		$articleTitle = Title::newFromText( $articleTitleText );
		$valid = false;

		if ( ( !empty( $articleTitle ) && $articleTitle->exists() ) || empty( $articleTitleText ) ) {
			$valid = true;
		}

		return $valid;
	}

	/**
	 * Helper method for validation external URL
	 *
	 * @param WikiaValidator $validator an instance of WikiaValidator ie. WikiaUrlValidator
	 *
	 * @return bool
	 */
	public function isValidUrl( WikiaValidator $validator ) {
		$externalUrl = $this->getData( 'articleTitleOrExternalUrl' );
		$valid = false;

		if ( ( !empty( $externalUrl ) && $validator->isValid( $externalUrl ) ) || empty( $externalUrl ) ) {
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

		$this->appendLinkIfValidData($poiData);
		$this->appendPhotoIfValidData($poiData);

		return $poiData;
	}

	/**
	 * @brief Adds link, link_title and photo elements to an array if all requirements are met
	 *
	 * @param $poiData
	 */
	public function appendLinkIfValidData( &$poiData ) {
		$linkTitle = $this->getData( 'articleTitleOrExternalUrl', '' );

		// if article title or link was passed in form get an article URL for it
		$link = ( !empty( $linkTitle ) ) ? $this->getArticleUrl( $linkTitle ) : '';
		// if the link created was invalid it might be an external url if not empty
		$link = ( !empty( $linkTitle ) && !$this->isValidArticleTitle() ) ? $linkTitle : $link;
		$link = WikiaSanitizer::prepUrl( $link );

		$poiData[ 'link_title' ] = $linkTitle;
		$poiData[ 'link' ] = $link;
	}

	/**
	 * @brief Sends 'photo' element in an array depending on the fact if internal article has been set
	 *
	 * @param array $poiData an array with POI's data
	 */
	public function appendPhotoIfValidData( &$poiData ) {
		$photo = $this->getData( 'imageUrl' );
		$isValidArticle = $this->isValidArticleTitle();

		// if photo was passed and there is valid internal URL set
		$photo = ( !empty( $photo ) && $isValidArticle ) ? $photo : '';
		$photo = ( !$isValidArticle || empty( $poiData[ 'link' ] ) ) ? '' : $photo;

		$poiData[ 'photo' ] = $photo;
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
	public function getArticleUrl( $title ) {
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
	 * @param array $results
	 * @param array $fieldsList
	 *
	 * @return array results array
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
