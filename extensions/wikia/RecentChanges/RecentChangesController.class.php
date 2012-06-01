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
		$rcf = new RecentChangesFiltersStorage($this->wg->User);
		$rcf->set($this->request->getVal('filters'));
		$this->response->setVal('status', "ok"); 
	}
	
	public function dropdownNamespaces() {
		$all = $this->getVal( 'all',  null );
		$selected = $this->getVal( 'selected', array() );
		$namespaces = $this->wf->GetNamespaces();
		if( !is_null( $all ) ) {
			$namespaces = array( 'all' => $this->wf->Msg( 'namespacesall' ) ) + $namespaces;
		}

		$options = array();
		foreach( $namespaces as $index => $name ) {
			if( $index < NS_MAIN )
				continue;
			if( $index === 0 )
				$options[$index] = $this->wf->Msg( 'blanknamespace' );
			else
				$options[$index] = $name;
		}

		$rcfs = new RecentChangesFiltersStorage($this->wg->User);
		$selected = array_flip($rcfs->get());
		$this->html = $this->app->renderView( 'WikiaStyleGuideDropdownController', 'multiSelect', array(
			'options' => $options,
			'selected' => $selected,
			'toolbar' => $this->app->getView( 'RecentChangesController', 'dropdown_toolbar' )->render()
		));		
	}
}
