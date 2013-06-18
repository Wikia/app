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
		$this->forward( 'Proposal', 'renderDashboard' );
	}

	public function renderDashboard() {
		$this->setHeaders();

		$wikiId = $this->getVal( 'wikiId' );
		$userId = $this->getVal( 'userId' );
		$switchTemplate = (bool) $this->getVal( 'switchTemplate', false );

		if( $switchTemplate ) {
			// changing default template
			$this->response->getView()->setTemplatePath( dirname( __FILE__ ) . '/templates/someTemplate.php' );
		}

		$usersResponse = $this->sendRequest('ProposalUsers', 'get', array( 'wikiId' => $wikiId ) );
		$pagesResponse = $this->sendRequest('ProposalPages', 'get', array( 'userId' => $userId ) );

		$this->setVal( 'wikiId', $wikiId );
		$this->setVal( 'userId', $userId );
		$this->setVal( 'users', $usersResponse->getVal( 'users' ) );
		$this->setVal( 'pages', $pagesResponse->getVal( 'pages' ) );
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

	static public function onSpecialPage_initList( &$list ) {
		var_dump( $list );
	}

}
