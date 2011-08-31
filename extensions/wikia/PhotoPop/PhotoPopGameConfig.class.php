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
	 * Constructor to make it quicker to create these inline.
	 *
	 * NOTE: '$category' is expected to start with its prefix. eg: "Category:Characters".
	 */
	function __construct($gameName, $category, $wikiPrefix, $iconSrc, $watermarkSrc, $width=480, $height=320){
		global $wgDevelEnvironment;

		$this->gameName = $gameName;
		$this->categoryName = $category;
		
		// NOTE: If/when we make the game so that any wiki can be added, we'll have to get the URLs differently (might have to look them up in WikiFactory).

		if(empty($wgDevelEnvironment)){
			$sld = "wikia.com"; // second-level domain
		} else {
			$sld = "sean.wikia-dev.com";
		}
		$this->gameUrl = "http://$wikiPrefix.$sld/wikia.php?controller=PhotoPop&method=playGame&category=".urlencode($this->categoryName)."&width=$width&height=$height";

		$this->iconSrc = $iconSrc;
		$this->watermarkSrc = $watermarkSrc;
	} // end __construct()

	
} // end class PhotoPopGameConfig
