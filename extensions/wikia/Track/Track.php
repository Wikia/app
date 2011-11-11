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

	private function getURL ($type=null, $param=null) {
		global $wgCityId, $wgContLanguageCode, $wgDBname, $wgDBcluster, $wgUser, $wgArticle, $wgTitle, $wgAdServerTest;
		$url = Track::BASE_URL.($type ? "/$type" : '').'?'.
			'c='.$wgCityId.'&amp;'.
			'lc='.$wgContLanguageCode.'&amp;'.
			'lid='.WikiFactory::LangCodeToId($wgContLanguageCode).'&amp;'.
			'x='.$wgDBname.'&amp;'.
			'y='.$wgDBcluster.'&amp;'.
			'u='.$wgUser->getID().'&amp;'.
			'a='.(is_object($wgArticle) ? $wgArticle->getID() : null).'&amp;'.
			'n='.$wgTitle->getNamespace(). (!empty($wgAdServerTest) ? '&amp;db_test=1' : '');

		// Handle any parameters passed to us
		if ($param) {
			foreach ($param as $key => $val) {
				$url .= '&amp;'.urlencode($key).'='.urlencode($val);
			}
		}

		return $url;
	}

	public function getViewURL ($param=null) {
		return Track::getURL('', $param);
	}

	public function getEventURL ($param=null) {
		return Track::getURL('views', $param);
	}

	public function getJS ($type=null, $param=null) {
		$url = Track::getURL($type, $param);

		$script = <<<SCRIPT1
<noscript><img src="$url" width="1" height="1" border="0" alt="" /></noscript>
<script type="text/javascript">
	var beaconCookie;
	if (! beaconCookie) {
		var startIdx = document.cookie.indexOf('wikia_beacon_id');
		if (startIdx != -1) {
			startIdx = startIdx+16; // Advance past the '='
			var endIdx = document.cookie.indexOf(';', startIdx);
			beaconCookie = document.cookie.substr(startIdx, endIdx-startIdx);
		}
	}

	var trackUrl = "$url" + ((typeof document.referrer != "undefined") ? "&amp;r=" + escape(document.referrer) : "") + "&amp;cb=" + (new Date).valueOf() + (beaconCookie ? "&amp;beacon=" + beaconCookie : "");
	document.write('<'+'script type="text/javascript" src="' + trackUrl + '"><'+'/script>');
</script>
SCRIPT1;

		return $script;
	}

	public function getViewJS ($param=null) {
		return Track::getJS('', $param);
	}

	public function getEventJS ($param=null) {
		return Track::getJS('event', $param);
	}

	public function event ($event_type, $param=null) {
		$backtrace = debug_backtrace();
		$class = $backtrace[1]['class'];
		$func  = $backtrace[1]['function'];
		$line  = !empty($backtrace[1]['line']) ? $backtrace[1]['line'] : '?';
		$param['caller'] = "$class::$func:$line";
		$param['type'] = urlencode($event_type);

		$url = Track::getURL('special', $param);
		if (Http::get($url) !== false) {
			return true;
		} else {
			return false;
		}
	}

	public function addGlobalVars($vars) {
		global $wgUser;
		$vars['trackID'] = $wgUser->getId() ? $wgUser->getId() : 0;
		return true;
	}
}