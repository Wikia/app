<?php
class HelloWorldSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		/*
		 * @class SpecialPage
		 * @param $name (String) Name of page/extension as seen in links and urls
		 * @param $restriction	(String) user right required
		 */
		parent::__construct( 'HelloWorld', '', false );
	}

	public function init() {
		$this->HelloWorldService = new HelloWorld( new Title('HelloWorld' ));
	}

	public function index() {
		$this->wg->Out->setPageTitle( $this->wf->msg( 'helloworld-specialpage-title') );
		$wikiId = $this->getVal( 'wikiId', $this->wg->CityId );
		// seting response data
		$this->setVal( 'header', $this->wf->msg('helloworld-hello-msg') );
		$this->setVal( 'wikiData', $this->HelloWorldService->getWikiData( $wikiId ) );
	}
}
