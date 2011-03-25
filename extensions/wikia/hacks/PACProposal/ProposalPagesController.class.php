<?php

class ProposalPagesController extends WikiaController {

	public function __construct() {
		$this->allowedRequests[ 'get' ] = array( 'html', 'json' );
	}

	public function get() {
		$pages = F::build( 'ProposalPages' );
		$userId = $this->request->getVal( 'userId' );

		if( !empty( $userId ) ) {
			$this->response->setVal( 'pages', $pages->getList( $userId ) );
		}
		else {
			throw new WikiaException( 'User ID is empty' );
		}
	}

}