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
		$this->setData( 'lat', $this->request->getVal( 'lat' ) );
		$this->setData( 'lon', $this->request->getVal( 'lon' ) );
		$this->setData( 'description', $this->request->getVal( 'description' ) );

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

	private function createPoi() {
		// TODO: finish me!

		$results['success'] = false;

		return $results;
	}

}
