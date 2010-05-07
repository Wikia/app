<?php

/**
 * @package MediaWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: Classes.php 6127 2007-10-11 11:10:32Z eloy $
 */

$wgAjaxExportList[] = 'WikiaAssets::combined';

class WikiaAssets {

	private static function GetBrowserSpecificCSS() {
		global $wgStylePath;

		$references = array();

		$references[] = array(
			'url' => 'skins/monaco/css/monaco_ltie7.css',
			'cond' => 'if lt IE 7',
			'browser' => 'IElt7');

		$references[] = array(
			'url' => 'skins/monaco/css/monaco_ie7.css',
			'cond' => 'if IE 7',
			'browser' => 'IEeq7');

		$references[] = array(
			'url' => 'skins/monaco/css/monaco_ie8.css',
			'cond' => 'if IE 8',
			'browser' => 'IEeq8');

		return $references;
	}

	public static function combined() {
		global $wgRequest, $wgStylePath, $wgStyleVersion;

		$type = $wgRequest->getVal('type');

		if($type == 'CoreCSS') {

			$themename = $wgRequest->getVal('themename');
			$browser = $wgRequest->getVal('browser');

			$wgRequest->setVal('allinone', true);
			$staticChute = new StaticChute('css');
			$staticChute->useLocalChuteUrl();
			if($themename != 'custom' && $themename != 'sapphire') {
				$staticChute->setTheme($themename);
			}

			preg_match("/href=\"([^\"]+)/", $staticChute->getChuteHtmlForPackage('monaco_css'), $matches);

			$references = array();
			global $wgServer;
			$references[] = array('url' => str_replace($wgServer.'/', '', $matches[1]));

			$references = array_merge($references, WikiaAssets::GetBrowserSpecificCSS());

			$out = '';

			foreach($references as $reference) {
				if(isset($reference['browser']) && $reference['browser'] != $browser) {
					continue;
				}
				if(strpos($reference['url'], '?') === false) {
					$reference['url'] .= '?'.$wgStyleVersion;
				} else {
					$reference['url'] .= '&'.$wgStyleVersion;
				}
				$out .= '/* Call to: '.$reference['url'].' */'."\n\n";
				$out .= '<!--# include virtual="'.$reference['url'].'" -->';
			}
		} else if($type == 'SiteCSS') {
			$out = '';
			$themename = $wgRequest->getVal('themename');
			$cb = $wgRequest->getVal('cb');
			$ref = WikiaAssets::GetSiteCSSReferences($themename, $cb);
			foreach($ref as $reference) {
				$out .= '/* Call to: '.$reference['url'].' */'."\n\n";
				$out .= '<!--# include virtual="'.$reference['url'].'" -->';
			}
		} else if($type == 'CoreJS') {
			header('Content-type: text/javascript');
			header('Cache-Control: max-age=2592000, public');

			$references = array();

			// static chute
			global $wgServer;
			$wgRequest->setVal('allinone', true);
			$staticChute = new StaticChute('js');
			$staticChute->useLocalChuteUrl();
			preg_match_all("/src=\"([^\"]+)/", $staticChute->getChuteHtmlForPackage('monaco_anon_article_js'), $matches, PREG_SET_ORDER);
			foreach($matches as $script) {
				$references[] = str_replace($wgServer.'/', '/', $script[1]);
			}

			// optinal yui
			if($wgRequest->getBool('yui', false)) {
				preg_match_all("/src=\"([^\"]+)/", $staticChute->getChuteHtmlForPackage('yui'), $matches, PREG_SET_ORDER);
				foreach($matches as $script) {
					$references[] = str_replace($wgServer.'/', '/', $script[1]);
				}
			}

			// -
			$references[] = Skin::makeUrl('-', "action=raw&gen=js&useskin=monaco");

			$out = '';
			foreach($references as $reference) {
				$out .= '<!--# include virtual="'.$reference.'" -->';
			}
			echo $out;
			exit();
		}

		header('Content-type: text/css');
		header('Cache-Control: max-age=2592000, public');
		echo $out;
		exit();
	}

