<?php

namespace Wikia\PageHeader;


class PageHeaderController extends \WikiaController {

	public function index() {
		global $wgTitle;

		$displayActionButton = !$wgTitle->isSpecialPage() || $wgTitle->isSpecial( 'ThemeDesignerPreview' );

		$this->setVal( 'displayActionButton', $displayActionButton );
		$this->setVal( 'pageTitle', new PageTitle( $this->app ) );
		$this->setVal( 'counter', new Counter( $this->app ) );
	}

	public function subtitle() {
		$this->setVal( 'subtitle', new Subtitle( $this->app ) );
	}

	public function actionButton() {
		$button = new ActionButton();

		$this->setVal('buttonAction', $button->getButtonAction());
		$this->setval('dropdownActions', $button->getDropdownActions());
	}
}
