<?php

class MediaGalleryHooks {
	/**
	 * Load JS needed to display the VideosModule at the bottom of the article content
	 * @param OutputPage $out
	 * @param string $text
	 * @return bool
	 */
	static public function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		if ( empty( F::app()->wg->EnableMediaGalleryExt ) ) {
			return true;
		}
		wfProfileIn(__METHOD__);

		JSMessages::enqueuePackage( 'MediaGallery', JSMessages::EXTERNAL );

		$scripts = AssetsManager::getInstance()->getURL( 'media_gallery_js' );
		foreach( $scripts as $script ){
			$out->addScript( "<script src='{$script}'></script>" );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Add extension enabled flag to JS
	 * @param array $vars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript(Array &$vars) {
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
