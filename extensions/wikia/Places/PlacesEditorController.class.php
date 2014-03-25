<?php

/**
 * This controller is used to render visual places editor
 */

class PlacesEditorController extends WikiaController {

	public function getEditorModal() {
		$this->response->setCacheValidity(3600);
	}
}
