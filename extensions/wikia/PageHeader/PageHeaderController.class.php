<?php

namespace Wikia\PageHeader;


class PageHeaderController extends \WikiaController {

	/** @var  ActionButton */
	private $actionButton;

	public function init() {
		$this->actionButton = new ActionButton( \RequestContext::getMain() );
	}

	public function index() {
		$title = \RequestContext::getMain()->getTitle();

		$displayActionButton = $this->actionButton->shouldDisplay();

		wfRunHooks( 'PageHeaderBeforeDisplay', [ $title, &$displayActionButton ] );

		$this->setVal( 'displayActionButton', $displayActionButton );
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
		$this->setVal( 'languages', new Languages( $this->app ) );
	}
}
