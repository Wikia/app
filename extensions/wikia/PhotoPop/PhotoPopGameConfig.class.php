<?php
/**
 * @author Sean Colombo
 *
 * Simple class for holding the configuration settings for one of the games.
 */

class PhotoPopGameConfig {
	var $gameName;
	var $categoryName;
	var $gameUrl;
	var $iconSrc;
	var $watermarkSrc;

	/**
	 *
	 */
	function __construct($gameName, $category, $wikiPrefix, $iconSrc, $watermarkSrc){
		$this->gameName = $gameName;
		$this->categoryName = $category;
		$this->gameUrl = "http://$wikiPrefix.wikia.com/wikia.php?controller=PhotoPop&method=playGame&category=".urlencode($this->categoryName);
		$this->iconSrc = $iconSrc;
		$this->watermarkSrc = $watermarkSrc;
	} // end __construct()

	
} // end class PhotoPopGameConfig
