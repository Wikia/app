<?php

class AnalyticsProviderGA_Urchin implements iAnalyticsProvider {

	public function getSetupHtml($params=array()){
		global $wgProto;

		static $called = false;
		if($called == true){
			return '';
		}
		$called = true;

		$script = '';

		if(strpos($_SERVER['SCRIPT_URI'], '.wikia.com/') !== false) {
			$setDomainName = '_gaq.push([\'_setDomainName\', \'.wikia.com\']);';
		} else {
			$setDomainName = '';
		}

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

		// Load the OneDot javascript after GA
		if (class_exists('Track')) {
			$script .= Track::getViewJS();
		}

		return $script;
	}

	public function trackEvent($event, $eventDetails=array()){
		switch ($event){
			case "lyrics":
				return $this->lyrics();
				break;

			case AnalyticsEngine::EVENT_PAGEVIEW:
				return '<script type="text/javascript">_wtq.push([\'AnalyticsEngine::EVENT_PAGEVIEW\', \'Wikia.main\']);</script>';

			// oasis is not calling this?!?
			case 'hub':
				if (empty($eventDetails['name'])){
					return '<!-- Missing category name  for hub tracking event -->';
				}
				$hub = "/" . str_replace(' ', '_', $eventDetails['name']);
				return '<script type="text/javascript">_wtq.push([\'' . addslashes($hub) . '\', \'Wikia.hub\']);</script>';

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
			return '<script type="text/javascript">_wtq.push([\'AnalyticsEngine::EVENT_PAGEVIEW\', \'' . addslashes($wgGoogleAnalyticsAccount) . '\']);</script>';
		}
	}

	/* Record how long the page took to load  */
	private function pagetime($skin){
		return '<script type="text/javascript">
if (typeof window.wgNow == "object"){
	var now = new Date();
	var ms = (now.getTime() - window.wgNow.getTime()) / 1000;
	var pageTime = Math.floor(ms * 10) / 10; // Round to 1 decimal
	var slashtime = "/' . $skin . '/" + pageTime.toString().replace(/\./, "/");
	_wtq.push([slashtime, \'Wikia.pagetime\']);
}
</script>';
	}

	private function varnishstat() {
		return '<script type="text/javascript">
var varnish_server;
if (varnish_server = document.cookie.match(/varnish-stat=([^;]+)/)) {
	_wtq.push([varnish_server[1], \'Wikia.varnish\']);
}
</script>';
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
		$out .= "<script type=\"text/javascript\">_wtq.push(['/GN2/".$ns."', 'lyrics']);</script>\n";

		if (in_array($ns, array(0, 220))) {
			$out .= "<script type=\"text/javascript\">_wtq.push(['/GN4/".$ns."/".$wgTitle->getArticleID()."', 'lyrics']);</script>\n";
		}

		return $out;
	}
}
