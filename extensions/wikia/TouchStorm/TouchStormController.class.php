<?php
class TouchStormController extends WikiaController {
	public function executeIndex() {
		$this->response->addAsset('touchstorm_scss');
		$this->response->addAsset('touchstorm_js');
	}
}
