<?php

class AdController extends WikiaController {

	public function index() {
		$this->slotname = $this->request->getVal('slotname');
	}

	public function executeConfig() {
		// TODO: stub
	}
	
	public function executeTop() {
	}
}
