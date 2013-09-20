<?php
class ScavengerHuntGameArticle {

	protected $title = ''; //:nosetter
	// protected $articleId = 0; //:nosetter
	protected $articleName = ''; //:nosetter
	protected $wikiId = 0; //:nosetter
	protected $hiddenImage = '';
	protected $hiddenImageFound = '';
	protected $hiddenImageTopOffset = 0;
	protected $hiddenImageLeftOffset = 0;

	protected $clueTitle = '';
	protected $clueText = '';
	protected $clueImage = '';
	protected $clueImageTopOffset = 0;
	protected $clueImageLeftOffset = 0;
	protected $inventoryImage = '';
	protected $inventoryImageTopOffset = 0;
	protected $inventoryImageLeftOffset = 0;
	protected $clueButtonText = '';
	protected $clueButtonTarget = '';
	protected $congrats = '';

	protected $spriteNotFound = array();
	protected $spriteInProgressBar = array();
	protected $spriteInProgressBarHover = array();
	protected $spriteInProgressBarNotFound = array();

	public function __construct(){
		$this->spriteNotFound = self::getSpriteTemplate();
		$this->spriteInProgressBar = self::getSpriteTemplate();
		$this->spriteInProgressBarHover = self::getSpriteTemplate();
		$this->spriteInProgressBarNotFound = self::getSpriteTemplate();
	}

	public static function getSpriteTemplate(){
		return array( 'X' => 0, 'Y' => 0, 'X1' => 0, 'Y1' => 0, 'X2' => 0, 'Y2' => 0 );
	}

	public function getSpriteNotFound(){
		return $this->spriteNotFound;
	}

	public function getCongrats(){
		return $this->congrats;
	}

	public function getSpriteInProgressBar(){
		return $this->spriteInProgressBar;
	}

	public function getSpriteInProgressBarHover(){
		return $this->spriteInProgressBarHover;
	}

	public function getSpriteInProgressBarNotFound(){
		return $this->spriteInProgressBarNotFound;
	}

	public function setSpriteNotFound( $sprite ){
		$this->spriteNotFound = $sprite;
	}

	public function setSpriteInProgressBar( $sprite ){
		$this->spriteInProgressBar = $sprite;
	}

	public function setSpriteInProgressBarHover( $sprite ){
		$this->spriteInProgressBarHover = $sprite;
	}

	public function setSpriteInProgressBarNotFound( $sprite ){
		$this->spriteInProgressBarNotFound = $sprite;
	}

	public function setTitle( $title ) {
		$this->title = $title;
		$globalTitleObj = (array) GlobalTitle::explodeURL( $this->title );
		$this->setArticleName( $globalTitleObj['articleName'] );
		$this->setWikiId( $globalTitleObj['wikiId'] );
	}

	public function setWikiId ( $id ){
		$this->wikiId = $id;
	}

	public function setArticleName ( $articleName ) {
		$this->articleName = $articleName;
	}


//	public function setTitleAndId( $title, $articleId ) {
//		$this->title = $title;
//		$this->aritcleId = $articleId;
//	}

	public function getHiddenImageOffset() {
		return array(
			'top' => $this->hiddenImageTopOffset,
			'left' => $this->hiddenImageLeftOffset,
		);
	}

	public function getClueImageOffset() {
		return array(
			'top' => $this->clueImageTopOffset,
			'left' => $this->clueImageLeftOffset,
		);
	}

	public function setHiddenImage( $hiddenImage ) {
		$this->hiddenImage = $hiddenImage;
	}

	public function setHiddenImageFound( $hiddenImageFound ) {
		$this->hiddenImageFound = $hiddenImageFound;
	}

	public function setHiddenImageTopOffset( $hiddenImageTopOffset ) {
		$this->hiddenImageTopOffset = $hiddenImageTopOffset;
	}

	public function setHiddenImageLeftOffset( $hiddenImageLeftOffset ) {
		$this->hiddenImageLeftOffset = $hiddenImageLeftOffset;
	}

	public function setClueTitle( $clueTitle ) {
		$this->clueTitle = $clueTitle;
	}

	public function setClueText( $clueText ) {
		$this->clueText = $clueText;
	}

	public function setClueImage( $clueImage ) {
		$this->clueImage = $clueImage;
	}

	public function setClueImageTopOffset( $clueImageTopOffset ) {
		$this->clueImageTopOffset = $clueImageTopOffset;
	}

	public function setClueImageLeftOffset( $clueImageLeftOffset ) {
		$this->clueImageLeftOffset = $clueImageLeftOffset;
	}

	public function setInventoryImage( $inventoryImage ) {
		$this->inventoryImage = $inventoryImage;
	}

	public function setInventoryImageTopOffset( $inventoryImageTopOffset ) {
		$this->inventoryImageTopOffset = $inventoryImageTopOffset;
	}

	public function setInventoryImageLeftOffset( $inventoryImageLeftOffset ) {
		$this->inventoryImageLeftOffset = $inventoryImageLeftOffset;
	}

	public function setClueButtonText( $clueButtonText ) {
		$this->clueButtonText = $clueButtonText;
	}

	public function setClueButtonTarget( $clueButtonTarget ) {
		$this->clueButtonTarget = $clueButtonTarget;
	}

	public function setCongrats( $text ) {
		$this->contrats = $text;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getArticleName() {
		return $this->articleName;
	}

	public function getHiddenImage() {
		return $this->hiddenImage;
	}

	public function getHiddenImageFound() {
		return $this->hiddenImageFound;
	}

	public function getHiddenImageTopOffset() {
		return $this->hiddenImageTopOffset;
	}

	public function getHiddenImageLeftOffset() {
		return $this->hiddenImageLeftOffset;
	}

	public function getClueTitle() {
		return $this->clueTitle;
	}

	public function getClueText() {
		return $this->clueText;
	}

	public function getClueImage() {
		return $this->clueImage;
	}

	public function getClueImageTopOffset() {
		return $this->clueImageTopOffset;
	}

	public function getClueImageLeftOffset() {
		return $this->clueImageLeftOffset;
	}

	public function getInventoryImage() {
		return $this->inventoryImage;
	}

	public function getInventoryImageTopOffset() {
		return $this->inventoryImageTopOffset;
	}

	public function getInventoryImageLeftOffset() {
		return $this->inventoryImageLeftOffset;
	}

	public function getClueButtonText() {
		return $this->clueButtonText;
	}

	public function getWikiId() {
		return $this->wikiId;
	}

	public function getClueButtonTarget() {
		return $this->clueButtonTarget;
	}

	protected function getDataProperties() {
		return array( 'wikiId', 'articleName', 'title', 'clueText', 'spriteNotFound',
				'spriteInProgressBar', 'spriteInProgressBarHover', 'spriteInProgressBarNotFound', 'congrats'
		);
	}

	public function getAll() {
		$result = array();
		foreach ( $this->getDataProperties() as $varName ) {
			$result[ $varName ] = $this->$varName;
		}
		return $result;
	}

	public function setAll( $data ) {
		foreach ($this->getDataProperties() as $varName)
			if (array_key_exists($varName, $data))
				$this->$varName = $data[$varName];
		// special cases
		if ( array_key_exists('title', $data) )
			$this->setTitle($data['title']);
	}
}
