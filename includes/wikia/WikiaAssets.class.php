<?php

class WikiaAssets {

	/**
	 * Since this function will return a string (containing comments) even in
	 * the case of failure.  If the optional 'resultWasEmpty' is provided, it will
	 * be set to true if the actual request returns an empty string.
	 */
	private static function get($url, $resultWasEmpty=false) {
		global $wgRequest;

		//$useNginx = !$wgRequest->getBool('nia');
		$useNginx = false; // we don't use nginx.  TODO: Delete the nginx code if we're sure we're never going back.
		if($useNginx) {

			$out = "\n/* Version: nginx Call to: {$url} */\n";
			$out .= '<!--# include virtual="'.$url.'" -->';

			$resultWasEmpty = true; // always empty now... we don't have nginx anymore.

			return $out;

		} else {

			global $wgServer;

			$url = str_replace('&amp;', '&', $url);

			// Re-write local URLs to have the server name at the beginning.
			if(preg_match("/^https?:\/\//i", $url) == 0){
				if(stripos($url, '/') === 0) {
					$url = $wgServer.$url;
				} else {
					$url = $wgServer.'/'.$url;
				}
			}

			$out = "\n/* Version: not-nginx Call to: {$url} */\n";
			$content = trim(Http::get($url));
			if($content == ""){
				$resultWasEmpty = true;
			}
			$out .= $content;

			return $out;

		}
	}

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
		global $wgRequest, $wgStylePath, $wgStyleVersion, $wgUseSiteJs;

		$type = $wgRequest->getVal('type');

		global $wgHttpProxy;
		$wgHttpProxy = "127.0.0.1:80";

