<?php

class WikiDataModel {
	private $pageName;
	private $imageName;

	public $cropPosition;
	public $description;
	public $imagePath;
	public $originalImagePath;

	const WIKI_HERO_IMAGE_PROP_ID = 10001;
	const WIKI_HERO_TITLE_PROP_ID = 10002;
	const WIKI_HERO_DESCRIPTION_ID = 10003;
	const WIKI_HERO_IMAGE_CROP_POSITION_ID = 10004;

	const WIKI_HERO_IMAGE_MAX_WIDTH = 1600;
	const WIKI_HERO_IMAGE_MAX_HEIGHT = 400;
	const DEFAULT_IMAGE_CROP_POSITION = 0; // Not fully supported yet

	public function __construct( $pageName ) {
		$this->pageName = $pageName;
	}

	public function isEmpty() {
		return empty($this->description) || empty($this->imagePath);
	}

	public function setFromAttributes( $attributes ) {
		$this->imageName = !empty( $attributes[ 'imagename' ] ) ? $attributes[ 'imagename' ] : null;
		$this->description = !empty( $attributes[ 'description' ] ) ? $attributes[ 'description' ] : null;
		$this->cropPosition = !empty( $attributes[ 'cropposition' ] ) ? $attributes[ 'cropposition' ] : null;

		$this->initializeImagePaths( $this->cropPosition );
	}

	public function storeInProps() {
		$pageId = Title::newFromText( $this->pageName )->getArticleId();

		wfSetWikiaPageProp( self::WIKI_HERO_IMAGE_PROP_ID, $pageId, $this->imageName );
		wfSetWikiaPageProp( self::WIKI_HERO_DESCRIPTION_ID, $pageId, trim($this->description) );
		wfSetWikiaPageProp( self::WIKI_HERO_IMAGE_CROP_POSITION_ID, $pageId, $this->cropPosition );
	}

	public function getFromProps() {
		$pageId = Title::newFromText( $this->pageName )->getArticleId();

		$this->imageName = wfGetWikiaPageProp( self::WIKI_HERO_IMAGE_PROP_ID, $pageId );
		$this->description = wfGetWikiaPageProp( self::WIKI_HERO_DESCRIPTION_ID, $pageId );
		$this->cropPosition = floatval(wfGetWikiaPageProp( self::WIKI_HERO_IMAGE_CROP_POSITION_ID, $pageId ));

		$this->initializeImagePaths( $this->cropPosition );
	}

	public function setImageNameFromProps() {
		$pageId = Title::newFromText( $this->pageName )->getArticleId();
		$this->imageName = wfGetWikiaPageProp( self::WIKI_HERO_IMAGE_PROP_ID, $pageId );
		$this->initializeImagePaths( $this->cropPosition );
	}

	/**
	 * @param $imageName
	 */
	private function initializeImagePaths( $cropPosition ) {
		$imageTitle = Title::newFromText( $this->imageName, NS_FILE );
		$file = wfFindFile( $imageTitle );
		if ( $file && $file->exists() ) {
			$fullUrl = $file->getFullUrl();

			if (VignetteRequest::isVignetteUrl($fullUrl)) {
				$this->imagePath = $this->createVignetteThumbnail($file, $cropPosition);
			} else {
				$this->imagePath = $this->createOldThumbnail($file, $cropPosition);
			}

			$this->originalImagePath = $fullUrl;
		} else {
			$this->imageName = null;
			$this->imagePath = null;
			$this->originalImagePath = null;
		}
	}

	private function createVignetteThumbnail($file, $cropPosition) {
		return VignetteRequest::fromUrl($file->getFullUrl())
			->windowCrop()
			->width(self::WIKI_HERO_IMAGE_MAX_WIDTH)
			->xOffset(0)
			->yOffset(round($file->getHeight() * $cropPosition))
			->windowWidth($file->getWidth())
			->windowHeight(round($file->getWidth() / 4))
			->url();
	}

	private function createOldThumbnail($file, $cropPosition) {
		return $file->getThumbUrl(
			$this->getThumbSuffix(
				$file,
				self::WIKI_HERO_IMAGE_MAX_WIDTH,
				self::WIKI_HERO_IMAGE_MAX_HEIGHT,
				$cropPosition
			) );
	}

	private function getThumbSuffix( File $file, $expectedWidth, $expectedHeight, $crop ) {
		$originalHeight = $file->getHeight();
		$originalWidth = $file->getWidth();
		$originalRatio = $originalWidth / $originalHeight;
		$ratio = $expectedWidth / $expectedHeight;
		if ( $originalRatio > $ratio ) {
			$width = round( $originalHeight * $ratio );
			$height = $originalHeight;
		} else {
			$width = $originalWidth;
			$height = round( $originalWidth / $ratio );
		}

		$width = ( $width > $expectedWidth ) ? $expectedWidth : $width;
		$left = 0;
		$right = $originalWidth;
		$top = round( $originalHeight * $crop );
		$bottom = $top + $height;
		return "{$width}px-$left,$right,$top,$bottom";
	}

	public function storeInPage() {
		$pageTitleObj = Title::newFromText( $this->pageName );
		$pageArticleObj = new Article( $pageTitleObj );

		$articleContents = $pageArticleObj->getContent();

		// Remove the original hero text; if there's a newline at the end, we will strip it
		// as new tag has one and we don't want a barrage of newlines
		$newContent = mb_ereg_replace( '<hero(.*?)/>\n?', '', $articleContents, 'mi' );

		// Prepend the hero tag
		$heroTag = Xml::element( 'hero', $attribs = [
			'description' => $this->description,
			'imagename' => $this->imageName,
			'cropposition' => $this->cropPosition
		] );
		$newContent = $heroTag . PHP_EOL . $newContent;

		// save and purge
		$pageArticleObj->doEdit( $newContent, '' );
		$pageArticleObj->doPurge();

	}

	public function getImageName() {
		return $this->imageName;
	}

	public function setImageName( $imageName ) {
		$this->imageName = $imageName;
	}

	public function getImagePath() {
		return $this->imagePath;
	}

	public function setImagePath( $imagePath ) {
		$this->imagePath = $imagePath;
	}
}
