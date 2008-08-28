<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'DART ad provider for AdEngine',
);

class AdProviderDART implements iAdProvider {

	protected static $instance = false;

	protected function __construct(){
		$this->isMainPage = ArticleAdLogic::isMainPage();
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderDART();
		}
		return self::$instance;
	}

	private $sites = array(	'Auto' => 'wka.auto',
							'Creative' => 'wka.crea',
							'Education' => 'wka.edu',
							'Entertainment' => 'wka.ent',
							'Finance' => 'wka.fin',
							'Gaming' => 'wka.gaming',
							'Green' => 'wka.green',
							'Humor' => 'wka.humor',
							'Lifestyle' => 'wka.life',
							'Music' => 'wka.music',
							'Philosophy' => 'wka.phil',
							'Politics' => 'wka.poli',
							'Science' => 'wka.sci',
							'Sports' => 'wka.sports',
							'Technology' => 'wka.tech',
							'Test Site' => 'wka.test',
							'Toys' => 'wka.toys',
							'Travel' => 'wka.travel');

	public function getAd($slotname, $slot){

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

		$url = 'http://ad.doubleclick.net/';
		$url .= $this->getAdType() . '/';
		$url .= $this->getDartSite() . '/';
		$url .= $this->getZone1() . '/';
		$url .= $this->getZone2() . ';';
		$url .= 's1=' . $this->getZone1() . ';'; // this seems redundant
		$url .= 's2=' . $this->getZone2() . ';';
		$url .= $this->getProviderValues($slot);
		$url .= $this->getArticleKV();
		$url .= 'pos=' . $slotname . ';';
		$url .= $this->getKeywordsKV();
		$url .= $this->getDcoptKV($slotname);
		$url .= "sz=" . $slot['size'] . ';';
		$url .= $this->getTileKV($slotname);
		// special "end" delimiter, this is for when we redirect ads to other places. Per Michael
		$url .= 'endtag=$;';
		$url .= "ord="; // See note above, ord MUST be last.

		$out = "<!-- " . __CLASS__ . " slot: $slotname -->";

		$out .= '<script type="text/javascript">/*<![CDATA[*/' . "\n";
		// Only generate the random number once per page. Note we don't want to do this with PHP
		// because it needs to be different for every user, and if it's PHP Varnish/Squid will cache it.
		static $ordGenerated = false;
		if (!$ordGenerated){
			$out .= "var dartRand = Math.floor(Math.random()*99999999);\n";
			$ordGenerated = true;
		}

		// Ug. Heredocs suck, but with all the combinations of quotes, it was the cleanest way.
		$out .= <<<EOT
		document.write("<scr"+"ipt type='text/javascript' src='$url"+dartRand+"'><\/scr"+"ipt>");

EOT;
		$out .= "/*]]>*/</script>\n";

		return $out;
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
		// Someday we may want to change this dynamically.
		return 'adj';
	}

	function getDartSite(){
		global $wgCat;
		if(!empty($wgCat['name'])) {
			if(!empty($this->sites[$wgCat['name']])) {
				return $this->sites[$wgCat['name']];
			}
		}
		return 'wka.wikia';
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
		} else {
			return 'article';
		}
	}

	/* See the DART webmaster guide for a full explanation of DART key values. */
	function getProviderValues($slot){
		if(empty($slot['provider_values'])){
			return '';
		}

		$out='';
		foreach ($slot['provider_values'] as $keyname => $keyvalue){
			$out .= $this->sanitizeKeyName($keyname) . '=' . $this->sanitizeKeyValue($keyvalue) . ';';
		}
		return $out;
	}


	/* See full explanation on limitations in the DART webmaster guide */
	function sanitizeKeyName($keyname){
		$out = preg_replace('/[^a-z0-9A-Z]/', '', $keyname); // alnum only
		$out = preg_replace('/^[0-9]/', '', $out); // not start with a number
		$out = substr($out, 0, 5); // limited to 5 chars

		if ($keyname != $out){
			trigger_error("DART key-name was invalid, changed from '$keyname' to '$out'", E_USER_NOTICE);
		}

		return $out;
	}


	/* See full explanation on limitations in the DART webmaster guide */
	function sanitizeKeyValue($keyvalue){
		$invalids = array('/', '#', ',', '*', '.', '(', ')', '=', '+', '<', '>', '[', ']');
		$out = str_replace($invalids, '', $keyvalue);
		$out = substr($out, 0, 55); // limited to 55 chars

		// Spaces are allowed in key-values only if an escaped character %20 is used, otherwise the key-
		// value will not be funtional.
		// Nick wrote: Retarted. They should just use url-encoding.
		$out = str_replace(' ', '%20 ', $out);

		// The value of a key-value cannot be empty, however, where there
		// are instances where the value is intentionally blank, populate the value with null or some other
		// value indicating a blank, e.g. cat=null
		if ($out == ''){
			$out = 'null';
		}

		if ($keyvalue != $out){
			trigger_error("DART key-value was invalid, changed from '$keyvalue' to '$out'", E_USER_NOTICE);
		}

		return urlencode($out);
	}



	function getTileKV($slotname){
		/* From DART doc:
		 * tile=1 is a parameter that, in conjunction with other sequential tile values on a page, will enable the competitive categories and roadblock features to work. Tile values should match the amount of ads on a given page, but they do not necessarily need to match the order in which the ads appear.													*/
		// Nick wrote: Chose to hard code this for now based on slot, for simplicity
		switch($slotname) {
			case 'TOP_LEADERBOARD': return 'tile=1;';
			case 'TOP_RIGHT_BOXAD': return 'tile=2;';
			case 'LEFT_SKYSCRAPER_1': return 'tile=3;';
			case 'LEFT_SKYSCRAPER_2': return 'tile=3;'; // same so both skyscrapers don't show
			case 'FOOTER_BOXAD': return 'tile=5;';
			case 'HOME_TOP_LEADERBOARD': return 'tile=1;';
			case 'HOME_TOP_RIGHT_BOXAD': return 'tile=2;';
			case 'HOME_LEFT_SKYSCRAPER_1': return 'tile=3;';
			case 'HOME_LEFT_SKYSCRAPER_2': return 'tile=3;';
			default: return '';
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

}
