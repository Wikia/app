<?php

use Wikia\PageHeader\Button;

class SpecialVideosHooks {
	public static function onAfterPageHeaderButtons( &$buttons ) {
		$user = RequestContext::getMain()->getUser();
		$title = RequestContext::getMain()->getTitle();

		if ( $title->isSpecial( 'Videos' ) && \F::app()->wg->EnableUploads &&
		     $user->isAllowed( 'videoupload' )
		) {
			$label = wfMessage( 'special-videos-add-video' )->escaped();
			$buttons[] = new Button( $label, 'wds-icons-video-camera', '#', 'addVideo' );
		}

		return true;
	}
}
