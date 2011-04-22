<?php
class ProposalController extends WikiaSpecialPageController {

	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'Proposal', 'proposal', false );
	}

	/**
	 * this is default method
	 */
	public function index() {
		$this->redirect( 'Proposal', 'renderDashboard' );
	}

	public function renderDashboard() {
		$this->setHeaders();

		$wikiId = $this->request->getVal( 'wikiId' );
		$userId = $this->request->getVal( 'userId' );

		$usersResponse = $this->sendRequest('ProposalUsers', 'get', array( 'wikiId' => $wikiId ) );
		$pagesResponse = $this->sendRequest('ProposalPages', 'get', array( 'userId' => $userId ) );
//var_dump($usersResponse->getException());
//var_dump($pagesResponse->getException());


		$this->response->setVal( 'wikiId', $wikiId );
		$this->response->setVal( 'userId', $userId );
		$this->response->setVal( 'users', $usersResponse->getVal( 'users' ) );
		$this->response->setVal( 'pages', $pagesResponse->getVal( 'pages' ) );
	}

	public function getUsersView() {
		$data = array(
			'wikiId' => 1,
			'users' => array(
					array( 'userId' => 11, 'userName' => 'Some User 1' ),
					array( 'userId' => 12, 'userName' => 'Some User 2' ),
			)
		);

		$usersView = $this->app->getView( 'ProposalUsers', 'get', $data );

		$this->response->setBody( $usersView->render() );
	}

}
