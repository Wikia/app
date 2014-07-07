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

		$filters = $this->request->getVal( 'filters' );
		$setToAll = $this->request->getBool( 'all' );

		$rcfs = new RecentChangesFiltersStorage($this->wg->User);
		$rcfs->set( $filters, $setToAll );

		$this->response->setVal('status', "ok");
	}

	public function dropdownNamespaces() {
		$selected = $this->getVal( 'selected', array() );
		$namespaces = wfGetNamespaces();

		if(!empty($this->wg->EnableWallEngine)) {
			$namespaces = WallHelper::clearNamespaceList($namespaces);
		}

		$options = array();
		foreach( $namespaces as $index => $name ) {
			if( $index < NS_MAIN ) {
				continue;
			}

			$options[] = array(
				'value' => $index,
				'label' => $index === 0 ? wfMessage( 'blanknamespace' )->escaped() : $name
			);
		}

		if ( empty( $selected ) ) {
			$rcfs = new RecentChangesFiltersStorage($this->wg->User);
			$selected = $rcfs->get();
		}

		$this->html = $this->app->renderView( 'WikiaStyleGuideDropdownController', 'multiSelect', array(
			'options' => $options,
			'selected' => $selected,
			'selectAll' => true
		));
	}
}
