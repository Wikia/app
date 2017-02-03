<?php

class WdsLogoModule {
	public $type = 'logo';
	public $main;
	public $tagLine;

	public function setMain( WdsLinkImage $main ) {
		$this->main = $main;

		return $this;
	}

	public function setTagLine( WdsLinkImage $tagLine ) {
		$this->tagLine = $tagLine;

		return $this;
	}
}
