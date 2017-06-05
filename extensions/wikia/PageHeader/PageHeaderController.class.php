<?php

namespace Wikia\PageHeader;


class PageHeaderController extends \WikiaController {

	public function index() {
		global $wgTitle;

		$displayActionButton = !$wgTitle->isSpecialPage() || $wgTitle->isSpecial( 'ThemeDesignerPreview' );

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
		global $wgTitle;

		$button = new ActionButton( $wgTitle );

		$this->setVal('buttonAction', $button->getButtonAction());
		$this->setval('dropdownActions', $button->getDropdownActions());
	}

	public function languages() {
		$this->setVal( 'languages', new Language( $this->app ) );
	}
}
