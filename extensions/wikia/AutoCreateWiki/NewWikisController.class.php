<?php

class NewWikisController extends WikiaSpecialPageController {

	const SPECIAL_PAGE_NAME1 = 'ActiveNewWikis';
	const SPECIAL_PAGE_NAME2 = 'NewWikis';


	protected $methodMapper = array();
	/**
	 * @var NewWikis
	 */
	protected $newWikis = null;

	public function __construct( WikiaApp $app = null ) {
		// we setting app here to make it accessible from hook handler
		$this->app = $app;
		$this->newWikis = F::build('NewWikis');

		$this->methodMapper[self::SPECIAL_PAGE_NAME1] = 'getActive';
		$this->methodMapper[self::SPECIAL_PAGE_NAME2] = 'getAll';

		// standard SpecialPage constructor call
		parent::__construct( self::SPECIAL_PAGE_NAME2, '', false );
	}

	public function index() {
		// do redirect instead of direct call to set correct template path
		$this->forward( 'NewWikis', 'getAll' );
	}

	public function getActive() {
		$active = $this->newWikis->getActive( $this->getPageNo() );

		$this->response->setVal( 'pageNo', $this->getPageNo() );
		$this->response->setVal( 'weeksNum', NewWikis::MAX_WEEKS );
		$this->response->setVal( 'wikis', $active['wikis'] );
		//$this->response->setBody( $this->request->getVal( 'par' ) );
	}

	public function getAll() {
		// we may reuse "index" template, it depends on mockups (to be provided)

		$this->response->setVal( 'pageNo', $this->getPageNo() );
		$this->response->setVal( 'wikis', $this->newWikis->getAll() );
	}

	private function getPageNo() {
		$pageNo = $this->request->getVal( 'pageNo', null );
		$pageNo = !empty($pageNo) ? $pageNo : $this->getPageNoFromTitle( explode( '/', $this->request->getVal( 'par', 1 ) ) );
		return $pageNo;
	}

	private function getPageNoFromTitle( Array $titleParts ) {
		if(count($titleParts) == 1) {
			return 1;
		}

		if( strtolower($titleParts[count($titleParts)-2]) == 'page' ) {
			return $titleParts[count($titleParts)-1];
		}

		return 1;
	}

	public function onArticleFromTitle( &$title, &$article ) {
		$titleParts = explode( '/', $title->getText() );
		if( in_array( $titleParts[0], array( self::SPECIAL_PAGE_NAME1, self::SPECIAL_PAGE_NAME2 ) ) && ( $title->getNamespace() == NS_MAIN ) ) {
			$newArticle = F::build( 'NewWikisArticle', array( $title ) );
			$newArticle->setMethod( $this->methodMapper[ $titleParts[0] ] );
			$newArticle->setApp( $this->app );
			$newArticle->setPageNo( $this->getPageNoFromTitle( $titleParts ) );

			$article = $newArticle;
		}
		return true;
	}

}
