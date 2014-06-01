<?php
/*
 * Author: Tomek Odrobny
 * Class to serving list of top 5 images for article use for indexing and keep index up to date
 */

class ImageServingHelper {
	const IMAGES_PER_ARTICLE = 230;

	private static $hookOnOff = false; // parser hooks are off

	/**
	 * @param LinksUpdate $linksUpdate
	 * @return bool return true to continue hooks flow
	 */
	public static function onLinksUpdateComplete( $linksUpdate ) {
		wfProfileIn(__METHOD__);

		$articleId = $linksUpdate->getTitle()->getArticleID();
		$images = array_keys($linksUpdate->getImages());
		self::buildIndex( $articleId, $images);

		wfProfileOut(__METHOD__);
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
	public static function onBeforeParserrenderImageGallery( $parser, &$ig) {
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

	private static function hookSwitch($onOff = true) {
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

	/**
	 * buildIndex - save image index in db
	 *
	 * @param int $articleId article ID
	 * @param array|string $images
	 * @param $ignoreEmpty boolean
	 * @param bool $dryRun don't store results in DB (think twice before passing true, used by imageServing.php maintenance script)
	 * @return mixed|bool set of images extracted from given article
	 */
	public static function buildIndex( $articleId, $images, $ignoreEmpty = false, $dryRun = false ) {
		wfProfileIn(__METHOD__);

		// BugId:95164: limit the number of images to be stored serialized in DB
		// keep it under 65535 bytes
		if (count($images) > self::IMAGES_PER_ARTICLE) {
			$images = array_slice($images, 0, self::IMAGES_PER_ARTICLE);
		}

		array_walk( $images, create_function( '&$n', '$n = urldecode( $n );' ) );

		if ($dryRun) {
			wfProfileOut(__METHOD__);
			return $images;
		}

		wfDebug(__METHOD__ . ' - ' . json_encode($images). "\n");

		$dbw = wfGetDB(DB_MASTER, array());

		if( count($images) < 1 ) {
			if( $ignoreEmpty) {
				wfProfileOut(__METHOD__);
				return false;
			}
			$dbw->delete( 'page_wikia_props',
				array(
					'page_id' =>  $articleId,
					'propname' => WPP_IMAGE_SERVING
				),
				__METHOD__
			);
			wfProfileOut(__METHOD__);
			return array();
		}

		$dbw->replace('page_wikia_props','',
			array(
				'page_id' =>  $articleId,
				'propname' => WPP_IMAGE_SERVING,
				'props' => serialize($images)
			),
			__METHOD__
		);

		$dbw->commit();
		wfProfileOut(__METHOD__);
		return $images;
	}

	/**
	 * @param Article $article
	 * @param bool $ignoreEmpty
	 * @param bool $dryRun don't store results in DB (think twice before passing true, used by imageServing.php maintenance script)
	 * @return mixed|bool set of images extracted from given article
	 */
	public static function buildAndGetIndex($article, $ignoreEmpty = false, $dryRun = false ) {
		if(!($article instanceof Article)) {
			return false;
		}
		wfProfileIn(__METHOD__);

		$article->getRawText(); // TODO: not sure whether it's actually needed
		$title = $article->getTitle();
		$content = $article->getContent();

		self::hookSwitch();
		$editInfo = $article->prepareTextForEdit( $content, $title->getLatestRevID() );
		self::hookSwitch(false);

		$out = array();
		preg_match_all("/(?<=(image mw=')).*(?=')/U", $editInfo->output->getText(), $out );

		$images = self::buildIndex($article->getID(), $out[0], $ignoreEmpty, $dryRun);

		wfProfileOut(__METHOD__);
		return $images;
	}
}
