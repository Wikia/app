<?php

class AnalyticsProviderGA_Urchin implements iAnalyticsProvider {

	public function getSetupHtml(){
		global $wgProto;

		static $called = false;
		if($called == true){
			return '';
		}
		$called = true;

		if(strpos($_SERVER['SCRIPT_URI'], '.wikia.com/') !== false) {
			$extra = '_gaq.push([\'_setDomainName\', \'.wikia.com\']);';
		} else {
			$extra = '';
		}

		return  '<script type="text/javascript" src="' . $wgProto . '://www.google-analytics.com/ga.js"></script><script type="text/javascript">' . $extra . '_gaq.push([\'_setSampleRate\', \'10\']);</script><script type="text/javascript">urchinTracker = function() {_gaq.push([\'_setAccount\', \'UA-2871474-1\']);_gaq.push([\'_trackEvent\', \'Error\', \'FakeUrchinTrackerCalled\']);};</script>' . "\n";
	}

	public function trackEvent($event, $eventDetails=array()){
		switch ($event){
			case "lyrics":
				return $this->lyrics();
				break;

			case AnalyticsEngine::EVENT_PAGEVIEW:
				return '<script type="text/javascript">_uff=0;_uacct="UA-288915-1";urchinTracker();</script>';

			case 'hub':
				if (empty($eventDetails['name'])){
					return '<!-- Missing category name  for hub tracking event -->';
				}
				$hub = "/" . str_replace(' ', '_', $eventDetails['name']);
				return '<script type="text/javascript">_gaq.push([\'_setAccount\', \'UA-288915-2\']);_gaq.push([\'_trackPageview\', \''.addslashes($hub).'\']);</script>';

			case 'onewiki':
				return $this->onewiki($eventDetails[0]);

			case 'pagetime':
			 	return $this->pagetime($eventDetails[0]);

			case 'noads':
				return $this->noads();

			case 'female':
				return $this->female();

			case "varnish-stat":
				return $this->varnishstat();

			case "abtest":
				return $this->abtest();

			default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	/* For certain wikis, we issue an additional call to track page views independently */
	private function onewiki($city_id){
		global $wgGoogleAnalyticsAccount;

		if (empty($wgGoogleAnalyticsAccount)){
			return '<!-- No tracking for this wiki -->';
		} else {
			return '<script type="text/javascript">_gaq.push([\'_setAccount\', \''.addslashes($wgGoogleAnalyticsAccount).'\']);_gaq.push([\'_trackPageview\']);</script>';
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
	_gaq.push([\'_setAccount\', \'UA-288915-42\']);
	_gaq.push([\'_trackPageview\', slashtime]);
}
</script>';
	}

	private function abtest() {
		return '<script type="text/javascript">
var abtest_ua;
if(abtest_ua = document.cookie.match(/wikia-ab=[^;]*UA=(.*?)\//)) {
	_gaq.push([\'_setAccount\', abtest_ua[1]]);
	_gaq.push([\'_trackPageview\']);
}
</script>
';
	}

	private function noads() {
		return '<script type="text/javascript">
if(document.cookie.match(/wikia-test=selected/)) {
	_gaq.push([\'_setAccount\', \'UA-288915-45\']);
	_gaq.push([\'_trackPageview\']);
} else if(document.cookie.match(/wikia-test=control/)) {
	_gaq.push([\'_setAccount\', \'UA-288915-46\']);
	_gaq.push([\'_trackPageview\']);
}
</script>';
	}

	private function varnishstat() {
		return '<script type="text/javascript">
var varnish_server;
if (varnish_server = document.cookie.match(/varnish-stat=([^;]+)/)) {
	_gaq.push([\'_setAccount\', \'UA-288915-48\']);
	_gaq.push([\'_trackPageview\', varnish_server[1]]);
}
</script>';
		}

	private function female() {
		return '<script type="text/javascript">
if(document.cookie.match(/id%22%3A%222463/)) {
	_gaq.push([\'_setAccount\', \'UA-288915-47\']);
	_gaq.push([\'_trackPageview\']);
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

		$out  = "<script type=\"text/javascript\">_gaq.push(['_setAccount', 'UA-12241505-1']);_gaq.push(['_trackPageview', '/GN2/".$ns."']);</script>\n";

		if (in_array($ns, array(0, 220))) {
			$out .= "<script type=\"text/javascript\">_gaq.push(['_setAccount', 'UA-12241505-1']);_gaq.push(['_trackPageview', '/GN4/".$ns."/".$wgTitle->getArticleID()."']);</script>\n";
		}

		return $out;
	}
}
