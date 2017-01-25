<?php

class AdController extends WikiaController {

	public function index() {
		$this->slotName = $this->request->getVal('slotName');
		$this->pageTypes = $this->request->getVal('pageTypes');
		$this->includeLabel = $this->request->getVal('includeLabel');
		$this->onLoad = $this->request->getVal('onLoad');
		$this->addToAdQueue = $this->request->getVal('addToAdQueue');
	}

	public function executeConfig() {
		// TODO: stub
	}

	public function executeTop() {
	}
}
