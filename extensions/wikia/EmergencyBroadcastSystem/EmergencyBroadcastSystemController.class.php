<?php
class EmergencyBroadcastSystemController extends WikiaController {
	public function index( ) {
		$this->response->setVal( 'nonPortableCount', '3' ); // Temporary number for testing
	}
}
