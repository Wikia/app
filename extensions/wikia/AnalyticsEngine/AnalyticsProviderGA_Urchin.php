<?php

class AnalyticsProviderGA_Urchin implements iAnalyticsProvider {

	public function getSetupHtml($params=array()){
		global $wgProto;

		static $called = false;
		if($called == true){
			return '';
		}
		$called = true;

		$setDomainName = '';
		if(strpos($_SERVER['SCRIPT_URI'], '.wikia.com/') !== false) {
			$setDomainName = '_gaq.push([\'_setDomainName\', \'.wikia.com\']);';
		} else {
			$setDomainName = '';
		}

		// TODO: use asynchronous approach (BugId:20216)
		// @see http://code.google.com/intl/pl/apis/analytics/docs/tracking/asyncTracking.html
/*
		$script .= <<<SCRIPT2
<script type="text/javascript" src="{$wgProto}://www.google-analytics.com/ga.js"></script>
<script type="text/javascript">
$setDomainName
_gaq.push(['_setSampleRate', '10']);
urchinTracker = function() {
	_wtq.push(['/error/fakeurchin', 'main']);
};
</script>
SCRIPT2;
*/
		$script = <<<SCRIPT2
<script type="text/javascript">
  function getCustomVarPage() {
    if (window.wgIsMainpage) return 'mainpage';

    return 'other';
  }

  function getCustomVarAB() {
    var ab = window.Wikia.AbTest && Wikia.AbTest.getTreatmentGroup(1);
    return ab ? 'e1 g' + ab : 'no group';
  }

  function getCustomVarSlot() {
    var slot = 'other';

    if (typeof wgExtensionsPath != 'undefined') {
      var s = wgExtensionsPath.match(/slot([0-9])/);
      if (s) {
        slot = s[1];
      }
    }

    return slot;
  }

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30014103-1']);
  _gaq.push(['_setSampleRate', '10']);

  _gaq.push(['_setCustomVar', 1, 'wiki', 'hub=' + (window.wgCatId || 'unknown') + ';lang=' + (window.wgContentLanguage || 'unknown') + ';slot=' + (getCustomVarSlot() || 'unknown'), 3]);
  _gaq.push(['_setCustomVar', 2, 'page', (getCustomVarPage() || 'unknown'), 3]);
  _gaq.push(['_setCustomVar', 3, 'AB2',  (getCustomVarAB() || 'unknown'), 3]);
  _gaq.push(['_setCustomVar', 4, 'skin',  window.skin || 'unknown', 3]);
  _gaq.push(['_setCustomVar', 5, 'user', (window.wgUserName == null) ? 'anon' : 'user', 3]);

  $setDomainName

  _gaq.push(['_trackPageview']);

  _gaq.push(['Ads._setAccount', 'UA-17475676-7']);
  _gaq.push(['Ads._setSampleRate', '100']);

  _gaq.push(['Ads._setCustomVar', 1, 'wiki', 'hub=' + (window.wgCatId || 'unknown') + ';lang=' + (window.wgContentLanguage || 'unknown') + ';slot=' + (getCustomVarSlot() || 'unknown'), 3]);
  _gaq.push(['Ads._setCustomVar', 2, 'page', (getCustomVarPage() || 'unknown'), 3]);
  _gaq.push(['Ads._setCustomVar', 3, 'AB2',  (getCustomVarAB() || 'unknown'), 3]);
  _gaq.push(['Ads._setCustomVar', 4, 'skin',  window.skin || 'unknown', 3]);
  _gaq.push(['Ads._setCustomVar', 5, 'user', (window.wgUserName == null) ? 'anon' : 'user', 3]);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
SCRIPT2;

		return $script;
	}

	public function trackEvent($event, $eventDetails=array()){
		switch ($event){
			case "lyrics":
				return $this->lyrics();
				break;

			case AnalyticsEngine::EVENT_PAGEVIEW:
				return '';
// 				return '<script type="text/javascript">_wtq.push([\'AnalyticsEngine::EVENT_PAGEVIEW\', \'Wikia.main\']);</script>';
				#return '<script type="text/javascript">_gaq.push([\'_setAccount\',\'UA-288915-1\']);_gaq.push([\'_setSampleRate\',10]);_gaq.push([\'_setDomainName\',\'.wikia.com\']);_gaq.push([\'_trackPageview\']);</script>'; // BugId:21127

			// oasis is not calling this?!?
			case 'hub':
				if (empty($eventDetails['name'])){
					return '<!-- Missing category name  for hub tracking event -->';
				}
				$hub = "/" . str_replace(' ', '_', $eventDetails['name']);
				return '';
// 				return '<script type="text/javascript">_wtq.push([\'' . addslashes($hub) . '\', \'Wikia.hub\']);</script>';

			case 'onewiki':
				return $this->onewiki($eventDetails[0]);

			case 'pagetime':
			 	return $this->pagetime($eventDetails[0]);

			case "varnish-stat":
				return $this->varnishstat();

			default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	/* For certain wikis, we issue an additional call to track page views independently */
	private function onewiki($city_id){
		global $wgGoogleAnalyticsAccount;

		if (empty($wgGoogleAnalyticsAccount)){
			return '<!-- No tracking for this wiki -->';
		} else {
			return '';
// 			return '<script type="text/javascript">_wtq.push([\'AnalyticsEngine::EVENT_PAGEVIEW\', \'' . addslashes($wgGoogleAnalyticsAccount) . '\']);</script>';
		}
	}

	/* Record how long the page took to load  */
	private function pagetime($skin){
		return '';
/*
		return '<script type="text/javascript">
if (typeof window.wgNow == "object"){
	var now = new Date();
	var ms = (now.getTime() - window.wgNow.getTime()) / 1000;
	var pageTime = Math.floor(ms * 10) / 10; // Round to 1 decimal
	var slashtime = "/' . $skin . '/" + pageTime.toString().replace(/\./, "/");
	_wtq.push([slashtime, \'Wikia.pagetime\']);
}
</script>';
*/
	}

	private function varnishstat() {
		return '';
/*
		return '<script type="text/javascript">
var varnish_server;
if (varnish_server = document.cookie.match(/varnish-stat=([^;]+)/)) {
	_wtq.push([varnish_server[1], \'Wikia.varnish\']);
}
</script>';
*/
		}

	private function lyrics() {
		global $wgRequest;

		// Only record stats when the user is viewing lyrics rather than performing other actions on it (submitting a form, starting an edit, etc.).
		$action = $wgRequest->getVal("action", "view");
		if (!in_array($action, array("view", "purge"))){
			return "<!-- Not a lyrics view (action: \"$action\"). -->";
		}

		global $wgTitle;
		if (!is_object($wgTitle) || !($wgTitle instanceof Title)) {
			return '';
		}

		$ns = $wgTitle->getNamespace();

		$out = '';
// 		$out .= "<script type=\"text/javascript\">_wtq.push(['/GN2/".$ns."', 'lyrics']);</script>\n";

		if (in_array($ns, array(0, 220))) {
// 			$out .= "<script type=\"text/javascript\">_wtq.push(['/GN4/".$ns."/".$wgTitle->getArticleID()."', 'lyrics']);</script>\n";
		}

		return $out;
	}
}
