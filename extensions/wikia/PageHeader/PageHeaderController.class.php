<?php

namespace Wikia\PageHeader;


use RequestContext;
use Wikia;

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

	public function buttons() {
		$title = RequestContext::getMain()->getTitle();
		$this->setVal( 'actionButton', $this->actionButton );

		$buttons = [];

		if ( $title->isSpecial( 'Images' ) && $this->app->wg->EnableUploads ) {
			$label = wfMessage( 'page-header-action-button-add-new-image' )->escaped();
			$buttons[] =
				new Button( $label, 'wds-icons-image',
					\SpecialPage::getTitleFor( 'Upload' )->getLocalURL(), '',
					'page-header-add-new-photo' );
		}

		wfRunHooks( 'AfterPageHeaderButtons', [ &$buttons ] );
		$this->setVal( 'buttons', $buttons );
	}
}
