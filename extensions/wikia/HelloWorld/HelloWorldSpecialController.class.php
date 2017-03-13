<?php
class HelloWorldSpecialController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'HelloWorld', '', false );
	}

	public function init() {
		$this->HelloWorldProvider = new HelloWorld( new Title('HelloWorld') );
	}

	public function index() {
		$this->wg->Out->setPageTitle( $this->wf->msg( 'helloworld-specialpage-title' ) );

		$wikiId = $this->getVal( 'wikiId', $this->wg->CityId );
		// setting response data
		$this->setVal( 'header', $this->wf->msg('helloworld-hello-msg') );
		$this->setVal( 'wikiData', $this->HelloWorldProvider->getWikiData( $wikiId ) );
	}
}
