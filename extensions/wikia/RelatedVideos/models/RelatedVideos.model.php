<?php

class RelatedVideosElement {
	public $src = '';
	public $height = '';
	public $width = '';
	public $owner = '';
	public $ownerURL = '';
	public $title = '';
	public $fullPath = '';
	public $fullTitle = '';
	public $duration = '';
	public $premium = false;

	function getSrc(){		return $this->src; }
	function getHeight(){		return $this->height; }
	function getWidth(){		return $this->width; }
	function getOwner(){		return $this->owner; }
	function getOwnerURL(){		return $this->ownerURL; }
	function getTitle(){		return $this->title; }
	function getFullPath(){		return $this->fullPath; }
	function getFullTitle(){	return $this->fullTitle; }
	function getDuration(){		return $this->duration; }
	function isPremium(){		return $this->premium; }

	function setSrc( $val ){	$this->src = $val; }
	function setHeight( $val ){	$this->height = $val; }
	function setWidth( $val ){	$this->width = $val; }
	function setOwner( $val ){	$this->owner = $val; }
	function setOwnerURL( $val ){	$this->ownerURL = $val; }
	function setTitle( $val ){	$this->title = $val; }
	function setFullPath( $val ){	$this->fullPath = $val; }
	function setFullTitle( $val ){	$this->fullTitle = $val; }
	function setDuration( $val ){	$this->duration = $val; }
	function setPremium( $val) {	$this->premium = $val; }

	function getFormatedDuration(){

		if ( empty( $this->duration ) ) return '';
		$mins = floor ($this->duration / 60);
		$secs = $this->duration % 60;
		return $mins.':'.$secs;
	}

}