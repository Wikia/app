<?php
global $wgHooks, $wgExtensionCredits;

$wgExtensionCredits['other'][] = array(
	'name' => 'Track',
	'author' => 'Garth Webb',
	'description' => 'A class to help track events and pageviews for wikia'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'Track::addGlobalVars';

class Track {
	const BASE_URL = 'http://a.wikia-beacon.com/__track';

	public function getURL ($type=null, $name=null, $param=null, $for_html=true) {
		global $wgCityId, $wgContLanguageCode, $wgDBname, $wgDBcluster, $wgUser, $wgArticle, $wgTitle, $wgAdServerTest;

		$sep = $for_html ? '&amp;' : '&';

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
			'ip='.wfGetIp().$sep.
			'a='.(is_object($wgArticle) ? $wgArticle->getID() : null).
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

	public function getViewJS ($param=null) {
		$url = Track::getURL('view', '', $param);

		$script = <<<SCRIPT1
<noscript><img src="$url" width="1" height="1" border="0" alt="" /></noscript>
<script type="text/javascript">
(function() {
	var beaconCookie;
	if (! beaconCookie) {
		var result = RegExp("wikia_beacon_id=([A-Za-z0-9_-]{10})").exec(document.cookie);
		if (result) {
			beaconCookie = result[1];
		}
	}

	var utma = RegExp("__utma=([0-9\.]+)").exec(document.cookie);
	var utmb = RegExp("__utmb=([0-9\.]+)").exec(document.cookie);

	var trackUrl = "$url" + ((typeof document.referrer != "undefined") ? "&amp;r=" + escape(document.referrer) : "") + "&amp;cb=" + (new Date).valueOf() + (beaconCookie ? "&amp;beacon=" + beaconCookie : "") + (utma && utma[1] ? "&amp;utma=" + utma[1] : "") + (utmb && utmb[1] ? "&amp;utmb=" + utmb[1] : "");
	document.write('<'+'script type="text/javascript" src="' + trackUrl + '"><'+'/script>');
})();
</script>
SCRIPT1;

		return $script;
	}

	public function event ($event_type, $param=null) {
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

	public function addGlobalVars($vars) {
		global $wgUser;
		$vars['wgTrackID'] = $wgUser->getId() ? $wgUser->getId() : 0;
		$vars['wgUserIP'] = wfGetIp();
		return true;
	}
}