	/**
	 * The optional cache-buster can be used to get around the current problems where purges are behind.
	 */
	private function GetSiteCSSReferences($themename, $cb = "") {
		$cssReferences = array();
		global $wgSquidMaxage;
		$siteargs = array(
			'action' => 'raw',
			'maxage' => $wgSquidMaxage,
		);
		$query = wfArrayToCGI( array(
			'usemsgcache' => 'yes',
			'ctype' => 'text/css',
			'smaxage' => $wgSquidMaxage,
			'cb' => $cb
		) + $siteargs );

		// We urldecode these now because nginx does not expect them to be URL encoded.
		$cssReferences[] = array('url' => urldecode(Skin::makeNSUrl('Common.css', $query, NS_MEDIAWIKI)));

		if(empty($themename) || $themename == 'custom' ) {
			$cssReferences[] = array('url' => urldecode(Skin::makeNSUrl('Monaco.css', $query, NS_MEDIAWIKI)));
		}

		$siteargs['gen'] = 'css';
		$siteargs['useskin'] = 'monaco';
		$cssReferences[] = array('url' => urldecode(Skin::makeUrl( '-', wfArrayToCGI( $siteargs ) )));

		return $cssReferences;
	}

	public static function GetExtensionsCSS($styles) {
		// exclude user and site css
		foreach($styles as $style => $options) {
			if(strpos($style, ':Common.css') > 0
				|| strpos($style, ':Monaco.css') > 0
				|| strpos($style, 'title=User:') > 0
				|| strpos($style, 'title=-')) {
				unset($styles[$style]);
			}
		}

		$out = "\n<!-- GetExtensionsCSS -->";
		$tmpOut = new OutputPage();
		$tmpOut->styles = $styles;

		return $out . $tmpOut->buildCssLinks();
	}

	public static function GetUserCSS($styles) {
		foreach($styles as $style => $options) {
			if(strpos($style, 'title=User:') > 0) {
				continue;
			}
			if(strpos($style, 'title=-') > 0 && strpos($style, 'ts=') > 0) {
				continue;
			}
			unset($styles[$style]);
		}

		$out = "\n<!-- GetUserCSS -->";
		$tmpOut = new OutputPage();
		$tmpOut->styles = $styles;

		return $out . $tmpOut->buildCssLinks();
	}

	public static function GetSiteCSS($themename, $isRTL, $isAllInOne) {
		$out = "\n<!-- GetSiteCSS -->";

		if($isAllInOne) {
			global $parserMemc, $wgStyleVersion;
			$cb = $parserMemc->get(wfMemcKey('wgMWrevId'));
			if(empty($cb)) {
				$cb = 1;
			}

			global $wgDevelEnvironment;
			if(empty($wgDevelEnvironment)){
				$prefix = "__wikia_combined/";
			} else {
				global $wgWikiaCombinedPrefix;
				$prefix = $wgWikiaCombinedPrefix;
			}
			global $wgScriptPath;
			$url = $wgScriptPath."/{$prefix}cb={$cb}{$wgStyleVersion}&type=SiteCSS&themename={$themename}&rtl={$isRTL}";
			$out .= '<link rel="stylesheet" type="text/css" href="'.$url.'" />';
		} else {
			$ref = WikiaAssets::GetSiteCSSReferences($themename);
			foreach($ref as $reference) {
				$out .= '<link rel="stylesheet" type="text/css" href="'.$reference['url'].'" />';
			}
		}

		return $out;
	}

	public static function GetThemeCSS($skin) {
		global $wgDevelEnvironment, $wgStylePath;
		
		if($skin->themename == 'custom' || $skin->themename == 'sapphire') {
				return null;
		}
		
		if(empty($wgDevelEnvironment)) {
			$start = "http://images1.wikia.nocookie.net/common";
		} else {
			$start = "";
		}
		return "\n".'<!-- GetThemeCSS --><link rel="stylesheet" type="text/css" href="'. $wgStylePath .'/'. $skin->skinname .'/' . $skin->themename . '/css/main.css" />';
	}

