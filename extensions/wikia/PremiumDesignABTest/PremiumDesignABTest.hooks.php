<?php
class PremiumDesignABTestHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'premium_mvp_scss' );
		\Wikia::addAssetsToOutput( 'premium_mvp_js' );

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$ooyalaHandler = new OoyalaVideoHandler();
		$ooyalaHandler->setVideoId('hwM2FkOTE6R_fZR9uu5jvOy9FHm3NS1O');
		$videoData = $ooyalaHandler->getEmbed(600, [
			'autoplay' => true,
			'isAjax' => true
		]);
		$vars['wgArticleVideoData'] = $videoData;
		return true;
	}
}
