<?php

namespace Wikia\PageHeader;

use Wikia;

class PageHeaderController extends \WikiaController {

	public function index() {
		$this->setVal( 'counter', new Counter() );
		$this->setVal( 'languages', new Languages( $this->app ) );
		$this->setVal( 'pageTitle', new PageTitle( $this->app ) );
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
		$this->setVal( 'languages', $this->getVal( 'languages' ) );
	}

	public function buttons() {
		$this->setVal( 'actionButton', new ActionButton( $this->app ) );
		$this->setVal( 'buttons', new Buttons( $this->app ) );
	}
}