	public static function GetCoreCSS($themename, $isRTL, $isAllInOne) {

		if($isAllInOne) {

			global $wgStyleVersion;

			global $wgDevelEnvironment;
			if(empty($wgDevelEnvironment)){
				$prefix = "__wikia_combined/";
			} else {
				global $wgWikiaCombinedPrefix;
				$prefix = $wgWikiaCombinedPrefix;
			}
			$commonPart = "http://images1.wikia.nocookie.net/{$prefix}cb={$wgStyleVersion}&type=CoreCSS&themename={$themename}&rtl={$isRTL}&StaticChute=";

			$out = "\n<!-- GetCoreCSS -->";
			$out .= "\n".'<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.$commonPart.'&browser=IElt7" /><![endif]-->';
			$out .= "\n".'<!--[if IE 7]><link rel="stylesheet" type="text/css" href="'.$commonPart.'&browser=IEeq7" /><![endif]-->';
			$out .= "\n".'<!--[if IE 8]><link rel="stylesheet" type="text/css" href="'.$commonPart.'&browser=IEeq8" /><![endif]-->';
			$out .= "\n".'<!--[if !IE]>--><link rel="stylesheet" type="text/css" href="'.$commonPart.'&browser=notIE" /><!--<![endif]-->';

			return $out;

		} else {

			global $wgRequest, $wgStylePath, $wgStyleVersion;

			$wgRequest->setVal('allinone', false);

			$staticChute = new StaticChute('css');
			$staticChute->useLocalChuteUrl();
			if($themename != 'custom' && $themename != 'sapphire') {
				$staticChute->setTheme($themename);
			}

			$references = array();

			preg_match_all("/url\(([^?]+)/", $staticChute->getChuteHtmlForPackage('monaco_css'), $matches);
			foreach($matches[1] as $match) {
				$references[] = array('url' => $match);
			}

			$references = array_merge($references, WikiaAssets::GetBrowserSpecificCSS());

			$out = "\n<!-- GetCoreCSS -->";
			$out .= '<style type="text/css">';
			foreach($references as $reference) {
				if(isset($reference['cond'])) {
					$out .='<!--['.$reference['cond'].']';
				}
				$out .= '@import url('.$reference['url'].'?'.$wgStyleVersion.');';
				if(isset($reference['cond'])) {
					$out .='<![endif]-->';
				}
			}
			$out .= '</style>';

			return $out;
		}

	}

}

/*
 * hooks
 */
$wgHooks['SpecialRecentChangesLinks'][] = "Wikia::addRecentChangesLinks";
$wgHooks['SpecialRecentChangesQuery'][] = "Wikia::makeRecentChangesQuery";
$wgHooks['SpecialPage_initList'][] = "Wikia::disableSpecialPage";
$wgHooks['UserRights'][] = "Wikia::notifyUserOnRightsChange";
$wgHooks['SetupAfterCache'][] = "Wikia::setupAfterCache";
//$wgHooks['RawPageViewBeforeOutput'][] = 'Wikia::rawPageViewBeforeOutput';
/**
 * This class have only static methods so they can be used anywhere
 *
 */

class Wikia {

	private static $vars = array();

	public static function setVar($key, $value) {
		Wikia::$vars[$key] = $value;
	}

	public static function getVar($key) {
		return isset(Wikia::$vars[$key]) ? Wikia::$vars[$key] : null;
	}

	public static function isVarSet($key) {
		return isset(Wikia::$vars[$key]);
	}

	public static function unsetVar($key) {
		unset(Wikia::$vars[$key]);
	}


	public static function rawPageViewBeforeOutput(&$self, &$text) {
		if ( $self->ctype == "text/css" ) {
			$text = strip_tags($text);
		}
		return true;
	}


	/**
	 * @author inez@wikia.com
	 */
	function getThemesOfSkin($skinname = 'quartz') {
		global $wgSkinTheme;

		$themes = array();

		if(isset($wgSkinTheme) && is_array($wgSkinTheme) && isset($wgSkinTheme[$skinname])) {
			foreach($wgSkinTheme[$skinname] as $val) {
				if( $val != 'custom' && ! (isset($wgSkipThemes) && is_array($wgSkipThemes) && isset($wgSkipThemes[$skinname]) && in_array($wgSkipThemes[$skinname],$val))) {
					$themes[] = $val;
				}
			}
		}

		return $themes;
	}



    /**
     * successbox
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $what message for user
     *
     * @return string composed HTML/XML code
     */
    static public function successbox($what) {
        return Xml::element( "div", array(
				"class"=> "successbox", "style" => "margin: 0;margin-bottom: 1em;"
			), $what)
			. Xml::element("br", array( "style" => "clear: both;"));
    }