		$contentType = "";
		$hadAnError = false;
		if($type == 'CoreCSS') {
			$contentType = "text/css";
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

				// There are race-conditions in deployment.  Always use the greater style version b/w the request and the local value.
				$cb = $wgRequest->getVal('cb', 0);
				$cb = max($wgStyleVersion, $cb);

				if(strpos($reference['url'], '?') === false) {
					$reference['url'] .= '?'.$cb;
				} else {
					$reference['url'] .= '&'.$cb;
				}

				$errorOnThisCall = false;
				$out .= self::get($reference['url'], $errorOnThisCall);
				$hadAnError |= $errorOnThisCall;
			}
		} else if($type == 'SiteCSS') {
			$contentType = "text/css";
			$out = '';
			$themename = $wgRequest->getVal('themename');
			$cb = $wgRequest->getVal('cb');
			$ref = WikiaAssets::GetSiteCSSReferences($themename, $cb);
			foreach($ref as $reference) {
				$errorOnThisCall = false;
				$out .= self::get($reference['url'], $errorOnThisCall);
				$hadAnError |= $errorOnThisCall;
			}
		} else if($type == 'PrintCSS') {
			$contentType = "text/css";
			$out = '';
			$cb = $wgRequest->getVal('cb');
			$ref = WikiaAssets::GetPrintCSSReferences($cb);
			foreach($ref as $reference) {
				$errorOnThisCall = false;
				$out .= self::get($reference['url'], $errorOnThisCall);
				$hadAnError |= $errorOnThisCall;
			}
		} else if($type == 'CoreJS') {
			$contentType = "text/javascript";
			$references = array();

			// configure based on skin
			//if(Wikia::isOasis()){
			if($wgRequest->getBool('isOasis', false)) {
				$packageName = "oasis_anon_article_js";
				$skinName = "oasis";
			} else {
				$packageName = "monaco_anon_article_js";
				$skinName = "monaco";
			}

			// static chute
			global $wgServer;
			$wgRequest->setVal('allinone', true);
			$staticChute = new StaticChute('js');
			$staticChute->useLocalChuteUrl();
			preg_match_all("/src=\"([^\"]+)/", $staticChute->getChuteHtmlForPackage($packageName), $matches, PREG_SET_ORDER);
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

			// per-site JS
			if (!empty($wgUseSiteJs)) {
				$references[] = Skin::makeUrl('-', "action=raw&gen=js&useskin=$skinName");
			}

			$out = '';
			foreach($references as $reference) {
				$errorOnThisCall = false;
				$out .= self::get($reference, $errorOnThisCall);
				$hadAnError |= $errorOnThisCall;
			}
		}

		// If one or more of the files failed... tell varnish/akamai/etc. not to cache this.
		if($hadAnError){
			header('HTTP/1.0 503 Temporary error');
		} else {
			header("Content-type: $contentType");
			header('Cache-Control: max-age=2592000, public');
		}

		echo $out;
		exit();
	}

	/**
	 * The optional cache-buster can be used to get around the current problems where purges are behind.
	 */
	private function GetSiteCSSReferences($themename, $cb = "") {
		global $wgRequest, $wgSquidMaxage;

		$isOasis = (Wikia::isOasis() || $wgRequest->getBool('isOasis'));

		$cssReferences = array();

		if($isOasis) {
			return $cssReferences;
		}

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

		$siteargs['useskin'] = 'monaco';

		$siteargs['gen'] = 'css';
		$cssReferences[] = array('url' => urldecode(Skin::makeUrl( '-', wfArrayToCGI( $siteargs ) )));

		return $cssReferences;
	}

	private function GetPrintCSSReferences($cb=""){
		global $wgRequest;
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

		$cssReferences[] = array('url' => urldecode(Skin::makeNSUrl('Print.css', $query, NS_MEDIAWIKI)));

		// Sometimes, this function is called on the page itself, sometimes it's called by the combiner.
		// The page can use Wikia::isOasis(), but the combiner needs the request param.
		$isOasis = (Wikia::isOasis() || $wgRequest->getBool('isOasis'));
		if($isOasis){
			$package = "oasis_css_print";
		} else {
			$package = "monaco_css_print";
		}
		$StaticChute = new StaticChute('css');
		$StaticChute->useLocalChuteUrl();
		foreach($StaticChute->config[$package] as $url){
			$cssReferences[] = array('url' => $url);
		}

		return $cssReferences;
	}

	public static function GetExtensionsCSS($styles) {
		// exclude user and site css
		foreach($styles as $style => $options) {
			if(strpos($style, ':Common.css') > 0
				|| strpos($style, ':Monaco.css') > 0
				|| strpos($style, ':Wikia.css') > 0
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

	/**
	 * Returns the HTML to put into the page for SiteCSS.  According to
	 * configuration, this may or may not be just a call to __wikia_combined
	 * for the SiteCSS files.
	 */
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
			$isOasis = (Wikia::isOasis()?"&amp;isOasis=true":"");
			$url = $wgScriptPath."/{$prefix}cb={$cb}{$wgStyleVersion}&amp;type=SiteCSS&amp;themename={$themename}&amp;rtl={$isRTL}".$isOasis;
			$out .= '<link rel="stylesheet" type="text/css" href="'.$url.'" />';
		} else {
			$ref = WikiaAssets::GetSiteCSSReferences($themename);
			foreach($ref as $reference) {
				$out .= '<link rel="stylesheet" type="text/css" href="'.$reference['url'].'" />';
			}
		}

		return $out;
	}

	public static function GetThemeCSS($themename, $skinname = 'monaco') {
		global $wgStylePath, $wgStyleVersion;
		if($themename != 'custom' && $themename != 'sapphire') {
			$out = "\n<!-- GetThemeCSS -->";
			$out .= '<link rel="stylesheet" type="text/css" href="'. $wgStylePath .'/'.$skinname.'/'. $themename .'/css/main.css?'.$wgStyleVersion.'" />';
			return $out;
		}
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
			$commonPart = "http://images1.wikia.nocookie.net/{$prefix}cb={$wgStyleVersion}&amp;type=CoreCSS&amp;themename={$themename}&amp;rtl={$isRTL}&amp;StaticChute=";

			$out = "\n<!-- GetCoreCSS -->";
			$out .= "\n".'<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.$commonPart.'&amp;browser=IElt7" /><![endif]-->';
			$out .= "\n".'<!--[if IE 7]><link rel="stylesheet" type="text/css" href="'.$commonPart.'&amp;browser=IEeq7" /><![endif]-->';
			$out .= "\n".'<!--[if IE 8]><link rel="stylesheet" type="text/css" href="'.$commonPart.'&amp;browser=IEeq8" /><![endif]-->';
			$out .= "\n".'<!--[if !IE]>--><link rel="stylesheet" type="text/css" href="'.$commonPart.'&amp;browser=notIE" /><!--<![endif]-->';

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