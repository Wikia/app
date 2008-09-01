<?php
/* This script will look at the html of an article and evaluate it for ads, determining attributes like:
 * ) If it is a "short" article that should have no ads at all?
 * ) If it is a "long" article that can have additional ads in the left nav?
 * ) If it it an article with html that will collide with the Box Ad, so it should have a banner instead
 */

$wgExtensionCredits['other'][] = array(
        'name' => 'ArticleAdLogic',
        'author' => 'Nick Sullivan'
);

class ArticleAdLogic {

	// Play with these levels, once we get more test cases.
	const shortArticleThreshold = 1000; // what defines a "short" article. # of characters *after* html has been stripped.
	const longArticleThreshold = 3500; // what defines a "long" article. # of characters *after* html has been stripped.
	const collisionRankThreshold = .15;  // what collison score constitutes a collision. 0-1
	const firstHtmlThreshold = 1500; // Check this much of the html for collision causing tags
	const pixelThreshold = 300; // how many pixels for a "wide" object that will cause a collision, in pixels
	const percentThreshold = 50; // what % of the content is a "wide" table that will cause a collision
	const columnThreshold = 3; // what # of columns is a "wide" table that will cause a collision

	public static function isShortArticle($html){
		return strlen(strip_tags($html)) < self::shortArticleThreshold;
	}

	public static function isLongArticle($html){
		return strlen(strip_tags($html)) > self::longArticleThreshold;
	}

	/* Note, this comment in the html is filled in by the hook AdEngineMagicWords */
	public static function hasWikiaMagicWord ($html, $word){
		return strpos($html, "<!--{$word}-->") !== false; 
	}

	/* Return the likelihood that there is a collision with the Box Ad
 	 * 1 - we are sure there is a collision.
 	 * 0 - we are sure there won't be.
 	 * num in between - we don't know, the higher the number the more likely
 	 *
 	 * Logic:
 	 * Check for a series of things known to cause collision. If found, increase score based
 	 * based on the likelihood of that item causing a collision, ala Mr. Bayes.
 	 */
	public static function getCollisionRank($html){
		$score = 0;

		$firstHtml = substr($html, 0, self::firstHtmlThreshold);

		// Look for html tags that may cause collisions, and evaluate them
		$tableFound = false;
		if (preg_match_all('/<(table|img)[^>]+>/is', $firstHtml, $matches, PREG_OFFSET_CAPTURE)){

			// PHP's preg_match_all return is a PITA to deal with	
			for ($i = 0; $i< sizeof($matches[0]); $i++){
				$wholetag = $matches[0][$i];
				$tag = $matches[1][$i][0];
				if ($tag == 'table' ) $tableFound=true;
					
				$attr = self::getHtmlAttributes($matches[0][$i][0]);

				$score += self::getTagCollisionScore($tag, $attr);
			}
		}

		// For tables, check to see if we have a table that has a lot of columns.
		if ( $tableFound ){
			$firstRow = substr($firstHtml, 0, stripos($firstHtml, '</tr>'));
			if (preg_match_all('/<\/[tT][HhDd]>/', $firstRow, $columnMatches)){
				$numColumns = count($columnMatches[0]);
				if ( $numColumns > self::columnThreshold ) {
					$score += ($numColumns * .2);
				}
			}
		}

		// Score is between 0 and 1, so if it's over 1, reset it to 1
		if ($score > 1) $score = 1;

		return $score;
	}

	
	/* Find out how naughty a particular tag is.*/
	private function getTagCollisionScore($tag, $attr){
		switch (strtolower($tag)){
		  // The tag itself gets a store
		  case 'table':
		  	if (isset($attr['id']) && $attr['id'] == 'toc') {
				//This table is the Table of Contents and shouldn't cause a collision
				return 0;
			}
			if (isset($attr['width'])){
				if ( self::getPixels($attr['width']) >= self::pixelThreshold){
					return .75;
				} else if ( self::getPercentage($attr['width']) >= self::percentThreshold){
					return .75;
				} else {
					// Seems safe, % is low and pixels are low
					return .05;
				}
			} else if (isset($attr['style'])){
				$cssattr=self::getCssAttributes($attr['style']);

				if (!empty($cssattr['width']) && self::getPixels($cssattr['width']) >= self::pixelThreshold){
					return .75;
				} else if (!empty($cssattr['width']) && self::getPercentage($cssattr['width']) >= self::percentThreshold){
					return .75;
				} else if (!empty($cssattr['width'])){
					// Has a style with a width, but seems narrow enough
					return .10;
				} else {
					// Seems safe, % is low and pixels are low
					return .05;
				}
			} else if (isset($attr['class'])){
				// This table has a class, which may have width defined
				return .2;
			} else if (isset($attr['id'])){
				// This table has an id, which may have css styling and width defined
				return .15;
			} else {
				// There is a table, but it seems harmless
				return .05;
			}
		    
		  case 'img':
			if (isset($attr['width']) && $attr['width'] >= self::pixelThreshold){
				return .75;
			} else {
				return .05;
			}

		  default : return 0;
		}
	}



