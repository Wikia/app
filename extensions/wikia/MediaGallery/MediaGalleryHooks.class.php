<?php

class MediaGalleryHooks {

	/**
	 * Add JSMessages for MediaGallery.
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
	 * Adds MediaGallery JS to main Oasis asset group
	 * @param Array $assetsArray
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( &$assetsArray ) {
		if ( !empty( F::app()->wg->EnableMediaGalleryExt ) ) {
			$assetsArray[] = 'media_gallery_js';
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