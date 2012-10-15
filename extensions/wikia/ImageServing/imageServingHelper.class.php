<?php
/*
 * Author: Tomek Odrobny
 * Class to serving list of top 5 images for article use for indexing and keep index up to date
 */

class ImageServingHelper{
	static $hookOnOff = false; // parser hook are off

	public static function buildIndexOnPageEdit( $self ) {
		wfProfileIn(__METHOD__);

		if(count($self->mImages) == 1) {
			$images = array_keys($self->mImages);
			self::bulidIndex( $self->mId, $images);
			wfProfileOut(__METHOD__);
			return true;
		}

		$article = Article::newFromID( $self->mId );
		self::buildAndGetIndex( $article );
		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @static
	 * @param $article
	 * @param bool $ignoreEmpty
	 * @return mixed
	 */
	public static function buildAndGetIndex($article, $ignoreEmpty = false ) {
		if(!($article instanceof Article)) {
			return;
		}
		wfProfileIn(__METHOD__);

		$articleText = $article->getRawText();
		$title = $article->getTitle();
		$content = $article->getContent();
		self::hookSwitch();
		$editInfo = $article->prepareTextForEdit( $content, $title->getLatestRevID() );
		self::hookSwitch(false);
		$out = array();
		preg_match_all("/(?<=(image mw=')).*(?=')/U", $editInfo->output->getText(), $out );

		self::bulidIndex($article->getID(), $out[0], $ignoreEmpty);
		wfProfileOut(__METHOD__);
	}

	/**
	 *  replaceGallery - hook replace images with some easy to parse tag
	 *
	 *  return boolean
	 */

	public static function replaceImages( $skin, $title, $file, $frameParams, $handlerParams, $time, &$res ) {
		if (!self::$hookOnOff) {
			return true;
		}
		wfProfileIn(__METHOD__);

		if( $file instanceof File ||  $file instanceof LocalFile ) {
			$res = " <image mw='".$file->getTitle()->getPartialURL()."' /> ";
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	/**
	 *  replaceGallery - hook replace images from image gallery with some easy to parse tag :
	 *
	 *  return boolean
	 */

	public static function replaceGallery( $parser, &$ig) {
		global $wgEnableWikiaPhotoGalleryExt;

		if ((!self::$hookOnOff) || empty($wgEnableWikiaPhotoGalleryExt)) {
			return true;
		}

		wfProfileIn(__METHOD__);

		$ig->parse();
		$data = $ig->getData();

		$ig = new fakeIGimageServing( $ig->mImages );
		wfProfileOut(__METHOD__);
		return false;
	}

	private static function hookSwitch($onOff = true) {
		self::$hookOnOff = $onOff;
	}

	public static function isParsing() {
		return self::$hookOnOff;
	}

	/**
	 * buildImages - helper function to help build list on images in parserHook
	 *
	 *
	 * @param $files \type{\arrayof{\file}}
	 *
	 * @return string
	 **/

	public static function buildImages($files) {
		$res = '';
		foreach($files as $file) {
			if( $file instanceof File ||  $file instanceof LocalFile ) {
				$res .= " <image mw='".$file->getTitle()->getPartialURL()."' /> ";
			}
		}
		return $res;
	}

	/**
	 * bulidIndex - save image index in db
	 *
	 * @param $width \int
	 * @param $images \type{\arrayof{\string}}
	 * @param $ignoreEmpty boolean
	 *
	 * @return boolean
	 */

	public static function bulidIndex($articleId, $images, $ignoreEmpty = false) {
		/* 0 and 1 image don't need to be indexed */
		wfProfileIn(__METHOD__);
		$db = wfGetDB(DB_MASTER, array());

		array_walk( $images, create_function( '&$n', '$n = urldecode( $n );' ) );

		if( (count($images) < 1) ) {
			if ($ignoreEmpty) {
				wfProfileOut(__METHOD__);
				return true;
			}
			$db->delete( 'page_wikia_props',
				array(
					'page_id' =>  $articleId,
					'propname' => "0"),
				__METHOD__
			);
			wfProfileOut(__METHOD__);
			return true;
		}
		$db->delete( 'page_wikia_props',
			array(
				'page_id' =>  $articleId,
				'propname' => "imageOrder"),
			__METHOD__
		);

		$db->replace('page_wikia_props','',
			array(
				'page_id' =>  $articleId,
				'propname' => "0",
				'props' => serialize($images)
			),
			__METHOD__
		);

		$db->commit();
		wfProfileOut(__METHOD__);
		return true;
	}
}

/* fake class for replace image gallery in hook*/
class fakeIGimageServing extends ImageGallery {
	private $in;

	function __construct($in) {
		$this->in = $in;
	}

	function toHTML() {
		$res = "";
		foreach ( $this->in as $key => $imageData ) {
			$file =  $this->getImage($imageData[0]);

			if($file) {
				$res .= " <image mw='".$file->getTitle()->getDBkey()."' /> ";
			}
		}
		return $res;
	}

	private function getImage($nt) {
		wfProfileIn(__METHOD__);

		# Give extensions a chance to select the file revision for us
		$time = $descQuery = false;
		wfRunHooks( 'BeforeGalleryFindFile', array( &$this, &$nt, &$time, &$descQuery ) );

		# Render image thumbnail
		$img = wfFindFile( $nt, $time );
		wfProfileOut(__METHOD__);
		return $img;
	}
}
