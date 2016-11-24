<?php

class RWEPageHeaderController extends WikiaController {

	public function index() {

	}

	public function readTab() {
		$model = new NavigationModel();

		$data = $model->getWiki( NavigationModel::WIKI_LOCAL_MESSAGE );

		$this->menuNodes = $data[ 'wiki' ];
	}
}
