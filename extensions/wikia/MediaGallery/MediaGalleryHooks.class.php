<?php

class MediaGalleryHooks {

	/**
	 * Send MediaGallery i18n messages to JS.
	 * Note: adding them via onOasisSkinAssetGroups doesn't work.
	 * @param OutputPage $out
	 * @param $text
	 * @return bool
	 */
	static public function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		if ( !empty( F::app()->wg->EnableMediaGalleryExt ) ) {
			JSMessages::enqueuePackage( 'MediaGallery', JSMessages::EXTERNAL );
		}
		return true;
	}

	/**
	 * Add extension enabled flag to JS
	 * @param array $vars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript( Array &$vars ) {
		$vars['wgEnableMediaGalleryExt'] = !empty( F::app()->wg->EnableMediaGalleryExt );
		return true;
	}

	/**
	 * Run when the MediaGallery feature is toggled in Labs
	 * @param string $feature The name of the feature that is being toggled
	 * @param bool $enabled Whether feature is now enabled or disabled
	 * @return bool
	 */
	public static function afterToggleFeature( $feature, $enabled ) {
		if ( $feature == 'wgEnableMediaGalleryExt' ) {
			// Purge cache for all pages containing gallery tags
			$task = ( new \Wikia\Tasks\Tasks\GalleryCachePurgeTask() )
				->wikiId( F::app()->wg->CityId );
			$task->dupCheck();
			$task->call( 'purge' );
			$task->queue();
		}

		return true;
	}
}