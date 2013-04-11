<?php

class AdProviderDART extends AdProviderIframeFiller implements iAdProvider {

	public $enable_lazyload = true;
	private $isMainPage, $useIframe = false;

	protected static $instance = false;

	protected function __construct() {
		$this->isMainPage = WikiaPageType::isMainPage();
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderDART();
		}
		return self::$instance;
	}

	private $slotsToCall = array();
	public function addSlotToCall($slotname) {
		$this->slotsToCall[]=$slotname;
	}

  public function batchCallAllowed(){ return false; }
  public function getSetupHtml(){ return false; }
  public function getBatchCallHtml(){ return false; }

	public function getAd($slotname, $slot, $params = null) {
		wfProfileIn(__METHOD__);

		$url = $this->getUrl($slotname, $slot);
		
		$out = "<!-- " . __CLASS__ . " slot: $slotname -->";
		$out .= '<script type="text/javascript">/*<![CDATA[*/' . "\n";
		// Ug. Heredocs suck, but with all the combinations of quotes, it was the cleanest way.
		$out .= <<<EOT
		dartUrl = "$url";
EOT;
		if ($params['ghostwriter']) {
			$out .= <<<EOT
			ghostwriter(
				document.getElementById('$slotname'),
				{
					insertType: "append",
					script: { src: dartUrl },
					done: function() { 
						ghostwriter.flushloadhandlers();
					}
				}
			);
EOT;
		} else {
			$out .= <<<EOT
			document.write("<scr"+"ipt type='text/javascript' src='"+ dartUrl +"'><\/scr"+"ipt>");
EOT;
		}
		$out .= "/*]]>*/</script>\n";
		
		wfProfileOut(__METHOD__);
		
		return $out;
	}
	
	/**
	 * wlee 2011/01/28
	 * With the advent of AdConfig.js, this function is no longer maintained.
	 * All DART URL development should be done in AdConfig.js only.
	 *
	 * Wikia's standard invocation of DART, in an iframe, has been changed to
	 * use AdConfig.js.
	 *
	 * This function exists only to support AdProviderDART::getAd() [the JS
	 * invocation of DART]. As of this date, there is no good reason to call getAd().
	 * I hope that we can someday deprecate getAd() this function, and all
	 * the helper functions involved in creating the DART url.
	 */
	public function getUrl($slotname, $slot){
		wfProfileIn(__METHOD__);

		// Manipulate DART sizes for values it expects
		switch ($slot['size']){
		  case '300x250': $slot['size'] = '300x250,300x600'; break;
		  case '600x250': $slot['size'] = '600x250,300x250'; break;
           	  case '728x90': $slot['size'] = '728x90,468x60'; break;
                  case '160x600': $slot['size'] = '160x600,120x600'; break;
                  case '0x0': $slot['size'] = '1x1'; break;
		}
			

		/* Nick wrote: Note, be careful of the order of the key values. From Dart Webmaster guide:
		 * 	Order of multiple key-values in DART ad tags:  For best performance, DoubleClick recommends
		 * 	that reserved key-values be placed as the last attributes in the DART ad tags, after any custom key-
		 * 	values. In particular, the following key-values must be used in the following order:
 		 * 	sz=widthxheight
		 * 	tile=value or ptile=value
		 * 	ord=value
		 * 	The ord=value key-value must be the last attribute in the DART ad tag.
		 *
		 * 	Note that we also have an "endtag", which slightly contradicts the above, but apparently that's ok.
		 * 	endtag=$ is for forwarding requests to other DART ad networks, ala Gamepro.
		 */
		static $rand;
		if (empty($rand)){
			// This should be the same for every ad on the page
			$rand = mt_rand();
		}
		global $wgTitle;
		if (is_object($wgTitle) && method_exists($wgTitle, 'getText')){
			$wpage = 'wpage=' . str_replace(array("%27", "%22", "%3b"), "_", $wgTitle->getPartialURL()) . ';';
		} else {
			$wpage = '';
		}

		$src = 'direct';
		$tile = $this->getTileKV($slotname);
		$mtfIFPath = '';
		$ord = $rand;
		if (AdEngine::getInstance()->getProviderNameForSlotname($slotname) == 'AdDriver') {
			$src = 'driver';
			$tile = 'tile=N;';
			$ord = 'N';
		}
		else {
			$mtfIFPath .= 'mtfIFPath=/extensions/wikia/AdEngine/;';  // http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=117857, http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=117427
		}

		$url = 'http://ad.doubleclick.net/';
		$url .= $this->getAdType() . '/';
		$url .= $this->getFirstChunk() . ';';
		$url .= 's1=' . $this->getZone1() . ';'; // this seems redundant
		$url .= 's2=' . $this->getZone2() . ';';
		$url .= $this->getProviderValues($slot);
		$url .= $this->getArticleKV();
		$url .= $this->getDomainKV($_SERVER['HTTP_HOST']);
		$url .= 'pos=' . $slotname . ';';
		$url .= $wpage;
		$url .= $this->getKeywordsKV();
		$url .= 'dis=N;'; // screen resolution (used only by AdDriver)
		$url .= 'hasp=N;'; // page has prefooter ads? (used only by AdDriver)
		$url .= "qcseg=N;";	// wlee: placeholder for JS that sets the real key-value. See self::getIframeFillFunctionDefinition()
		$url .= "impct=N;";	// impression count for current session (used only by AdDriver)
		$url .= $this->getLocKV($slotname);
		$url .= $this->getDcoptKV($slotname);
		$url .= $mtfIFPath;
		$url .= "src=$src;";
		$url .= "sz=" . $slot['size'] . ';';
		$url .= 'mtfInline=true;';  // http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220
		$url .= $tile;
		// special "end" delimiter, this is for when we redirect ads to other places. Per Michael
		$url .= 'endtag=$;';
		$url .= "ord=" . $ord . "?"; // See note above, ord MUST be last. Also note that DART told us to put the ? at the end
		
		wfProfileOut(__METHOD__);
		
		return $url;
	}

	/* From DART Webmaster guide:
	 * ad - For a standard image-based ad.
	 * adf - In a frame.
	 * adl - In a layer.
	 * adi - In an iframe.
	 * adj - Served using JavaScript.
	 * adx - Served using streaming technologies.
	 */
	function getAdType(){
		if ($this->useIframe) {
			return 'adi';
		} else {
			return 'adj';
		}
	}


	function getFirstChunk() {
		$first_chunk = $this->getDartSite($this->getHub()) . '/' .
				$this->getZone1() . '/' .
				$this->getZone2(); 

		wfRunHooks("AdProviderDARTFirstChunk", array(&$first_chunk));

		return $first_chunk;
	}
	

	function getDartSite($hub){
			return 'wka.' . $hub;
	}

	function getHub() {
		$cat = AdEngine2Controller::getCachedCategory();
		return $cat['short'];
	}

	// Effectively the dbname, defaulting to wikia.
	function getZone1(){
		global $wgDBname;
		// Zone1 is prefixed with "_" because zone's can't start with a number, and some dbnames do.
		if(empty($wgDBname)) {
			return '_wikia';
		} else {
			return '_' . preg_replace('/[^0-9A-Z_a-z]/', '_', $wgDBname);
		}
	}

	// Page type, ie, "home" or "article"
	function getZone2(){
		if($this->isMainPage) {
			return 'home';
		} elseif (WikiaPageType::isSearch()) {
			return 'search';
		} else {
			return 'article';
		}
	}

	/* See the DART webmaster guide for a full explanation of DART key values. */
	function getProviderValues($slot){
		wfProfileIn(__METHOD__);

                if(empty($slot['provider_values']) || !is_array($slot['provider_values'])){
			wfProfileOut(__METHOD__);
			return '';
		}

		$out='';
		foreach ($slot['provider_values'] as $kvpair){
			$out .= $this->sanitizeKeyName($kvpair['keyname']) . '=' . $this->sanitizeKeyValue($kvpair['keyvalue']) . ';';
		}

		wfProfileOut(__METHOD__);

		return $out;
	}


	/* See full explanation on limitations in the DART webmaster guide */
	function sanitizeKeyName($keyname){
		wfProfileIn(__METHOD__);

		$out = preg_replace('/[^a-z0-9A-Z]/', '', $keyname); // alnum only
		$out = preg_replace('/^[0-9]/', '', $out); // not start with a number
		$out = substr($out, 0, 5); // limited to 5 chars

		if ($keyname != $out){
		//	trigger_error("DART key-name was invalid, changed from '$keyname' to '$out' for {$_SERVER['REQUEST_URI']}", E_USER_NOTICE);
		}
		
		wfProfileOut(__METHOD__);

		return $out;
	}


	/* See full explanation on limitations in the DART webmaster guide */
	function sanitizeKeyValue($keyvalue){
		wfProfileIn(__METHOD__);

		$invalids = array('/', '#', ',', '*', '.', '(', ')', '=', '+', '<', '>', '[', ']');
		$out = str_replace($invalids, '', $keyvalue);
		$out = substr($out, 0, 55); // limited to 55 chars

		// Spaces are allowed in key-values only if an escaped character %20 is used, otherwise the key-
		// value will not be funtional.
		// Nick wrote: Retarted. They should just use url-encoding.
		// UPDATE: Michael says that even though this is valid in the spec, it causes problems in the UI
		$out = str_replace(' ', '', $out);

		// The value of a key-value cannot be empty, however, where there
		// are instances where the value is intentionally blank, populate the value with null or some other
		// value indicating a blank, e.g. cat=null
		if ($out == ''){
			$out = 'null';
		}

		if ($keyvalue != $out){
		//	trigger_error("DART key-value was invalid, changed from '$keyvalue' to '$out' for {$_SERVER['REQUEST_URI']}", E_USER_NOTICE);
		}
		
		wfProfileOut(__METHOD__);

		return urlencode($out);
	}



	function getTileKV($slotname){
		/* From DART doc:
		 * tile=1 is a parameter that, in conjunction with other sequential tile values on a page, will enable the competitive categories and roadblock features to work. Tile values should match the amount of ads on a given page, but they do not necessarily need to match the order in which the ads appear.													*/
		// Nick wrote: Chose to hard code this for now based on slot, for simplicity
		switch($slotname) {
			case 'TOP_RIGHT_BOXAD': return 'tile=1;';
			case 'TOP_LEADERBOARD': return 'tile=2;';
			case 'LEFT_SKYSCRAPER_1': return 'tile=3;';
			case 'LEFT_SKYSCRAPER_2': return 'tile=3;'; // same so both skyscrapers don't show. Note: This isn't working.
			case 'LEFT_SKYSCRAPER_3': return 'tile=6;'; 
			case 'FOOTER_BOXAD': return 'tile=5;';
			case 'HOME_TOP_RIGHT_BOXAD': return 'tile=1;';
			case 'HOME_TOP_LEADERBOARD': return 'tile=2;';
			case 'CORP_TOP_RIGHT_BOXAD': return 'tile=1;';
			case 'CORP_TOP_LEADERBOARD': return 'tile=2;';
			default: return '';
		}
	}

	function getLocKV($slotname){
		switch ($slotname){
		  case 'TOP_RIGHT_BOXAD': return "loc=top;";
		  case 'TOP_LEADERBOARD': return "loc=top;";
		  case 'LEFT_SKYSCRAPER_1': return "loc=top;";
		  case 'LEFT_SKYSCRAPER_2': return "loc=middle;";
		  case 'LEFT_SKYSCRAPER_3': return "loc=middle;";
		  case 'FOOTER_BOXAD': return "loc=footer;";
		  case 'PREFOOTER_LEFT_BOXAD': return "loc=footer;";
		  case 'PREFOOTER_RIGHT_BOXAD': return "loc=footer;";
		  case 'HOME_TOP_RIGHT_BOXAD': return "loc=top;";
		  case 'HOME_TOP_LEADERBOARD': return "loc=top;";
		  case 'CORP_TOP_RIGHT_BOXAD': return "loc=top;";
		  case 'CORP_TOP_LEADERBOARD': return "loc=top;";
		  case 'INCONTENT_BOXAD_1': return "loc=middle;";
		  case 'INCONTENT_BOXAD_2': return "loc=middle;";
		  case 'INCONTENT_BOXAD_3': return "loc=middle;";
		  case 'INCONTENT_BOXAD_4': return "loc=middle;";
		  case 'INCONTENT_BOXAD_5': return "loc=middle;";
		  case 'INCONTENT_LEADERBOARD_1': return "loc=middle;";
		  case 'INCONTENT_LEADERBOARD_2': return "loc=middle;";
		  case 'INCONTENT_LEADERBOARD_3': return "loc=middle;";
		  case 'INCONTENT_LEADERBOARD_4': return "loc=middle;";
		  case 'INCONTENT_LEADERBOARD_5': return "loc=middle;";
		  case 'EXIT_STITIAL_BOXAD_1': return "loc=exit;";
		  case 'SPECIAL_INTERSTITIAL': return "loc=top;";
		  case 'MODAL_VERTICAL_BANNER': return "loc=modal;";
		  default: return "";
		}
	}

	function getDcoptKV($slotname){
		/* From DART doc:
			dcopt=ist is a parameter that enables interstitial ad types to run.
			This should only be included in the top tag on each page.
		*/
		// Nick wrote: Chose to hard code this for now based on slot, for simplicity
		switch ($slotname){
			case 'TOP_LEADERBOARD': return 'dcopt=ist;';
			case 'HOME_TOP_LEADERBOARD': return 'dcopt=ist;';
			case 'CORP_TOP_LEADERBOARD': return 'dcopt=ist;';
			default: return '';
		}
	}

	/* If the user did a search, return the term for keyword targeting.
	 * If no search was done, false is returned.
	 * Note that this is raw input from the user, and should be escaped.
	 * NOTE: We don't currently have ads on the search results pages, so this isn't used right now.
	 */
	public function getKeywordsKV(){
		if(!empty($_GET['search'])){
			return 'kw=' . $this->sanitizeKeyValue($_GET['search']) . ';';
		} else {
			return '';
		}
	}

	// Title is one of the always-present key-values
	public function getArticleKV(){
		global $wgTitle;
		if (is_object($wgTitle)){
			return "artid=" . $wgTitle->getArticleID() . ';';
		} else {
			return '';
		}
	}

	/* We need a way to target based on domain.
 	 * "dom" was a reserved value, so "dmn" is what I decided to use for the key.
	 *
	 *  The end value will look like this:
	 *  pages on wowwiki.com - dmn=wowwikicom
	 *  pages on muppet.wikia.com - dmn=wikiacom
	 *
	 *  It's tricky to parse Top level domains, because of examples like .co.uk
	 *  http://en.wikipedia.org/wiki/List_of_Internet_top-level_domains
	 */
	public function getDomainKV($host){
		wfProfileIn(__METHOD__);

		$lhost=strtolower($host);
		if (!preg_match('/([a-z\-0-9]+)\.([a-z]{2,6})$/', $lhost, $match1)){
			wfProfileOut(__METHOD__);
			return false;
		}

		// Yuck. Got a better idea?
		if ($match1[1] == 'co'){
			// .co.uk or .co.jp
			if (!preg_match('/([a-z\-0-9]+)\.co\.([a-z]{2})$/', $lhost, $match2)){
				wfProfileOut(__METHOD__);
				return false;
			} else {
				wfProfileOut(__METHOD__);				
				return 'dmn=' . $this->sanitizeKeyValue($match2[0]) . ';';
			}
		}

		wfProfileOut(__METHOD__);
		return 'dmn=' . $this->sanitizeKeyValue($match1[0]) . ';';
	}

	/**
	 * wlee 2011/01/28
	 * This function has been updated to use AdConfig.js, the new single place 
	 * for DART url configuration.
	 */
	protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) {
		$this->useIframe = true; 
		
		// RT #65988: must clone iframe, set src then append to parentNode. Setting src on original iframe creates unnecessary entry in browser history
		$out = '<script type="text/javascript">' .
		$function_name . ' = function() { ' .
		'if(typeof(AdEngine) != "undefined") { ' .
			'if(AdEngine.hiddenSlotOnShortPage("' . addslashes($slotname) .'")) { return; }' .
		'} ' .
		"var url = AdConfig.DART.getUrl('$slotname', '{$slot['size']}', true, 'DART');\n" .
		'var ad_iframeOld = document.getElementById("' . addslashes($slotname) ."_iframe\"); " . "\n" .
		'if (typeof ad_iframeOld == "undefined") { return; } ' . "\n" .
		"var parent_node = ad_iframeOld.parentNode; ad_iframe = ad_iframeOld.cloneNode(true); " . "\n" .
		'ad_iframe.src = url; ' . "\n" .
		"parent_node.removeChild(ad_iframeOld); parent_node.appendChild(ad_iframe); }</script>";

		return $out;
	}

}

