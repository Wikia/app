<?php
class ProposalController extends WikiaSpecialPageController {

	protected $app = null;

	public function __construct() {
		$this->app = F::app();

		$this->allowedRequests[ 'index' ] = array( 'html' );
		$this->allowedRequests[ 'renderDashboard' ] = array( 'html' );

		// standard SpecialPage constructor call
		parent::__construct( 'Proposal', '', false );
	}

	/**
	 * this is default method
	 */
	public function index() {
		$this->redirect( 'Proposal', 'renderDashboard' );
	}

	public function renderDashboard() {
		$wikiId = $this->request->getVal( 'wikiId' );
		$userId = $this->request->getVal( 'userId' );

		$usersResponse = $this->sendRequest('ProposalUsers', 'get', array( 'wikiId' => $wikiId ) );
		$pagesResponse = $this->sendRequest('ProposalPages', 'get', array( 'userId' => $userId ) );

		$this->response->setVal( 'wikiId', $wikiId );
		$this->response->setVal( 'userId', $userId );
		$this->response->setVal( 'users', $usersResponse->getVal( 'users' ) );
		$this->response->setVal( 'pages', $pagesResponse->getVal( 'pages' ) );
	}

}
