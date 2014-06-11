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
		$this->setData( 'mapId', $this->request->getArray( 'mapId' ) );
		$this->setData( 'name', $this->request->getArray( 'name' ) );
		$this->setData( 'poiCategoryId', $this->request->getArray( 'poiCategoryId' ) );
		$this->setData( 'articleLink', $this->request->getArray( 'articleLink' ) );
		$this->setData( 'lat', $this->request->getArray( 'lat' ) );
		$this->setData( 'lon', $this->request->getArray( 'lon' ) );
		$this->setData( 'description', $this->request->getArray( 'description' ) );

		$this->validatePoiData();

		$this->setData( 'createdBy', $this->wg->User->getName() );

		if( $poiId > 0 ) {
			$results = $this->updatePoi();
		} else {
			$results = $this->createPoi();
		}

		$this->setVal( 'results', $results );
	}

	private function validatePoiData() {
		// TODO: finish me!
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
