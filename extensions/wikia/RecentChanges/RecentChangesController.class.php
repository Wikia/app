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

	public function saveFilters() {
		if($this->wg->User->getId() < 1) {
			$this->response->setVal('status', "error");
			return true;
		}

		$rcfs = new RecentChangesFiltersStorage($this->wg->User);
		$rcfs->set($this->request->getVal('filters'));

		$this->response->setVal('status', "ok"); 
	}
	
	public function dropdownNamespaces() {
		$all = $this->getVal( 'all',  null );
		$selected = $this->getVal( 'selected', array() );
		$namespaces = $this->wf->GetNamespaces();

		$options = array();
		foreach( $namespaces as $index => $name ) {
			if( $index < NS_MAIN ) {
				continue;
			}

			$options[] = array(
				'value' => $index,
				'label' => $index === 0 ? $this->wf->Msg( 'blanknamespace' ) : $name
			);
		}

		$rcfs = new RecentChangesFiltersStorage($this->wg->User);
		$selected = $rcfs->get();
		
		$this->html = $this->app->renderView( 'WikiaStyleGuideDropdownController', 'multiSelect', array(
			'options' => $options,
			'selected' => $selected,
			'selectAll' => true
		));		
	}
}
