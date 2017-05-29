<?php

use \CommunityHeader\Sitename;
use \CommunityHeader\Wordmark;
use \CommunityHeader\Counter;
use \CommunityHeader\WikiButtons;
use \CommunityHeader\Navigation;

class CommunityHeaderController extends WikiaController {

	public function init() {
	}

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
				->getValue() ?? ''
		);
	}
}
