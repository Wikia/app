<?php

use \Wikia\CommunityHeader\Sitename;
use \Wikia\CommunityHeader\Wordmark;
use \Wikia\CommunityHeader\Counter;
use \Wikia\CommunityHeader\WikiButtons;
use \Wikia\CommunityHeader\Navigation;

class CommunityHeaderController extends WikiaController {

	public function index() {
		$this->setVal( 'sitename', new Sitename() );
		$this->setVal( 'wordmark', new Wordmark() );
		$this->setVal( 'counter', new Counter() );
		$this->setVal( 'wikiButtons', new WikiButtons() );
		$this->setVal(
			'backgroundImageUrl',
			( new ThemeSettings() )->getCommunityHeaderBackgroundUrl() );
	}

	public function localNavigation() {
		// wikiText variable is used for local navigation preview
		$wikiText = $this->getVal( 'wikiText', null );
		$this->setVal( 'navigation', new Navigation( $wikiText ) );
		$this->setVal( 'isPreview', $this->getVal( 'isPreview' ) );
	}
}
