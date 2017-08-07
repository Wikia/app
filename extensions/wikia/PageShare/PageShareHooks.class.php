<?php

use Wikia\PageHeader\Button;

class PageShareHooks {
	/**
	 * @param Title $title
	 * @param array $buttons
	 *
	 * @return bool
	 */
	public static function onAfterPageHeaderButtons( \Title $title, array &$buttons ): bool {
		if (
			$title->isContentPage() &&
			$title->exists()
		) {
			$label = wfMessage( 'page-share-entry-point-label' )->escaped();
			$buttons[] = new Button( $label, 'wds-icons-share', '#', 'wds-is-secondary', 'ShareEntryPoint' );
		}

		return true;
	}
}
