<?php
class ScavengerHuntGameArticle {

	protected $title = ''; //:nosetter
	protected $articleId = 0; //:nosetter
	protected $hiddenImage = '';
	protected $hiddenImageTopOffset = 0;
	protected $hiddenImageLeftOffset = 0;


	protected $clueTitle = '';
	protected $clueText = '';
	protected $clueImage = '';
	protected $clueImageTopOffset = 0;
	protected $clueImageLeftOffset = 0;
	protected $clueButtonText = '';
	protected $clueButtonTarget = '';

	public function setTitle( $title ) {
		$this->title = $title;
		$titleObj = WF::build('Title', array($this->title), 'newFromText');
		$this->articleId = $titleObj ? $titleObj->getArticleId() : 0;
	}

	public function setTitleAndId( $title, $articleId ) {
		$this->title = $title;
		$this->aritcleId = $articleId;
	}

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

	public function setHiddenImage( $hiddenImage ) { $this->hiddenImage = $hiddenImage; }
	public function setHiddenImageTopOffset( $hiddenImageTopOffset ) { $this->hiddenImageTopOffset = $hiddenImageTopOffset; }
	public function setHiddenImageLeftOffset( $hiddenImageLeftOffset ) { $this->hiddenImageLeftOffset = $hiddenImageLeftOffset; }
	public function setClueTitle( $clueTitle ) { $this->clueTitle = $clueTitle; }
	public function setClueText( $clueText ) { $this->clueText = $clueText; }
	public function setClueImage( $clueImage ) { $this->clueImage = $clueImage; }
	public function setClueImageTopOffset( $clueImageTopOffset ) { $this->clueImageTopOffset = $clueImageTopOffset; }
	public function setClueImageLeftOffset( $clueImageLeftOffset ) { $this->clueImageLeftOffset = $clueImageLeftOffset; }
	public function setClueButtonText( $clueButtonText ) { $this->clueButtonText = $clueButtonText; }
	public function setClueButtonTarget( $clueButtonTarget ) { $this->clueButtonTarget = $clueButtonTarget; }

	public function getTitle() { return $this->title; }
	public function getArticleId() { return $this->articleId; }
	public function getHiddenImage() { return $this->hiddenImage; }
	public function getHiddenImageTopOffset() { return $this->hiddenImageTopOffset; }
	public function getHiddenImageLeftOffset() { return $this->hiddenImageLeftOffset; }
	public function getClueTitle() { return $this->clueTitle; }
	public function getClueText() { return $this->clueText; }
	public function getClueImage() { return $this->clueImage; }
	public function getClueImageTopOffset() { return $this->clueImageTopOffset; }
	public function getClueImageLeftOffset() { return $this->clueImageLeftOffset; }
	public function getClueButtonText() { return $this->clueButtonText; }
	public function getClueButtonTarget() { return $this->clueButtonTarget; }

	protected function getDataProperties() {
		return array( 'title', 'articleId', 'hiddenImage', 'hiddenImageTopOffset', 'hiddenImageLeftOffset',
			'clueTitle', 'clueText', 'clueImage', 'clueImageTopOffset', 'clueImageLeftOffset', 'clueButtonText',
			'clueButtonTarget' );
	}

	public function getAll() {
		$result = array();
		foreach ($this->getDataProperties() as $varName)
			$result[$varName] = $this->$varName;
		return $result;
	}

	public function setAll( $data ) {
		foreach ($this->getDataProperties() as $varName)
			if (array_key_exists($varName, $data))
				$this->$varName = $data[$varName];
		// special cases
		if (array_key_exists('title', $data) && !array_key_exists('articleId', $data))
			$this->setTitle($data['title']);
	}
}