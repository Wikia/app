<?php

/**
 * Recent Changes Controller
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class RecentChangesController extends WikiaController {

	public function init() {
		$this->response->addAsset('extensions/wikia/RecentChanges/js/RecentChanges.js');
		$this->response->addAsset('extensions/wikia/RecentChanges/css/RecentChanges.scss');
	}

	public function index() {
		
	}
	
	public function saveFilters() {
		if($this->wg->User->getId() < 1) {
			$this->response->setVal('status', "error");
			return true;
		}

	/*	foreach() {
			
		} */
		
		$rcf = new RecentChangesFiltersStorage($this->wg->User);
		$rcf->set($this->response->getVal('filters'));
		$this->response->setVal('status', "ok"); 
	}

}
