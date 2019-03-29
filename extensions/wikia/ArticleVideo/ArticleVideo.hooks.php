<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out/*, \Skin $skin*/ ) {
		$articleId = $out->getTitle()->getArticleID();

		if ( ArticleVideoContext::isFeaturedVideoAvailable( $articleId ) ) {
			self::addFeaturedVideoAssets();
		} else if ( ArticleVideoContext::isRecommendedVideoAvailable( $articleId ) ) {
			self::addRecommendedVideoAssets();
		}

		return true;
	}

	public static function onGetPreferences( User $user, &$defaultPreferences ) {
		if ( !$user->isAllowed( ArticleVideoContext::SHOW_FEATURED_VIDEO_RIGHT ) ) {
			$showFeaturedVideo = wfMessage( 'articlevideo-preference-option-show-featured-video' )->escaped();
			$disableFeaturedVideo = wfMessage( 'articlevideo-preference-option-disable-featured-video' )->escaped();

			$defaultPreferences[ArticleVideoContext::DISABLE_FEATURED_VIDEO_PREFERENCE] = [
				'label-message' => 'articlevideo-preference-label',
				'section' => 'personal/appearance',
				'type' => 'select',
				'options' => [
					$showFeaturedVideo => 0,
					$disableFeaturedVideo => 1,
				],
			];
		}
	}

	private static function addFeaturedVideoAssets() {
		\Wikia::addAssetsToOutput( 'jwplayer_scss' );
		\Wikia::addAssetsToOutput( 'jwplayer_js' );
	}

	private static function addRecommendedVideoAssets() {
		\Wikia::addAssetsToOutput( 'recommended_video_css' );
		\Wikia::addAssetsToOutput( 'recommended_video_scss' );
		\Wikia::addAssetsToOutput( 'recommended_video_js' );
	}

	public static function onInstantGlobalsGetVariables( array &$vars ): bool {
		$vars[] = 'wgArticleVideoAutoplayCountries';
		$vars[] = 'wgArticleVideoNextVideoAutoplayCountries';

		return true;
	}
}