    /**
     * errorbox
     *
     * return div with error message
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $what message for user
     *
     * @return string composed HTML/XML code
     */
    static public function errorbox($what) {
        return Xml::element( "div", array(
				"class"=> "errorbox", "style" => "margin: 0;margin-bottom: 1em;"
			), $what )
			. Xml::element("br", array( "style" => "clear: both;"));
    }

    /**
     * errormsg
     *
     * return span for error message
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $what message for user
     *
     * @return string composed HTML/XML code
     */
    static public function errormsg($what)
    {
        return Xml::element("span", array( "style"=> "color: #fe0000; font-weight: bold;"), $what);
    }

    /**
     * link
     *
     * return XML/HTML code with link
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $url: message for user
     * @param string $title: link body
     * @param mixed $attribs default null: attribbs for tag
     *
     * @todo safety checking
     *
     * @return string composed HTML/XML code
     */
    static public function link($url, $title, $attribs = null )
    {
        return XML::element("a", array( "href"=> $url), $title);
    }

    /**
     * successmsg
     *
     * return span for success message
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $what message for user
     *
     * @return string composed HTML/XML code
     */
    static public function successmsg($what)
    {
        return Xml::element("span", array( "style"=> "color: darkgreen; font-weight: bold;"), $what);
    }

    /**
     * fixDomainName
     *
     * It takes domain name as param, then checks if it contains more than one
     * dot, then depending on that information adds .wikia.com domain or not.
     * Additionally it lowercase name
     *
     * @access public
     * @static
     * @author eloy@wikia-inc.com
     *
     * @param string $name Domain Name
     * @param string $language default false - choosen language
     * @param mixed  $type type of domain, default false = wikia.com
     *
     * @return string fixed domain name
     */
	static public function fixDomainName( $name, $language = false, $type = false ) {
		if (empty( $name )) {
			return $name;
		}

		$name = strtolower( $name );

		$parts = explode(".", trim($name));
		Wikia::log( __METHOD__, "info", "$name $language $type" );
		if( is_array( $parts ) ) {
			if( count( $parts ) <= 2 ) {
				$allowLang = true;
				switch( $type ) {
					case "answers":
						$domains = self::getAnswersDomains();
						if ( $language && isset($domains[$language]) && !empty($domains[$language]) ) {
							$name =  sprintf("%s.%s.%s", $name, $domains[$language], "wikia.com");
							$allowLang = false;
						} else {
							$name =  sprintf("%s.%s.%s", $name, $domains["default"], "wikia.com");
						}
						break;

					default:
						$name = $name.".wikia.com";
				}
				if ( $language && $language != "en" && $allowLang ) {
					$name = $language.".".$name;
				}
			}
		}
		return $name;
	}


    /**
     * addCredits
     *
     * add html with credits to xml dump
     *
     * @access public
     * @static
     * @author eloy@wikia
     * @author emil@wikia
     *
     * @param object $row: Database Row with page object
     *
     * @return string: HTML string with credits line
     */
    static public function addCredits( $row )
    {
		global $wgIwPrefix, $wgExternalSharedDB, $wgAddFromLink;

        $text = "";

		if ( $wgAddFromLink && ($row->page_namespace != 8) && ($row->page_namespace != 10) ) {
			if (isset($wgIwPrefix)){
				$text .= '<div id="wikia-credits"><br /><br /><small>' . wfMsg('tagline-url-interwiki',$wgIwPrefix) . '</small></div>';
			}
            elseif (isset($wgExternalSharedDB)){
				global $wgServer,$wgArticlePath,$wgSitename;
				$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
				$oRow = $dbr->selectRow(
                    'interwiki',
                    array( 'iw_prefix' ),
                    array( 'iw_url' => $wgServer.$wgArticlePath ),
                    __METHOD__
                );
				if ($oRow) {
					$text .= '<div id="wikia-credits"><br /><br /><small>' . wfMsg('tagline-url-interwiki',$oRow->iw_prefix) . '</small></div>';
				}
				else {
					$text .= '<div id="wikia-credits"><br /><br /><small>' . wfMsg('tagline-url') . '</small></div>';
				}
			}
            else {
				$text .= '<div id="wikia-credits"><br /><br /><small>' . wfMsg('tagline-url') . '</small></div>';
			}
		}

        return $text;
    }

