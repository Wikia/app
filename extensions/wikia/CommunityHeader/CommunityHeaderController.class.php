<?php

use Wikia\CommunityHeader\Counter;
use Wikia\CommunityHeader\Navigation;
use Wikia\CommunityHeader\Sitename;
use Wikia\CommunityHeader\WikiButtons;
use Wikia\CommunityHeader\Wordmark;

class CommunityHeaderController extends WikiaController {

	/**
	 * @var $model DesignSystemCommunityHeaderModel
	 */
	private $model;

	public function init() {
		global $wgCityId;

		parent::init();

		$this->model = new DesignSystemCommunityHeaderModel( $wgCityId );
	}

	public function index() {
		$this->setVal( 'sitename', new Sitename( $this->model ) );
		$this->setVal( 'wordmark', new Wordmark( $this->model ) );
		$this->setVal( 'counter', new Counter() );
		$this->setVal( 'wikiButtons', new WikiButtons() );
		$this->setVal( 'backgroundImageUrl', $this->model->getBackgroundImageUrl() );
	}

	public function localNavigation() {
		// wikiText variable is used for local navigation preview
		$wikiText = $this->getVal( 'wikiText', null );
		$this->setVal( 'navigation', new Navigation( $this->model, $wikiText ) );
		$this->setVal( 'isPreview', $this->getVal( 'isPreview' ) );
	}
}
