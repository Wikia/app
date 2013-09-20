<?php
/**
 * @since 2.0
 */
abstract class MapsBaseElement implements iBubbleMapElement , iLinkableMapElement {

	protected $title;
	protected $text;
	protected $link;

	public function getTitle() {
		return $this->title;
	}

	public function setTitle( $title ) {
		$this->title = trim($title);
	}

	public function getText() {
		return $this->text;
	}

	public function setText( $text ) {
		$this->text = trim($text);
	}

	public function getLink() {
		return $this->link;
	}

	public function setLink( $link ) {
		$this->link = trim($link);
	}

	public function hasTitle() {
		return !is_null($this->title) && $this->title !== '';
	}

	public function hasText() {
		return !is_null($this->text) && $this->text !== '';
	}

	public function getJSONObject( $defText = '' , $defTitle = '' ) {
		return array(
			'text' => $this->hasText() ? $this->getText() : $defText ,
			'title' => $this->hasTitle() ? $this->getTitle() : $defTitle ,
			'link' => $this->getLink() ,
		);
	}
}
