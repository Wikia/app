<?php

use Wikia\PageHeader\Button;

class SpecialVideosHooks {
	/**
	 * @param Title $title
	 * @param array $buttons
	 *
	 * @return bool
	 */
	public static function onAfterPageHeaderButtons( \Title $title, array &$buttons ): bool {
		$user = RequestContext::getMain()->getUser();

		if (
			$title->isSpecial( 'Videos' ) &&
			\F::app()->wg->EnableUploads &&
			$user->isAllowed( 'videoupload' )
		) {
			$label = wfMessage( 'special-videos-add-video' )->escaped();
			$buttons[] = new Button( $label, 'wds-icons-video-camera', '#', 'addVideo' );
		}

		return true;
	}
}