    /**
     * ImageProgress
     *
     * hmtl code with progress image
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param string $type: type of progress image, default bar
     *
     * @return string: HTML string with progress image
     */
    static public function ImageProgress( $type = "bar" )
    {
        $sImagesCommonPath = wfGetImagesCommon();
        switch ( $type ) {
            default:
                return wfElement( 'img', array(
                    "src"    => "{$sImagesCommonPath}/skins/quartz/images/progress_bar.gif",
                    "width"  => 100,
                    "height" => 9,
                    "alt"    => ".....",
                    "border" => 0
                ));
        }
    }

    /**
     * json_encode
     *
     * json encoding function
     *
     * @access public
     * @static
     * author eloy@wikia
     *
     * @param mixed $what: structure for encoding
     *
     * @return string: encoded string
     */
    static public function json_encode( $what )
    {
        wfProfileIn( __METHOD__ );

        $sResponse = "";

        if (!function_exists('json_encode'))  { #--- php < 5.2
            $oJson = new Services_JSON();
            $sResponse = $oJson->encode( $what );
        }
        else {
            $sResponse = json_encode( $what );
        }
        wfProfileOut( __METHOD__ );

        return $sResponse;
    }

    /**
     * json_decode
     *
     * json decoding function
     *
     * @access public
     * @static
     * author eloy@wikia
     *
     * @param string $what: json string for decoding
     * @param boolean $assoc: returned object will be converted into associative array
     *
     * @return mixed: decoded structure
     */
    static public function json_decode( $what, $assoc = false )
    {
		wfProfileIn( __METHOD__ );

		$mResponse = null;

		if (!function_exists('json_decode'))  { #--- php < 5.2
		    $oJson = new Services_JSON();
		    $mResponse = $oJson->decode( $what );
		}
		else {
		    $mResponse = json_decode( $what, $assoc );
		}

		wfProfileOut( __METHOD__ );

		return $mResponse;
    }

    /**
     * binphp
     *
     * full path to php binary used in background scripts. wikia uses
     * /opt/wikia/php/bin/php, fp & localhost could use others. Write here Your
     * additional conditions to check
     *
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
     * @access public
     * @static
     *
     * @return string: path to php binary
     */
	static public function binphp() {
		wfProfileIn( __METHOD__ );

		$path = ( file_exists( "/opt/wikia/php/bin/php" )
			&& is_executable( "/opt/wikia/php/bin/php" ) )
			? "/opt/wikia/php/bin/php"
			: "/usr/bin/php";

		wfProfileOut( __METHOD__ );

		return $path;
	}

	static public function binWkhtmltopdf() {
		wfProfileIn( __METHOD__ );

		$path = ( file_exists( "/opt/wikia/bin/wkhtmltopdf" )
			&& is_executable( "/opt/wikia/bin/wkhtmltopdf" ) )
			? "/opt/wikia/bin/wkhtmltopdf"
			: "/usr/bin/wkhtmltopdf";

		wfProfileOut( __METHOD__ );

		return $path;
	}


	/**
	 * simple logger which log message to STDERR if devel environment is set
	 *
	 * @example Wikia::log( __METHOD__, "1", "checking" );
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @param String $method     -- use __METHOD__
	 * @param String $sub        -- if more in one method; default false
	 * @param String $message    -- additional message; default false
	 * @param Boolean $always    -- skip checking of $wgErrorLog and write log (or not); default false
	 * @param Boolean $timestamp -- write timestamp before line; default false
	 *
	 */
	static public function log( $method, $sub = false, $message = '', $always = false, $timestamp = false ) {
	  global $wgDevelEnvironment, $wgErrorLog, $wgDBname, $wgCityId, $wgCommandLineMode;

		$method = $sub ? $method . "-" . $sub : $method;
		if( $wgDevelEnvironment || $wgErrorLog || $always ) {
			error_log( $method . ":{$wgDBname}/{$wgCityId}:" . $message );
		}
		/**
		 * commandline = echo
		 */
		if( $wgCommandLineMode ) {
			$line = sprintf( "%s:%s/%d: %s\n", $method, $wgDBname, $wgCityId, $message );
			if( $timestamp ) {
				$line = wfTimestamp( TS_DB, time() ) . " " . $line;
			}
			echo $line;
		}
		/**
		 * and use wfDebug as well
		 */
		wfDebug( $method . ": " . $message . "\n" );
	}


