<?php

class ProposalUsersController extends WikiaSpecialPageController  {

	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'ProposalSimple', '', false );
	}

	/**
	 * this method is a default entry point
	 */
	public function index() {
		$this->forward( 'ProposalUsers', 'get' );
	}

	public function get() {
		$users = (new ProposalUsers);

		$wikiId = $this->getVal( 'wikiId' );
		if( !empty($wikiId) ) {
			$this->setVal( 'users', $users->getList( $wikiId ) );
			$this->setVal( 'wikiId', $wikiId );
		}
		else {
			throw new WikiaException( 'Invalid Wiki ID' );
		}
	}

}