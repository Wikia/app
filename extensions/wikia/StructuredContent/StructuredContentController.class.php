<?php

class StructuredContentController extends WikiaController {

	const RESPONSE_STATUS_OK = 'ok';
	const RESPONSE_STATUS_ERROR  = 'error';

	/**
	 * @var StructuredContentHelper
	 */
	protected $helper = null;

	public function __construct() {
		$this->helper = new StructuredContentHelper();
	}


	public function ChangedPagesList() {

		$startFrom = $this->request->getVal( 'startFrom' );

		$data = $this->helper->getChangedPagesList( $startFrom );
		$this->response->setData( $data );
	}

}