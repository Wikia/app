<?php

class WikiDataModel {
	private $pageName;
	private $imageName;

	public $imagePath;
	public $title;
	public $description;

	const WIKI_HERO_IMAGE_PROP_ID = 10001;
	const WIKI_HERO_TITLE_PROP_ID = 10002;
	const WIKI_HERO_DESCRIPTION_ID = 10003;
	const WIKI_HERO_IMAGE_MAX_WIDTH = 1600;
	const WIKI_HERO_IMAGE_MAX_HEIGHT = 500;

	public function __construct( $pageName ) {
		$this->pageName = $pageName;
	}

	public function setFromAttributes( $attributes ) {
		$imageName = ! empty( $attributes['imagename'] ) ? $attributes['imagename'] : null;
		$this->title = ! empty( $attributes['title'] ) ? $attributes['title'] : null;
		$this->description = ! empty( $attributes['description'] ) ? $attributes['description'] : null;

		if ( $imageName ) {
			$this->initializeImagePath( $imageName );
		}
	}

	public function storeInProps() {
		$pageId = Title::newFromText( $this->pageName )->getArticleId();

		wfSetWikiaPageProp( self::WIKI_HERO_IMAGE_PROP_ID, $pageId, $this->imageName );
		wfSetWikiaPageProp( self::WIKI_HERO_TITLE_PROP_ID, $pageId, $this->title );
		wfSetWikiaPageProp( self::WIKI_HERO_DESCRIPTION_ID, $pageId, $this->description );
	}

	public function getFromProps() {
		$pageId = Title::newFromText( $this->pageName )->getArticleId();

		$this->imageName = wfGetWikiaPageProp( self::WIKI_HERO_IMAGE_PROP_ID, $pageId );
		$this->title = wfGetWikiaPageProp( self::WIKI_HERO_TITLE_PROP_ID, $pageId );
		$this->description = wfGetWikiaPageProp( self::WIKI_HERO_DESCRIPTION_ID, $pageId );

		$this->initializeImagePath( $this->imageName );
	}

	/**
	 * @param $imageName
	 */
	private function initializeImagePath( $imageName ) {
		$imageTitle = Title::newFromText( $imageName, NS_FILE );
		$file = wfFindFile( $imageTitle );
		if ( $file && $file->exists() ) {
			$this->imageName = $imageName;

			$homePageHelper = new WikiaHomePageHelper();

			$this->imagePath = $homePageHelper->getImageUrlFromFile( $file, self::WIKI_HERO_IMAGE_MAX_WIDTH, self::WIKI_HERO_IMAGE_MAX_HEIGHT );
		} else {
			$this->imageName = null;
			$this->imagePath = null;
		}
	}

	public function storeInPage() {
		$pageTitleObj = Title::newFromText( $this->pageName );
		$pageArticleObj = new Article( $pageTitleObj );

		$articleContents = $pageArticleObj->getContent();

		// Remove the original hero text
		$newContent = mb_ereg_replace( '<hero(.*?)/>', '', $articleContents, 'mi' );

		// Prepend the hero tag
		$heroTag = Xml::element('hero', $attribs = [
			'title' => $this->title,
			'description' => $this->description,
			'imagename' => $this->imageName
		]);
		$newContent = $heroTag . PHP_EOL . $newContent;

		// save and purge
		$pageArticleObj->doEdit( $newContent, '' );
		$pageArticleObj->doPurge();

	}
}
