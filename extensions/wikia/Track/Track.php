<?php
global $wgHooks, $wgExtensionCredits;

$wgExtensionCredits['other'][] = array(
	'name' => 'Track',
	'author' => 'Garth Webb',
	'description' => 'A class to help track events and pageviews for wikia'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'Track::addGlobalVars';
$wgHooks['WikiaSkinTopScripts'][] = 'Track::onWikiaSkinTopScripts';

class Track {
	const BASE_URL = 'http://a.wikia-beacon.com/__track';

	public static function getURL ($type=null, $name=null, $param=null, $for_html=true) {
		global $wgCityId, $wgContLanguageCode, $wgDBname, $wgDBcluster, $wgUser, $wgArticle, $wgTitle, $wgAdServerTest;

		$sep = $for_html ? '&amp;' : '&';
		$ip = F::app()->wg->Request->getIP();

		$url = Track::BASE_URL.
			($type ? "/$type" : '').
			($name ? "/$name" : '').
			'?'.
			'c='.$wgCityId.$sep.
			'lc='.$wgContLanguageCode.$sep.
			'lid='.WikiFactory::LangCodeToId($wgContLanguageCode).$sep.
			'x='.$wgDBname.$sep.
			'y='.$wgDBcluster.$sep.
			'u='.$wgUser->getID().$sep.
			'ip='.$ip.$sep.
			'a='.(is_object($wgArticle) ? $wgArticle->getID() : null).$sep.
			's='.RequestContext::getMain()->getSkin()->getSkinName().
			($wgTitle && !is_object($wgArticle) ? $sep.'pg='.urlencode($wgTitle->getPrefixedDBkey()) : '').
			($wgTitle ? $sep.'n='.$wgTitle->getNamespace() : '').
			(!empty($wgAdServerTest) ? $sep.'db_test=1' : '');

		// Handle any parameters passed to us
		if ($param) {
			foreach ($param as $key => $val) {
				$url .= $sep.urlencode($key).'='.urlencode($val);
			}
		}

		return $url;
	}

	public static function getViewJS ($param=null) {
		global $wgDevelEnvironment, $wgJsMimeType;

		// Fake beacon and varnishTime values for development environment
		if ( !empty( $wgDevelEnvironment ) ) {
			$script = '<script>var beacon_id = "ThisIsFake", varnishTime = "' . date( "r" ) . '";</script>';

		} else {
			$url = Track::getURL('view', '', $param);

			$script = <<<SCRIPT1
<!-- Wikia Beacon Tracking -->
<noscript><img src="$url&amp;nojs=1" width="1" height="1" border="0" alt="" /></noscript>
<script>
(function() {
	var result = RegExp("wikia_beacon_id=([A-Za-z0-9_-]{10})").exec(document.cookie);
	if(result) {
		window.beacon_id = result[1];
	} else {
		// something went terribly wrong
	}

	var utma = RegExp("__utma=([0-9\.]+)").exec(document.cookie);
	var utmb = RegExp("__utmb=([0-9\.]+)").exec(document.cookie);

	var trackUrl = "$url" + ((typeof document.referrer != "undefined") ? "&amp;r=" + escape(document.referrer) : "") + "&amp;cb=" + (new Date).valueOf() + (window.beacon_id ? "&amp;beacon=" + window.beacon_id : "") + (utma && utma[1] ? "&amp;utma=" + utma[1] : "") + (utmb && utmb[1] ? "&amp;utmb=" + utmb[1] : "");
	document.write('<'+'script type="text/javascript" src="' + trackUrl + '"><'+'/script>');
})();
</script>
SCRIPT1;
		}

		return $script;
	}

	public static function event ($event_type, $param=null) {
		$backtrace = debug_backtrace();
		$class = $backtrace[1]['class'];
		$func  = $backtrace[1]['function'];
		$line  = !empty($backtrace[1]['line']) ? $backtrace[1]['line'] : '?';
		$param['caller'] = "$class::$func:$line";

		$url = Track::getURL('special', urlencode($event_type), $param, false);
		if (Http::get($url) !== false) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @static
	 * @param array $vars
	 * @return bool
	 */
	public static function addGlobalVars(Array &$vars) {
		global $wgUser;

		// TODO: consider using $wgUser->isLoggedIn() instead
		if ($wgUser->getId() && $wgUser->getId() > 0) {
			$vars['wgTrackID'] = $wgUser->getId();
		}
		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		$scripts .= Track::getViewJS();
		return true;
	}
}
