<?php

class WikiaAssets {

	/**
	 * Since this function will return a string (containing comments) even in
	 * the case of failure.  If the optional 'resultWasEmpty' is provided, it will
	 * be set to true if the actual request returns an empty string.
	 */
	private static function get($url, $resultWasEmpty=false) {
		global $wgRequest, $wgServer;

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

	public static function combined() {
		global $wgRequest, $wgStylePath, $wgStyleVersion, $wgUseSiteJs;

		$type = $wgRequest->getVal('type');

		global $wgHttpProxy;
		$wgHttpProxy = "127.0.0.1:80";

		$contentType = "";
		$hadAnError = false;
		if($type == 'PrintCSS') {
			// TODO: used by Oasis
			$contentType = "text/css";
			$out = '';
			$cb = $wgRequest->getVal('cb');
			$ref = WikiaAssets::GetPrintCSSReferences($cb);
			foreach($ref as $reference) {
				$errorOnThisCall = false;
				$out .= self::get($reference['url'], $errorOnThisCall);
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

	private function GetPrintCSSReferences($cb=""){
		global $wgRequest, $wgSquidMaxage;
		$cssReferences = array();
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
}