	/**
	 * get staff person responsible for language
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 * @author Chris Stafford <uberfuzzy@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param String $lang  -- language code
	 *
	 * @return User -- instance of user object
	 */
	static public function staffForLang( $langCode ) {
		wfProfileIn( __METHOD__ );

		$staffSigs = wfMsgExt('staffsigs', array('language'=>'en')); // fzy, rt#32053

		$staffUser = false;
		if( !empty( $staffSigs ) ) {
			$lines = explode("\n", $staffSigs);

			$data = array();
			$sectLangCode = '';
			foreach ( $lines as $line ) {
				if( strpos( $line, '* ' ) === 0 ) {
					//language line
					$sectLangCode = trim( $line, '* ' );
					continue;
				}
				if( strpos( $line, '* ' ) == 1 && $sectLangCode ) {
					//user line
					$user = trim( $line, '** ' );
					$data[$sectLangCode][] = $user;
				}
			}

			//did we get any names for our target language?
			if( !empty( $data[$langCode] ) ) {
				//pick one
				$key = array_rand($data[$langCode]);

				//use it
				$staffUser = User::newFromName( $data[$langCode][$key] );
				$staffUser->load();
			}
		}

		/**
		 * fallback to Angela (with an override)
		 */
		if( ! $staffUser ) {
			$fallbackname = "Angela"; //still hardcoded

			if( !empty($data['?']) && is_array($data['?']) ) {
				//but overrideable
				$fallbackname = $data['?'][ array_rand($data['?']) ];
			}

			$staffUser = User::newFromName( $fallbackname );
			$staffUser->load();
		}

		wfProfileOut( __METHOD__ );
		return $staffUser;
	}

	/**
	 * View any string as a hexdump.
	 *
	 * This is most commonly used to view binary data from streams
	 * or sockets while debugging, but can be used to view any string
	 * with non-viewable characters.
	 *
	 * @version     1.3.2
	 * @author      Aidan Lister <aidan@php.net>
	 * @author      Peter Waller <iridum@php.net>
	 * @link        http://aidanlister.com/repos/v/function.hexdump.php
	 * @param       string  $data        The string to be dumped
	 * @param       bool    $htmloutput  Set to false for non-HTML output
	 * @param       bool    $uppercase   Set to true for uppercase hex
	 * @param       bool    $return      Set to true to return the dump
	 */
	static public function hex($data, $htmloutput = true, $uppercase = false, $return = false) {
		// Init
		$hexi   = '';
		$ascii  = '';
		$dump   = ($htmloutput === true) ? '<pre>' : '';
		$offset = 0;
		$len    = strlen($data);

		// Upper or lower case hexadecimal
		$x = ($uppercase === false) ? 'x' : 'X';

		// Iterate string
		for ($i = $j = 0; $i < $len; $i++) {
			// Convert to hexidecimal
			$hexi .= sprintf("%02$x ", ord($data[$i]));

			// Replace non-viewable bytes with '.'
			if (ord($data[$i]) >= 32) {
				$ascii .= ($htmloutput === true) ? htmlentities($data[$i]) : $data[$i];
			} else {
				$ascii .= '.';
			}

			// Add extra column spacing
			if ($j === 7) {
				$hexi  .= ' ';
				$ascii .= ' ';
			}

			// Add row
			if (++$j === 16 || $i === $len - 1) {
				// Join the hexi / ascii output
				$dump .= sprintf("%04$x  %-49s  %s", $offset, $hexi, $ascii);

				// Reset vars
				$hexi   = $ascii = '';
				$offset += 16;
				$j      = 0;

				// Add newline
				if ($i !== $len - 1) {
					$dump .= "\n";
				}
			}
		}

		// Finish dump
		$dump .= ($htmloutput === true) ? '</pre>' : '';
		$dump .= "\n";

		// Output method
		if ($return === false) {
			echo $dump;
		} else {
			return $dump;
		}
	}

