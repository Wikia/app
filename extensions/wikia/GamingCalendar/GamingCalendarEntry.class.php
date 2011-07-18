<?php

class GamingCalendarEntry {
	private $releaseDate;	// timestamp, specified at midnight UTC
	private $gameTitle;
	private $description;
	private $systems;
	private $moreInfoUrl;
	private $preorderUrl;
	
	function __construct($releaseDate) {
		$this->setReleaseDate($releaseDate);
	}
	
	public function getGameTitle() {
		return $this->gameTitle;
	}
	
	public function getReleaseDate() {
		return $this->releaseDate;
	}
	
	public function getSystems() {
		return $this->systems;
	}
	
	public function getDescription() {
		return $this->description;
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
	
	public function setSystems($systems) {
		$this->systems = $systems;
	}
	
	public function setDescription($description) {
		$this->description = $description;
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
		$elems['description'] = $this->description;
		$elems['systems'] = $this->systems;
		$elems['moreInfoUrl'] = $this->moreInfoUrl;
		$elems['preorderUrl'] = $this->preorderUrl;

		return $elems;
	}
	
}