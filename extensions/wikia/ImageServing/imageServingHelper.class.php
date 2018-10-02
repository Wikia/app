<?php
/*
 * Author: Tomek Odrobny
 * Class to serving list of top 5 images for article use for indexing and keep index up to date
 */

class ImageServingHelper {
	const IMAGES_PER_ARTICLE = 230;

	private static $hookOnOff = false; // parser hooks are off

	public static function onArticleEditUpdates( WikiPage $wikiPage, $editInfo, bool $changed ) {
		$images = $editInfo->output->getImages();
		$title = $wikiPage->getTitle();

		// SRE-109: Leave early if this is a talk page (or equivalent, like comment/Wall/Forum)
		if ( $title->isTalkPage() ) {
			return true;
		}

		$task = \Wikia\Tasks\Tasks\ImageServingTask::newLocalTask();
		$task->title( $title );

		// SRE-109: Don't trigger a re-parse if the article has only one image or no images at all
		if ( count( $images ) <= 1 ) {
			$task->call( 'createIndexFromImages', array_keys( $images ) );
		} else {
			$task->call( 'createIndexFromPageContent' );
		}

		$task->queue();

		return true;
	}

	/**
	 * Replace images with some easy to parse tag
	 *
	 * @param $skin
	 * @param $title
	 * @param File|LocalFile $file
	 * @param $frameParams
	 * @param $handlerParams
	 * @param $time
	 * @param $res
	 * @return bool return false to break hooks flow
	 */
	public static function onImageBeforeProduceHTML( $skin, $title, $file, $frameParams, $handlerParams, $time, &$res ) {
		if (!self::$hookOnOff) {
			return true;
		}
		wfProfileIn(__METHOD__);

		$placeholder = self::getPlaceholder($file);
		if($placeholder !== false) {
			$res = $placeholder;
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	/**
	 * Replace images from image gallery with some easy to parse tag
	 *
	 * @param Parser $parser
	 * @param WikiaPhotoGallery $ig
	 * @return bool return true to continue hooks flow
	 */
	public static function onBeforeParserrenderImageGallery(
		Parser $parser, WikiaPhotoGallery &$ig
	): bool {
		global $wgEnableWikiaPhotoGalleryExt;

		if ((!self::$hookOnOff) || empty($wgEnableWikiaPhotoGalleryExt)) {
			return true;
		}

		wfProfileIn(__METHOD__);

		$ig->parse();
		$data = $ig->getData();

		$ig = new FakeImageGalleryImageServing( $data['images'] );

		wfProfileOut(__METHOD__);
		return false;
	}

	public static function hookSwitch( bool $onOff = true ) {
		self::$hookOnOff = $onOff;
	}

	/**
	 * Return placeholder than will later be parsed by ImageServing
	 *
	 * @param File $file
	 * @return string|bool placeholder's HTML or false when image doesn't exist
	 */
	public static function getPlaceholder($file) {
		$res = false;

		if( $file instanceof File ||  $file instanceof LocalFile ) {
			/* @var File $file */
			$res = " <image mw='".$file->getTitle()->getPartialURL()."' /> ";
		}

		return $res;
	}
}
