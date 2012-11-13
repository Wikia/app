<?php
	/**
	 * Controller to get Wiki Navigation for a wiki
	 *
	 * @author Jakub "Student" Olek
	 */

class NavigationApiController extends WikiaApiController {

	/**
	 * Fetches wiki navigation
	 *
	 * @responseParam array $navigation Wiki Navigation
	 *
	 * @example wikia.php?controller=NavigationApi&method=get
	 */
	public function get(){
		$model = new NavigationModel();

		$this->response->setVal( 'nav', $model->get() );
	}
}