<?php

class AdEmptyContainerController extends WikiaController {

	public function index() {
		$this->forward( 'AdEngine2', 'AdEmptyContainer' );
	}
}
