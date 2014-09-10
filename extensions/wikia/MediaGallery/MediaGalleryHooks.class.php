<?

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

		$out->addStyle(
			AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/MediaGallery/styles/MediaGallery.scss' )
		);

		wfProfileOut(__METHOD__);
		return true;
	}

}

