<?php
/**
 * Class WikiaInteractiveMapsPoiController
 * AJAX entry points for points of interest (POI) manipulations
 */
class WikiaInteractiveMapsPoiController extends WikiaInteractiveMapsBaseController {

	const ACTION_CREATE = 'create';
	const ACTION_UPDATE = 'update';

	private $currentAction;

	/**
	 * Entry point to create/edit point of interest
	 *
	 * @requestParam Integer $poiId an unique POI id if not set then we're creating a new POI
	 * @requestParam Integer $mapId an unique map id
	 * @requestParam String $name an array of pin types names
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
		$poiId = $this->request->getInt( 'poiId' );
		$this->setData( 'poiId', $poiId );
		$this->setData( 'mapId', $this->request->getInt( 'mapId' ) );
		$this->setData( 'name', $this->request->getVal( 'name' ) );
		$this->setData( 'poiCategoryId', $this->request->getInt( 'poi_category_id' ) );
		$this->setData( 'articleLink', $this->request->getVal( 'link' ) );
		$this->setData( 'lat', (float) $this->request->getVal( 'lat' ) );
		$this->setData( 'lon', (float) $this->request->getVal( 'lon' ) );
		$this->setData( 'description', $this->request->getVal( 'description' ) );
		$this->setData( 'imageUrl', $this->request->getVal( 'photo' ) );

		$this->validatePoiData();

		if( $poiId > 0 ) {
			$results = $this->updatePoi();
		} else {
			$results = $this->createPoi();
		}

		$this->setVal( 'results', $results );
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
		];

		if( isset( $availableActions[ $action ] ) ) {
			$this->currentAction = $action;
		} else {
			throw new Exception( sprintf( 'Invalid action (%s)', $action ) );
		}
	}

	private function getAction() {
		return $this->currentAction;
	}

	private function isUpdate() {
		return ( $this->getAction() === self::ACTION_UPDATE );
	}

	private function isCreate() {
		return ( $this->getAction() === self::ACTION_CREATE );
	}

	/**
	 * Validates data needed for creating/updating POI
	 */
	private function validatePoiData() {
		$name = $this->getData( 'name' );
		$poiCategoryId = $this->getData( 'poiCategoryId' );
		$mapId = $this->getData( 'mapId' );
		$lat = $this->getData( 'lat' );
		$lon = $this->getData( 'lon' );

		if( empty( $name )
			|| empty( $poiCategoryId )
			|| empty( $mapId )
			|| empty( $lat )
			|| empty( $lon )
			|| empty( $name )
		) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}

		if( !$this->wg->User->isLoggedIn() ) {
			throw new PermissionsException( 'interactive maps' );
		}
	}

	private function updatePoi() {
		$this->setAction( self::ACTION_UPDATE );

		$response = $this->mapsModel->updatePoi(
			$this->getData( 'poiId' ),
			$this->getSanitizedData()
		);

		if( !$response['success'] && is_null( $response['content'] ) ) {
			$response['content'] = new stdClass();
			$response['content']->message = wfMessage( 'wikia-interactive-maps-service-error' )->parse();
		}

		return $response;
	}

	/**
	 * Creates a new point of interest
	 *
	 * @return bool|string
	 */
	private function createPoi() {
		$this->setAction( self::ACTION_CREATE );

		$response = $this->mapsModel->savePoi( $this->getSanitizedData() );
		if( !$response['success'] && is_null( $response['content'] ) ) {
			$response['content'] = new stdClass();
			$response['content']->message = wfMessage( 'wikia-interactive-maps-service-error' )->parse();
		}

		return $response;
	}

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
