<?php

class ProposalUsersController extends WikiaSpecialPageController  {

	public function __construct() {
		$this->allowedRequests[ 'get' ] = array( 'html', 'json' );
		$this->allowedRequests[ 'index' ] = array( 'html', 'json' );

		// standard SpecialPage constructor call
		parent::__construct( 'ProposalSimple', '', false );
	}

	/**
	 * this method is a default entry point
	 */
	public function index() {
		$this->redirect( 'ProposalUsers', 'get' );
	}

	public function get() {
		$users = F::build( 'ProposalUsers' );

		$wikiId = $this->request->getVal( 'wikiId' );
		if( !empty($wikiId) ) {
			$this->response->setVal( 'users', $users->getList( $wikiId ) );
			$this->response->setVal( 'wikiId', $wikiId );
		}
		else {
			throw new WikiaException( 'Invalid Wiki ID' );
		}
	}

}