<?php

namespace Wikia\PageHeader;


class PageHeaderController extends \WikiaController {

	/** @var  ActionButton */
	private $actionButton;
	/** @var  Languages */
	private $languages;

	public function init() {
		$this->actionButton = new ActionButton( \RequestContext::getMain() );
		$this->languages = new Languages( $this->app );
	}

	public function index() {
		$this->setVal( 'languages', $this->languages );
		$this->setVal( 'actionButton', $this->actionButton );
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
		$this->setVal( 'buttonAction', $this->actionButton->getButtonAction());
		$this->setval( 'dropdownActions', $this->actionButton->getDropdownActions());
	}

	public function languages() {
		$this->setVal( 'languages', $this->languages );
	}
}
