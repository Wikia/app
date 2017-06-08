<?php

namespace Wikia\PageHeader;

use Wikia;

class PageHeaderController extends \WikiaController {

	/** @var  Languages */
	private $languages;

	public function init() {
		$this->languages = new Languages( $this->app );
	}

	public function index() {
		$this->setVal( 'languages', $this->languages );
		$this->setVal( 'pageTitle', new PageTitle( $this->app ) );
		$this->setVal( 'counter', new Counter() );
	}

	public function categories() {
		$this->setVal( 'categories', new Categories() );
	}

	public function subtitle() {
		$this->setVal( 'subtitle', new Subtitle( $this->app ) );
	}

	public function actionButton() {
		$actionButton = $this->getVal( 'actionButton' );

		$this->setVal( 'buttonAction', $actionButton->getButtonAction() );
		$this->setval( 'dropdownActions', $actionButton->getDropdownActions() );
	}

	public function languages() {
		$this->setVal( 'languages', $this->languages );
	}

	public function buttons() {
		$this->setVal( 'actionButton', new ActionButton( $this->app ) );
		$this->setVal( 'buttons', new Buttons( $this->app ) );
	}
}
