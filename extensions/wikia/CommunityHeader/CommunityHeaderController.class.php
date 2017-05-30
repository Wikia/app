<?php

use \Wikia\CommunityHeader\Sitename;
use \Wikia\CommunityHeader\Wordmark;
use \Wikia\CommunityHeader\Counter;
use \Wikia\CommunityHeader\WikiButtons;
use \Wikia\CommunityHeader\Navigation;

class CommunityHeaderController extends WikiaController {

	public function index() {
		global $wgCityId;

		$this->setVal( 'sitename', new Sitename() );
		$this->setVal( 'wordmark', new Wordmark() );
		$this->setVal( 'counter', new Counter() );
		$this->setVal( 'wikiButtons', new WikiButtons() );
		$this->setVal( 'navigation', new Navigation() );
		$this->setVal(
			'backgroundImageUrl',
			( new SiteAttributeService() )
				->getApiClient()
				->getAttribute( $wgCityId, 'pageHeaderImage' )
				->getValue() );
	}

	public function localNavigation() {
		$this->setVal( 'navigation', $this->getVal( 'navigation' ) );
	}
}
