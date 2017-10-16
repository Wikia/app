<?php

class AdEmptyContainerController extends WikiaController {

	public function index() {
		$this->slotName = $this->request->getVal('slotName');
		$this->pageTypes = $this->request->getVal('pageTypes');
	}
}
