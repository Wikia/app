<?php
/**
 * Class WikiaMapsMapController
 * AJAX entry points for actions connected to map creation
 */
class WikiaMapsMapController extends WikiaMapsBaseController {

	/**
	 * Gets list of tile sets
	 *
	 * @return Array
	 */
	public function getTileSets() {
		$params = [];
		$searchTerm = $this->request->getVal( 'searchTerm', null );

		if ( !is_null( $searchTerm ) ) {
			$params[ 'search' ] = $searchTerm;
		}

		$this->response->setVal( 'results', $this->mapsModel->getTileSets( $params ) );
	}

	/**
	 * Entry point to create a map from either existing tiles or new image
	 *
	 * @requestParam Integer $tileSetId an unique id of existing tiles
	 * @requestParam String $image an URL to image which the tiles will be created from
	 * @requestParam String $title map title
	 *
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	public function createMap() {
		$type = trim( $this->request->getVal( 'type', WikiaMaps::MAP_TYPE_GEO ) );

		$this->setData( 'tileSetId', $this->request->getInt( 'tileSetId', 0 ) );
		$this->setData( 'title', trim( $this->request->getVal( 'map-title', '' ) ) );
		$this->setData( 'tileSetTitle', trim( $this->request->getVal( 'tile-set-title', '' ) ) );
		$this->setData( 'image', trim( $this->request->getVal( 'fileUrl', '' ) ) );

		$this->validateMapCreation();

		$this->setData( 'creatorName', $this->wg->User->getName() );
		$this->setData( 'cityId', (int) $this->wg->CityId );

		if ( $type === WikiaMaps::MAP_TYPE_CUSTOM ) {
			$results = $this->createCustomMap();
		} else {
			$results = $this->createGeoMap();
		}

		$this->setVal( 'results', $results );
	}

	/**
	 * Creates a custom map for given tileset or creating a tileset and then map out of it
	 *
	 * @return Array
	 */
	private function createCustomMap() {
		$tileSetId = $this->getData( 'tileSetId' );

		if ( $tileSetId > 0 ) {
			$results = $this->createMapFromTilesetId();
		} else {
			$results = $this->createTileset();

			if ( true === $results[ 'success' ] ) {
				$this->setData( 'tileSetId', $results[ 'content' ]->id );
				$results = $this->createMapFromTilesetId();
			} elseif ( isset( $results['content']->code ) 
				&&  $results['content']->code === WikiaMaps::DB_DUPLICATE_ENTRY ) {
				$results['content']->message = wfMessage( 'wikia-interactive-maps-tile-set-exists-error' )->text();
			}
		}

		return $results;
	}

	/**
	 * Creates a map from Geo tileset
	 *
	 * @return Array
	 */
	private function createGeoMap() {
		$this->setData( 'tileSetId', $this->mapsModel->getGeoMapTilesetId() );
		return $this->createMapFromTilesetId();
	}

	/**
	 * Helper method to validate creation data
	 *
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	private function validateMapCreation() {
		$tileSetId = $this->getData( 'tileSetId' );
		$imageUrl = $this->getData( 'image' );
		$mapTitle = $this->getData( 'title' );

		if ( $tileSetId === 0 && empty( $imageUrl ) && empty( $mapTitle ) ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}

		if ( empty( $mapTitle ) ) {
			throw new InvalidParameterApiException( 'title' );
		}

		if ( !$this->isUserAllowed() ) {
			throw new WikiaMapsPermissionException();
		}
	}

	/**
	 * Helper method which sends request to maps service to create tiles' set
	 * and then processes the response providing results array
	 */
	private function createTileset() {
		return $this->mapsModel->saveTileset( [
			'name' => $this->getData( 'tileSetTitle' ),
			'url' => $this->getData( 'image' ),
			'created_by' => $this->getData( 'creatorName' ),
		] );
	}

	/**
	 * Helper method which sends request to maps service to create a map from existing tiles' set
	 * and processes the response providing results array
	 *
	 * @return Array
	 */
	private function createMapFromTilesetId() {
		$cityId = $this->getData( 'cityId' );
		$wiki = WikiFactory::getWikiByID( $cityId );
		$response = $this->mapsModel->saveMap( [
			'title' => $this->getData( 'title' ),
			'tile_set_id' => $this->getData( 'tileSetId' ),
			'city_id' => $cityId,
			'city_title' => $wiki->city_title,
			'city_url' => $wiki->city_url,
			'created_by' => $this->getData( 'creatorName' ),
		] );

		if ( true === $response[ 'success' ] ) {
			$mapId = $response['content']->id;

			$response[ 'content' ]->mapUrl = Title::newFromText(
				WikiaMapsSpecialController::PAGE_NAME . '/' . $mapId,
				NS_SPECIAL
			)->getFullUrl();

			// Log new map created
			WikiaMapsLogger::addLogEntry(
				WikiaMapsLogger::ACTION_CREATE_MAP,
				$mapId,
				$this->getData( 'title' ),
				[
					$this->wg->User->getName(),
				]
			);
		}

		return $response;
	}

	/**
	 * Ajax method for un/deleting a map from IntMaps API
	 */
	public function updateMapDeletionStatus() {
		$mapId = $this->request->getInt( 'mapId' );
		$deleted = $this->request->getInt( 'deleted' );

		if ( !in_array( $deleted, [ WikiaMaps::MAP_DELETED, WikiaMaps::MAP_NOT_DELETED ] ) ) {
			$deleted = WikiaMaps::MAP_DELETED;
		}

		$result = false;

		if ( !$this->isUserAllowed() ) {
			throw new WikiaMapsPermissionException();
		}

		if ( $mapId ) {
			$result = $this->getModel()->updateMapDeletionStatus( $mapId, $deleted )[ 'success' ];
		}

		if ( $result ) {
			$action = $deleted === WikiaMaps::MAP_DELETED
				? WikiaMapsLogger::ACTION_DELETE_MAP
				: WikiaMapsLogger::ACTION_UNDELETE_MAP;

			WikiaMapsLogger::addLogEntry(
				$action,
				$mapId,
				$mapId,
				[
					$this->wg->User->getName(),
				]
			);

			NotificationsController::addConfirmation(
				$deleted ?
					wfMessage( 'wikia-interactive-maps-delete-map-success' )->text() :
					wfMessage( 'wikia-interactive-maps-undelete-map-success' )->text()
			);

			$redirectUrl = WikiaMapsSpecialController::getSpecialUrl();

			if ( $deleted === WikiaMaps::MAP_NOT_DELETED ) {
				$redirectUrl .= '/' . $mapId;
			}

			$this->response->setVal( 'redirectUrl', $redirectUrl );
		}
	}

}