	/**
	 * Represents a write lock on the key, based in MessageCache::lock
	 */
	static public function lock( $key ) {
		global $wgMemc;
		$timeout = 10;
		$lockKey = wfMemcKey( $key, "lock" );
		for ($i=0; $i < $timeout && !$wgMemc->add( $lockKey, 1, $timeout ); $i++ ) {
			sleep(1);
		}

		return $i >= $timeout;
	}

	/**
	 * Unlock a write lock on the key, based in MessageCache::unlock
	 */
	static public function unlock($key) {
		global $wgMemc;
		$lockKey = wfMemcKey( $key, "lock" );
		return $wgMemc->delete( $lockKey );
	}


	/**
	 * A function for making time periods readable
	 *
	 * @author      Aidan Lister <aidan@php.net>
	 * @version     2.0.0
	 * @link        http://aidanlister.com/2004/04/making-time-periods-readable/
	 * @param       int     number of seconds elapsed
	 * @param       string  which time periods to display
	 * @param       bool    whether to show zero time periods
	 */
	static public function timeDuration( $seconds, $use = null, $zeros = false ) {
		$seconds = ceil( $seconds );
		if( $seconds == 0 || $seconds == 1 ) {
			$str = "{$seconds} sec";
		}
		else {

			// Define time periods
			$periods = array (
				'years'     => 31556926,
				'Months'    => 2629743,
				'weeks'     => 604800,
				'days'      => 86400,
				'hr'        => 3600,
				'min'       => 60,
				'sec'       => 1
				);

			// Break into periods
			$seconds = (float) $seconds;
			foreach ($periods as $period => $value) {
				if ($use && strpos($use, $period[0]) === false) {
					continue;
				}
				$count = floor($seconds / $value);
				if ($count == 0 && !$zeros) {
					continue;
				}
				$segments[strtolower($period)] = $count;
				$seconds = $seconds % $value;
			}

			// Build the string
			foreach ($segments as $key => $value) {
				$segment = $value . ' ' . $key;
				$array[] = $segment;
			}

			$str = implode(', ', $array);
		}
		return $str;
	}

	/**
	 * parse additional option links in RC
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       RC		 RC - RC object
	 * @param       Array    links
	 * @param       Array    options - default options
	 * @param       Array    nondefaults - request options
	 */
	static public function addRecentChangesLinks( $RC, &$links, &$defaults, &$nondefaults ) {
		global $wgRequest;

		$showhide = array( wfMsg( 'show' ), wfMsg( 'hide' ) );
		if ( !is_array($links) ) {
			$links = array();
		}
		if ( !isset($defaults['hidelogs']) ) {
			$defaults['hidelogs'] = "";
		}
		$nondefaults['hidelogs'] = $wgRequest->getVal( 'hidelogs', 0 );

		$options = $nondefaults + $defaults;

		$hidelogslink = $RC->makeOptionsLink( $showhide[1-$options['hidelogs']],
			array( 'hidelogs' => 1-$options['hidelogs'] ), $nondefaults);
		$links[] = wfMsgHtml( 'rcshowhidelogs', $hidelogslink );

		return true;
	}

	/**
	 * make query with additional options
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       Array    $conds - where conditions in SQL query
	 * @param       Array    $tables - tables used in SQL query
	 * @param       Array    $join_conds - joins in SQL query
	 * @param       FormOptions    $opts - selected options
	 */
	static public function makeRecentChangesQuery ( &$conds, &$tables, &$join_conds, $opts ) {
		global $wgRequest;

		if ( $wgRequest->getVal( 'hidelogs', 0 ) > 0 ) {
			$conds[] = 'rc_logid = 0';
		}
		return true;
	}

	/**
	 * disable special pages from the list of specialpages
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       Array    $list - list of specialpages
	 */
	static public function disableSpecialPage ( &$list ) {
		global $wgDisableSpecialStatistics;

		if ( isset($wgDisableSpecialStatistics) && ($wgDisableSpecialStatistics === true) ) {
			unset($list['Statistics']);
		}
		return true;
	}

	/**
	 * notify user on user right change
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       User    $user object
	 * @param       Array   $addgroup - selected groups for user
	 * @param       Array   $removegroup - disabled groups for user
	 */
	static public function notifyUserOnRightsChange ( &$user, $addgroup, $removegroup ) {
		global $wgUsersNotifiedOnAllChanges;

		$userName = $user->getName();
		if ( !in_array( $userName, $wgUsersNotifiedOnAllChanges) ) {
			$wgUsersNotifiedOnAllChanges[] = $userName;
		}

		return true;
	}

