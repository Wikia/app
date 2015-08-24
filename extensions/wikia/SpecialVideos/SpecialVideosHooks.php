<?php
/**
 * Hooks for SpecialVideos
 */

class SpecialVideosHooks {
	/**
	 * Add a button to upload videos with on Special:Videos
	 *
	 * @param array $extraButtons An array of strings to add extra buttons to
	 * @return bool true
	 */
	public static function onPageHeaderIndexExtraButtons( array &$extraButtons ) {
		$app = F::app();

		if (
			!empty( $app->wg->EnableUploads ) &&
			$app->wg->Title->isSpecial( 'Videos' ) &&
			$app->wg->User->isAllowed( 'videoupload' )
		) {
			$text = Html::element(
				'img',
				[
					'src' => wfBlankImgUrl(),
					'class' => 'sprite addRelatedVideo'
				],
				null
			);

			$text .= ' ' . wfMessage( 'videos-add-video' )->escaped();

			// use rawElement so it doesn't escape $text
			// or more specifically, the img tag above
			$extraButtons[] = Html::rawElement(
				'a',
				[
					'class' => 'button addVideo',
					'href' => '#',
					'rel' => 'tooltip',
					'title' => wfMessage( 'related-videos-tooltip-add' )->escaped()
				],
				$text

			);
		}

		return true;
	}
}
