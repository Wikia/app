<?php

namespace Wikia\PageHeader;


class PageHeaderController extends \WikiaController {

	public function index() {
		$title = \RequestContext::getMain()->getTitle();

		$displayActionButton = !$title->isSpecialPage();

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
		$button = new ActionButton( \RequestContext::getMain() );

		$this->setVal( 'buttonAction', $button->getButtonAction());
		$this->setval( 'dropdownActions', $button->getDropdownActions());
	}

	public function languages() {
		$this->setVal( 'languages', new Languages( $this->app ) );
	}
}