	/**
	 * find array val for lang key - with variant fallback, eg. zh-tw -> zh
	 *
	 * @author      Nef
	 * @param       Array   $map - lang=>value map
	 * @param       String  $lang - lang code, eg. zh or zh-tw
	 * @param       Mixed   $default - if no value found
	 */
	static public function langToSomethingMap($map, $lang, $default = null) {

		if (!empty($map[$lang])) {
			$val = $map[$lang];
		} elseif (!empty($map[preg_replace("/-.*$/", "", $lang)])) {
			$val = $map[preg_replace("/-.*$/", "", $lang)];
		} else {
			$val = $default;
		}

		return $val;
	}

	/**
	 * Wikia Setup.php
	 *
	 * @author      MoLi
	 */
	static public function setupAfterCache() {
		global $wgTTCache;
		$wgTTCache = wfGetMainTTCache();
		return true;
	}

	/**
	 * fixed answers domains
	 */
	public static function getAnswersDomains() {
		global $wgAvailableAnswersLang, $wgContLang;
		wfProfileIn(__METHOD__);
		$msg = "autocreatewiki-subname-answers";
		$default = wfMsgExt( $msg, array( "language" => "en" ) );
		#--
		$domains = array( 'default' => $wgContLang->lcfirst( $default ) );
		if ( !empty($wgAvailableAnswersLang) ) {
			foreach ( $wgAvailableAnswersLang as $lang ) {
				$domain = wfMsgExt( $msg, array( "language" => $lang ) );
				if ( !empty($domain) ) {
					$domain = $wgContLang->lcfirst( $domain );
					if ( !wfEmptyMsg( $msg, $domain ) &&  $domain != $domains['default'] ) {
						$domains[$lang] = $domain;
					}
				}
			}
		}
		wfProfileOut(__METHOD__);
		return $domains;
	}

	/**
	 * fixed answers sitenames
	 */
	public static function getAnswersSitenames() {
		global $wgAvailableAnswersLang, $wgContLang;
		wfProfileIn(__METHOD__);
		$result = array();
		$msg = "autocreatewiki-sitename-answers";
		if ( !empty($wgAvailableAnswersLang) ) {
			foreach ( $wgAvailableAnswersLang as $lang ) {
				$sitename = wfMsgExt( $msg, array( "language" => $lang ) );
				if ( !empty($sitename) && !wfEmptyMsg( $msg, $sitename ) ) {
					$result[$lang] = $sitename;
				}
			}
		}
		wfProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * check if domain is valid according to some known standards
	 * (it is not very strict checking)
	 *
	 * @author Krzysztof Krzyżaniak (eloy)
	 * @access public
	 * @static
	 *
	 * @param String $domain -- domain name for checking
	 *
	 * @return Boolean  -- true if valid, false otherwise
	 */
	public static function isValidDomain( $domain ) {
		return (bool )preg_match("/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i", $domain );
	}

	/* TODO remove when cat_hidden is fixed */
	public static function categoryCloudGetHiddenCategories() {
		$data = array();

		wfProfileIn( __METHOD__ );

		global $wgMemc;
		$key = wfMemcKey("WidgetCategoryCloud", "hidcats");
		$data = $wgMemc->get($key);
		if (is_null($data)) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
					array("page", "page_props"),
					array("page_title"),
					array("page_id = pp_page", "page_namespace" => NS_CATEGORY, "pp_propname" => "hiddencat"),
					__METHOD__
					);
			while ($row = $res->fetchObject()) {
				$data[] = $row->page_title;
			}
			$wgMemc->set($key, $data, 300);
		}

		wfProfileOut(__METHOD__);
		return $data;
	}

	// todo check if it isn't reduntant
	public static function categoryCloudMsgToArray( $key ) {
		$data = array();
		
		$msg = wfMsg($key);
		if (!wfEmptyMsg($msg, $key)) {
			$data = preg_split("/[*\s,]+/", $msg, null, PREG_SPLIT_NO_EMPTY);
		}
		return $data;
	}
}
