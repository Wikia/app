<?php

use Wikia\PageHeader\Button;

class PageShareHooks {
	public static function onAfterPageHeaderButtons( &$buttons ) {
		$title = RequestContext::getMain()->getTitle();

		if ( Wikia::isContentNamespace() && $title->exists() &&
		     !F::app()->checkSkin( 'oasislight' )
		) {
			$label = wfMessage( 'page-share-entry-point-label' )->escaped();
			$buttons[] =
				new Button( $label, 'wds-icons-share', '#', 'wds-is-secondary', 'ShareEntryPoint' );
		}

		return true;
	}
}
