<?php

use \Wikia\CommunityHeader\Sitename;
use \Wikia\CommunityHeader\Wordmark;
use \Wikia\CommunityHeader\Counter;
use \Wikia\CommunityHeader\WikiButtons;
use \Wikia\CommunityHeader\Navigation;

class CommunityHeaderController extends WikiaController {

	public function index() {
		global $wgCityId;
		$model = new DesignSystemCommunityHeaderModel($wgCityId);

		$this->setVal( 'sitename', new Sitename( $model ) );
		$this->setVal( 'wordmark', new Wordmark( $model ) );
		$this->setVal( 'counter', new Counter() );
		$this->setVal( 'wikiButtons', new WikiButtons() );
		$this->setVal( 'backgroundImageUrl', $model->getBackgroundImageUrl() );
	}

	public function localNavigation() {
		// wikiText variable is used for local navigation preview
		$wikiText = $this->getVal( 'wikiText', null );
		$this->setVal( 'navigation', new Navigation( $wikiText ) );
		$this->setVal( 'isPreview', $this->getVal( 'isPreview' ) );
	}
}
