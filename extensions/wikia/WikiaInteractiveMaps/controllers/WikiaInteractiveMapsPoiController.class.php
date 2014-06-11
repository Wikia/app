<?php
/**
 * Class WikiaInteractiveMapsPoiController
 * AJAX entry points for points of interest (POI) manipulations
 */
class WikiaInteractiveMapsPoiController extends WikiaInteractiveMapsBaseController {

	/**
	 * Entry point to create/edit point of interest
	 *
	 * @requestParam Integer $poiId an unique POI id if not set then we're creating a new POI
	 * @requestParam Integer $mapId an unique map id
	 * @requestParam String $name an array of pin types names
	 * @requestParam String $poiCategoryId an unique poi category id
	 * @requestParam String $articleLink a link to wikia article
	 * @requestParam Float $lat
	 * @requestParam Float $lon
	 * @requestParam String $description a POI description
	 * @requestParam String $imageUrl an image URL
	 *
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 */
	public function editPoi() {
		$poiId = $this->request->getInt( 'poiId' );
		$this->setData( 'poiId', $poiId );
		$this->setData( 'mapId', $this->request->getInt( 'mapId' ) );
		$this->setData( 'name', $this->request->getVal( 'name' ) );
		$this->setData( 'poiCategoryId', $this->request->getInt( 'poiCategoryId' ) );
		$this->setData( 'articleLink', $this->request->getVal( 'articleLink' ) );
		$this->setData( 'lat', (float) $this->request->getVal( 'lat' ) );
		$this->setData( 'lon', (float) $this->request->getVal( 'lon' ) );
		$this->setData( 'description', $this->request->getVal( 'description' ) );
		$this->setData( 'imageUrl', $this->request->getVal( 'imageUrl' ) );

		$this->validatePoiData();

		$this->setData( 'createdBy', $this->wg->User->getName() );

		if( $poiId > 0 ) {
			$results = $this->updatePoi();
		} else {
			$results = $this->createPoi();
		}

		$this->setVal( 'results', $results );
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
		// TODO: finish me!

		$results['success'] = false;

		return $results;
	}

	/**
	 * Creates a new point of interest
	 *
	 * @return bool|string
	 */
	private function createPoi() {
		$results['success'] = false;

		$poiData = [
			'name' => $this->getData( 'name' ),
			'poi_category_id' => $this->getData( 'poiCategoryId' ),
			'map_id' => $this->getData( 'mapId' ),
			'lat' => $this->getData( 'lat' ),
			'lon' => $this->getData( 'lon' ),
			'created_by' => $this->getData( 'createdBy' )
		];

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

		$response = json_decode( $this->mapsModel->savePoi( $poiData ) );
		if( $response->id ) {
			$results['success'] = true;
			$results['content'] = $response;
		}

		return $results;
	}

}
