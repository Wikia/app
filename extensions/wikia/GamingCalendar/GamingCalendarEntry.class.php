<?php

class GamingCalendarEntry {
	private $releaseDate;	// timestamp, specified at midnight UTC
	private $gameTitle;
	private $gameSubtitle;
	private $description;
	private $imageSrc;
	private $imageWidth;
	private $systems;
	private $rating;
	private $moreInfoUrl;
	private $preorderUrl;
	
	function __construct($releaseDate) {
		$this->setReleaseDate($releaseDate);
	}
	
	public function getGameTitle() {
		return $this->gameTitle;
	}
	
	public function getGameSubtitle() {
		return $this->gameSubtitle;
	}
	
	public function getReleaseDate() {
		return $this->releaseDate;
	}
	
	public function getSystems() {
		return $this->systems;
	}
	
	public function getRating() {
		return $this->rating;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getImageSrc() {
		return $this->imageSrc;
	}
	
	public function getImageWidth() {
		return $this->imageWidth;
	}
	
	public function getMoreInfoUrl() {
		return $this->moreInfoUrl;
	}
	
	public function getPreorderUrl() {
		return $this->preorderUrl;
	}
	
	public function setReleaseDate($date) {
		$this->releaseDate = $date;
	}
	
	public function setGameTitle($title) {
		$this->gameTitle = $title;
	}
	
	public function setGameSubtitle($subtitle) {
		$this->gameSubtitle = $subtitle;
	}
	
	public function setSystems($systems) {
		$this->systems = $systems;
	}
	
	public function setRating($rating) {
		$this->rating = $rating;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function setImageSrc($url) {
		$this->imageSrc = $url;
	}
	
	public function setImageWidth($pixels) {
		$this->imageWidth = $pixels;
	}
	
	public function setMoreInfoUrl($url) {
		$this->moreInfoUrl = $url;
	}
	
	public function setPreorderUrl($url) {
		$this->preorderUrl = $url;
	}
	
	public function toArray() {
		$elems = array();
		
		$elems['releaseDate'] = $this->releaseDate;
		$elems['gameTitle'] = $this->gameTitle;
		$elems['gameSubtitle'] = $this->gameSubtitle;
		$elems['description'] = $this->description;
		$elems['image'] = array('src'=>$this->imageSrc, 'width'=>$this->imageWidth);
		$elems['systems'] = $this->systems;
		$elems['rating'] = $this->rating;
		$elems['moreInfoUrl'] = $this->moreInfoUrl;
		$elems['preorderUrl'] = $this->preorderUrl;

		return $elems;
	}
	
}