	public function getPercentage($in){
		$out = str_replace('%', '', $in);
		if ($out != $in ){
			return $out;
		} else {
			return false;
		}
	}

	public function getPixels($in){
		$out=preg_replace('/px$/i', '', $in);
		if (intval($out) == $out){
			return $out;
		} else {
			return false;
		}

	}

	/* Based on our collision detection logic, figure out if we are displaying
	 * the leaderboard or the box ad. Return true for box ad, else false.
	 *
	 * Rules:
	 * 1) If magic word WIKIA_BANNER appears, return false
	 * 2) If magic word WIKIA_BOXAD appears, return true
	 * 3) If collisionRank is higher than collisionRankThreshold, return false
	 *
	 * Otherwise, return true.
	 */
	public static function isBoxAdArticle($html){
		if (self::hasWikiaMagicWord($html, "__WIKIA_BANNER__")){
			return false;
		} else if (self::hasWikiaMagicWord($html, "__WIKIA_BOXAD__")){
			return true;
		} else if (self::getCollisionRank($html) >= self::collisionRankThreshold){
			return false;
		} else {
			return true;
		}
	}


	public function isMainPage(){
                global $wgTitle;
                if (is_object($wgTitle)){ 
                        return $wgTitle->getArticleId() == Title::newMainPage()->getArticleId();
                } else {
                        return false;
                }
	}

	public function isArticlePage(){
		global $wgOut;
		if (is_object($wgOut) &&
		    $wgOut->isArticle() &&
		    self::isContentPage()){

			return true;
		} else {
			return false;
		}
	}

	
	public function isContentPage(){
                global $wgTitle;
                if (is_object($wgTitle)){ 
			return in_array($wgTitle->getNamespace(), array(NS_MAIN, NS_IMAGE, NS_CATEGORY)) || $wgTitle->getNamespace() >= 100;	
		} else {
			return false;
		}
	}


	// Do reporting to compare the javascript based collision detection logic with this one
	static public function getCollisionCollision($html) {
		$out = "<script type='text/javascript'>\n";
		if (self::isBoxAdArticle($html)){
			$out .= "var isPhpCollision=false;\n";
		} else {
			$out .= "var isPhpCollision=true;\n";
		}

		$out .= file_get_contents(dirname(__FILE__) . '/collisionCollision.js');
		$out .= "</script>";
		return $out;
	}


	public function isMandatoryAd($slotname){
		/* Ads that always display, even if user is logged in, etc.
  	 	* See http://staff.wikia-inc.com/wiki/DART_Implementation#When_to_show_ads */
		$mandatoryAds = array(
			'HOME_TOP_LEADERBOARD',
			'HOME_TOP_RIGHT_BOXAD'
		);

		// Certain ads always display
		if (AdEngine::getInstance()->getAdType($slotname) == 'spotlight' ||
			in_array($slotname, $mandatoryAds)){
			return true;
		} else {
			return false;
		}	
	}


	public function getCssAttributes($style){
		$pattern = '/([a-zA-Z\-0-9]+)\:([^;]+);/';
		$attr = array();
		$style = trim($style, '; ') . ';';
		if (preg_match_all($pattern, $style, $attmatch)){
			for ($j = 0; $j<sizeof($attmatch[1]); $j++){
				$attr[$attmatch[1][$j]] = $attmatch[2][$j];
			}
		}
		return $attr;
	}	

	
	// Get attributes from html tag.
	// Note, this requires well-formed html with quoted attributes. Second regexp for poor html?
	public function getHtmlAttributes($tag){
		$pattern = '/\s([a-zA-Z]+)\=[\x22\x27]([^\x22\x27]+)[\x22\x27]/';
		$attr = array();
		if (preg_match_all($pattern, $tag, $attmatch)){
			for ($j = 0; $j<sizeof($attmatch[1]); $j++){
				$attr[$attmatch[1][$j]] = $attmatch[2][$j];
			}
		}
		return $attr;
	}

}
