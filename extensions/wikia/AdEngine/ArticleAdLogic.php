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
	const shortArticleThreshold = 650; // what defines a "short" article. # of characters *after* html has been stripped.
	const longArticleThreshold = 3300; // what defines a "long" article. # of characters *after* html has been stripped.
	const superLongArticleThreshold = 10000; // what defines a "super long" article. # of characters *after* html has been stripped.
	const collisionRankThreshold = .15;  // what collison score constitutes a collision. 0-1
	const firstHtmlThreshold = 1500; // Check this much of the html for collision causing tags
	const pixelThreshold = 350; // how many pixels for a "wide" object that will cause a collision, in pixels
	const percentThreshold = 50; // what % of the content is a "wide" table that will cause a collision
	const columnThreshold = 3; // what # of columns is a "wide" table that will cause a collision

	public static function isShortArticle($html){
		$length = strlen(strip_tags($html));
		$out = $length < self::shortArticleThreshold;
		self::adDebug("Article is $length characters. Check for short article is " . var_export($out, true));
		return $out;
	}

	public static function isLongArticle($html){
		$length = strlen(strip_tags($html));
		$out = $length > self::longArticleThreshold;
		self::adDebug("Article is $length characters. Check for long article is " . var_export($out, true));
		return $out;
	}

	public static function isSuperLongArticle($html){
		$length = strlen(strip_tags($html));
		$out = $length > self::superLongArticleThreshold;
		self::adDebug("Article is $length characters. Check for super-long article is " . var_export($out, true));
		return $out;
	}

	/* Note, this comment in the html is filled in by the hook AdEngineMagicWords */
	public static function hasWikiaMagicWord ($html, $word){
		$out = strpos($html, "<!--{$word}-->") !== false; 
		self::adDebug( "Check for $word is ". var_export($out, true));
		return $out;	
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
		if (preg_match_all('/<(table|img|div)[^>]+>/is', $firstHtml, $matches, PREG_OFFSET_CAPTURE)){

			// PHP's preg_match_all return is a PITA to deal with	
			for ($i = 0; $i< sizeof($matches[0]); $i++){
				$wholetag = $matches[0][$i];
				$tag = $matches[1][$i][0];
				if ($tag == 'table' ) $tableFound=true;
					
				$attr = self::getHtmlAttributes($matches[0][$i][0]);

				$tagscore = self::getTagCollisionScore($tag, $attr);
				self::adDebug("Collision score for $tag: $tagscore");
				$score += $tagscore;
			}
		}

		// For tables, check to see if we have a table that has a lot of columns.
		if ( $tableFound ){
			$firstRow = substr($firstHtml, 0, stripos($firstHtml, '</tr>'));
			if (preg_match_all('/<\/[tT][HhDd]>/', $firstRow, $columnMatches)){
				$numColumns = count($columnMatches[0]);
				if ( $numColumns > self::columnThreshold ) {
					self::adDebug("Table with more than columnThreshold columns found ($numColumns)");
					$score += ($numColumns * .2);
				}
			}
		}

		// Score is between 0 and 1, so if it's over 1, reset it to 1
		if ($score > 1) $score = 1;
		$score = round($score, 2);
		self::adDebug("Overall Collision Rank: $score");
		return $score;

	}

	
	/* Find out how naughty a particular tag is.*/
	private function getTagCollisionScore($tag, $attr){
		switch (strtolower($tag)){
		  // The tag itself gets a store
		  case 'table':
			self::adDebug("Table found: " . print_r($attr, true));
		  	if (isset($attr['id']) && $attr['id'] == 'toc') {
				//This table is the Table of Contents and shouldn't cause a collision
				self::adDebug("Table is TOC");
				return 0.02;
			}
			if (isset($attr['width'])){
				self::adDebug("Table has width attribute");
				if ( self::getPixels($attr['width']) >= self::pixelThreshold){
					self::adDebug("Table has width over pixel threshold of " . self::pixelThreshold);
					return .75;
				} else if ( self::getPercentage($attr['width']) >= self::percentThreshold){
					self::adDebug("Table has width over percent threshold of " . self::percentThreshold);
					return .75;
				} else {
					// Seems safe, % is low and pixels are low
					self::adDebug("Table has width, but seems ok");
					return .05;
				}
			} else if (isset($attr['style'])){
				$cssattr=self::getCssAttributes($attr['style']);
				self::adDebug("Table has style attributes of: " . print_r($cssattr, true));

				if (!empty($cssattr['width'])){
					$pixels = self::getPixels($cssattr['width']);
					$percentage = self::getPercentage($cssattr['width']);

					if ($pixels >= self::pixelThreshold){
						self::adDebug("Table has style width over pixel threshold of " . self::pixelThreshold);
						return .75;
					} else if ($percentage >= self::percentThreshold){
						self::adDebug("Table has style width over percent threshold of " . self::percentThreshold);
						return .75;
					} else if ($pixels === false && $percentage === false ) {
						self::adDebug("Table has style width of an unrecognized unit");
						return .10;
					}
				} else {
					// Seems safe, width is not defined via a style
					self::adDebug("Table has style, but seems ok");
					return .05;
				}
			} else if (isset($attr['class'])){
				self::adDebug("Table has class attribute");
				// This table has a class, which may have width defined
				// TOO Strict?
				return .2;
			} else if (isset($attr['id'])){
				self::adDebug("Table has id attribute");
				// This table has an id, which may have css styling and width defined
				// TOO Strict?
				return .15;
			} else {
				// There is a table, but it seems harmless
				self::adDebug("Table seems ok");
				return .05;
			}

		  case 'div':
			self::adDebug("Div found: " . print_r($attr, true));
			if (isset($attr['style'])){
				$cssattr = self::getCssAttributes($attr['style']);
				self::adDebug("Div has style attributes of: " . print_r($cssattr, true));
				if (!empty($cssattr['width'])){
					$pixels = self::getPixels($cssattr['width']);
					$percentage = self::getPercentage($cssattr['width']);

					if ($pixels >= self::pixelThreshold){
						self::adDebug("Div has style width over pixel threshold of " . self::pixelThreshold);
						return .75;
					} else if ($percentage >= self::percentThreshold){
						self::adDebug("Div has style width over percent threshold of " . self::percentThreshold);
						return .75;
					} else if ($pixels === false && $percentage === false ) {
						self::adDebug("Div has style width of an unrecognized unit");
						return .10;
					}
				} else {
					// Has a style with a width, but seems narrow enough
					// Seems safe, % is low and pixels are low
					self::adDebug("Div has style, but no width defined");
					return .025;
				}
			}
			self::adDebug("Div seems harmless");
			return 0;
		    
		  case 'img':
			self::adDebug("Image found: " . print_r($attr, true));
			if (isset($attr['width']) && $attr['width'] >= self::pixelThreshold){
				self::adDebug("Image has width over pixel threshold of " . self::pixelThreshold . ", .75");
				return .75;
			} else if (isset($attr['width'])){
				// Return a value proportional to the size of the image, where a $pixelThreshold wide
				$eachpixel = self::collisionRankThreshold/self::pixelThreshold;
				$out = round(($eachpixel * $attr['width'])/2, 3) ;
				self::adDebug("Image is {$attr['width']} pixels, $out");
				return $out;
			} else {
				self::adDebug("No width set on image, .1");
				return .1;
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

	/* Normalize the pixels. Possible values for 200 pixels include:
	 * 200
	 * 200px
 	 * 20em (yeah, not exact, but close enough)
 	 *
 	 * For any of the values 
 	 */
	public function getPixels($in){
		$in=trim($in);
		if (preg_match('/^[0-9]{1,4}$/', $in)){
			// Nothing bug numbers. 
			return $in;
		} else if (preg_match('/^([0-9]{1,4})px/i', $in, $match)){
			// NNNpx
			return $match[1];
		} else if (preg_match('/^([0-9]{1,4})em/i', $in, $match)){
			return $match[1] * 10;
		} else {
			return false;
		}

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
		static $lastMd5, $lastResult;

		$currentMd5 = md5($html);
		if ($currentMd5 == $lastMd5 ){
			// function was called again with the same html as last time.
			return $lastResult;
		}

	
		if (self::hasWikiaMagicWord($html, "__WIKIA_BANNER__")){
			$result = false;
		} else if (self::hasWikiaMagicWord($html, "__WIKIA_BOXAD__")){
			$result = true;
		} else if (self::getCollisionRank($html) >= self::collisionRankThreshold){
			$result = false;
		} else {
			$result = true;
		}
		
		
		$lastMd5 = $currentMd5;
		$lastResult = $result;
		return $result;
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

	
	public function adDebug($msg){
		if (empty($_GET['adDebug'])){
			return;
		} else {
			$backtrace = debug_backtrace();
			echo "<font color='red'>Ad Debug from {$backtrace[1]['function']}: $msg</font><br />";
		}
		
	}


	/* Function to guess the height, in pixels of the supplied html */
	public function getArticleHeight($html){
		static $lastMd5, $lastResult;

		$currentMd5 = md5($html);
		if ($currentMd5 == $lastMd5 ){
			// function was called again with the same html as last time.
			return $lastResult;
		}

		
		$lastMd5 = $currentMd5;
		$lastResult = $result;
		return $result;
	}

}
