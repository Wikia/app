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

	private static function getURL ($type=null, $name=null, $param=null, $for_html=true) {
		global $wgStyleVersion, $wgCityId, $wgContLanguageCode, $wgDBname, $wgDBcluster, $wgUser, $wgArticle, $wgTitle, $wgAdServerTest;

		$sep = $for_html ? '&amp;' : '&';

		$url = Track::BASE_URL.
			($type ? "/$type" : '').
			($name ? "/$name" : '').
			'?'.
			'cb='.$wgStyleVersion.$sep.
			'c='.$wgCityId.$sep.
			'lc='.$wgContLanguageCode.$sep.
			'lid='.WikiFactory::LangCodeToId($wgContLanguageCode).$sep.
			'x='.$wgDBname.$sep.
			'y='.$wgDBcluster.$sep.
			'u='.$wgUser->getID().$sep.
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

	private static function getViewJS ($param=null) {
		global $wgDevelEnvironment;

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
		document.write('<img src="http://logs-01.loggly.com/inputs/88a88e56-77c6-49cc-af41-6f44f83fe7fe.gif?message=wikia_beacon_id%20is%20empty"/>');
	}

	var utma = RegExp("__utma=([0-9\.]+)").exec(document.cookie);
	var utmb = RegExp("__utmb=([0-9\.]+)").exec(document.cookie);

	var trackUrl = "$url" + ((typeof document.referrer != "undefined") ? "&amp;r=" + escape(document.referrer) : "") + "&amp;rand=" + (new Date).valueOf() + (window.beacon_id ? "&amp;beacon=" + window.beacon_id : "") + (utma && utma[1] ? "&amp;utma=" + utma[1] : "") + (utmb && utmb[1] ? "&amp;utmb=" + utmb[1] : "");
	document.write('<'+'script type="text/javascript" src="' + trackUrl + '"><'+'/script>');
})();
</script>
SCRIPT1;
		}

		return $script;
	}

	public static function event ($event_type, $param=null) {
		if ( !self::shouldTrackEvents() ) {
			return false;
		}

		wfProfileIn(__METHOD__);

		$backtrace = debug_backtrace();
		$class = $backtrace[1]['class'];
		$func  = $backtrace[1]['function'];
		$line  = !empty($backtrace[1]['line']) ? $backtrace[1]['line'] : '?';
		$param['caller'] = "$class::$func:$line";

		$url = Track::getURL('special', urlencode($event_type), $param, false);
		if (ExternalHttp::get($url) !== false) {
			wfProfileOut(__METHOD__);
			return true;
		} else {
			wfProfileOut(__METHOD__);
			return false;
		}
	}

	/**
	 * Check whether events should be tracked
	 *
	 * @return bool
	 */
	protected static function shouldTrackEvents() {
		// Check request headers to make sure this is not a mirrored
		// request, which could result in duplicate tracking events
		return F::app()->wg->request->isWikiaInternalRequest() === false;
	}

	/**
	 * @static
	 * @param array $vars
	 * @return bool
	 */
	public static function addGlobalVars(Array &$vars) {
		global $wgUser;

		if ($wgUser->isLoggedIn()) {
			$vars['wgTrackID'] = $wgUser->getId();
		}
		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		$scripts .= Track::getViewJS();
		return true;
	}
}
