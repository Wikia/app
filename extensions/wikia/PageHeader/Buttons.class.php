<?php

namespace Wikia\PageHeader;

use RequestContext;
use SpecialPage;
use WikiaApp;

class Buttons {
	/**
	 * @var array
	 */
	public $buttons;

	public function __construct( WikiaApp $app ) {
		$title = RequestContext::getMain()->getTitle();

		$buttons = [];

		if ( $title->isSpecial( 'Images' ) && $app->wg->EnableUploads ) {
			$label = wfMessage( 'page-header-action-button-add-new-image' )->escaped();
			$buttons[] = new Button(
				$label,
				'wds-icons-image',
				SpecialPage::getTitleFor( 'Upload' )->getLocalURL(),
				'',
				'page-header-add-new-photo'
			);
		}

		\Hooks::run( 'AfterPageHeaderButtons', [ $title, &$buttons ] );

		$this->buttons = $buttons;
	}
}
