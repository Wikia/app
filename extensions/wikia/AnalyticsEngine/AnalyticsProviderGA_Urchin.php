<?php

class AnalyticsProviderGA_Urchin implements iAnalyticsProvider {


	public function getSetupHtml(){
		global $wgEnableGA, $wgProto;

		static $called = false;
		if ($called == true){
			return '';
		} else {
			$called = true;
		}

		if(!empty($wgEnableGA)) {
			//return "<script type=\"text/javascript\">(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();urchinTracker = function() {_gaq.push(['_setAccount', 'UA-2871474-1']);_gaq.push(['_trackEvent', 'Error', 'FakeUrchinTrackerCalled']);};</script>";
			//test related to FB#4768, original value was "UA-2871474-1"
			return  '<script type="text/javascript" src="' . $wgProto . '://www.google-analytics.com/ga.js"></script><script type="text/javascript">urchinTracker = function() {_gaq.push([\'_setAccount\', \'UA-19473076-1\']);_gaq.push([\'_trackEvent\', \'Error\', \'FakeUrchinTrackerCalled\']);};</script>' . "\n";
		} else {
			return  '<script type="text/javascript" src="' . $wgProto . '://www.google-analytics.com/urchin.js"></script>' . "\n";
		}
	}

	public function trackEvent($event, $eventDetails=array()){
		global $wgEnableGA;

		switch ($event){
			case "lyrics":
				return $this->lyrics();
				break;

		  case AnalyticsEngine::EVENT_PAGEVIEW:
				if(!empty($wgEnableGA)) {
					return '<script type="text/javascript">_gaq.push([\'_setAccount\', \'UA-288915-1\']);_gaq.push([\'_trackPageview\']);</script>';
				} else {
					return '<script type="text/javascript">_uff=0;_uacct="UA-288915-1";urchinTracker();</script>';
				}

		  case 'hub':
				if (empty($eventDetails['name'])){
					return '<!-- Missing category name  for hub tracking event -->';
				}
				$hub = "/" . str_replace(' ', '_', $eventDetails['name']);
				if(!empty($wgEnableGA)) {
					return '<script type="text/javascript">_gaq.push([\'_setAccount\', \'UA-288915-2\']);_gaq.push([\'_trackPageview\', \''.addslashes($hub).'\']);</script>';
				} else {
					return '<script type="text/javascript">_uff=0;_uacct="UA-288915-2";urchinTracker("' .addslashes($hub).'");</script>';
				}

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
		global $wgGoogleAnalyticsAccount, $wgEnableGA;

		if (empty($wgGoogleAnalyticsAccount)){
			return '<!-- No tracking for this wiki -->';
		} else {
			if(!empty($wgEnableGA)) {
				return '<script type="text/javascript">_gaq.push([\'_setAccount\', \''.addslashes($wgGoogleAnalyticsAccount).'\']);_gaq.push([\'_trackPageview\']);</script>';
			} else {
				return '<script type="text/javascript">_uff=0;_uacct="' . addslashes($wgGoogleAnalyticsAccount) . '";urchinTracker();</script>';
			}
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


				if(typeof wgEnableGA != "undefined" && wgEnableGA == true) {
					_gaq.push([\'_setAccount\', \'UA-288915-42\']);
					_gaq.push([\'_trackPageview\', slashtime]);
				} else {
					_uff=0;
					_uacct="UA-288915-42";
					urchinTracker(slashtime);
				}
			}
			</script>';
	}


	private function abtest() {
	    return '<script type="text/javascript">
var abtest_ua;
if(abtest_ua = document.cookie.match(/wikia-ab=[^;]*UA=(.*?)\//)) {
	if(typeof wgEnableGA != "undefined" && wgEnableGA == true) {
		_gaq.push([\'_setAccount\', abtest_ua[1]]);
		_gaq.push([\'_trackPageview\']);
	} else {
		_uff=0;
		_uacct=abtest_ua[1];
		urchinTracker();
	}
}
</script>
';


	}

	private function noads() {
		return '<script type="text/javascript">
if(document.cookie.match(/wikia-test=selected/)) {
	if(typeof wgEnableGA != "undefined" && wgEnableGA == true) {
		_gaq.push([\'_setAccount\', \'UA-288915-45\']);
		_gaq.push([\'_trackPageview\']);
	} else {
		_uff=0;
		_uacct="UA-288915-45";
		urchinTracker();
	}
} else if(document.cookie.match(/wikia-test=control/)) {
	if(typeof wgEnableGA != "undefined" && wgEnableGA == true) {
		_gaq.push([\'_setAccount\', \'UA-288915-46\']);
		_gaq.push([\'_trackPageview\']);
	} else {
		_uff=0;
		_uacct="UA-288915-46";
		urchinTracker();
	}
}
</script>';
	}

	private function varnishstat() {
	    return '<script type="text/javascript">
var varnish_server;
if (varnish_server = document.cookie.match(/varnish-stat=([^;]+)/)) {
	if(typeof wgEnableGA != "undefined" && wgEnableGA == true) {
		_gaq.push([\'_setAccount\', \'UA-288915-48\']);
		_gaq.push([\'_trackPageview\', varnish_server[1]]);
	} else {
		_uff=0;
		_uacct="UA-288915-48";
		urchinTracker(varnish_server[1]);
	}
}
</script>';
		}

	private function female() {
		return '<script type="text/javascript">
if(document.cookie.match(/id%22%3A%222463/)) {
	if(typeof wgEnableGA != "undefined" && wgEnableGA == true) {
		_gaq.push([\'_setAccount\', \'UA-288915-47\']);
		_gaq.push([\'_trackPageview\']);
	} else {
		_uff=0;
		_uacct="UA-288915-47";
		urchinTracker()
	}
}
</script>';
	}

/*
	// Track actual browser width by screen width
	private function browserWidth() {
		return '<script type="text/javascript">
_uff=0;
_uacct="UA-288915-49";

var screenWidth = screen.width;
var browserWidth = document.body.offsetWidth;

var browserThousands = Math.floor(browserWidth/1000) * 1000;
browserWidth = browserWidth - browserThousands;
var browserHundreds = Math.floor(browserWidth/100) * 100;
browserWidth = browserWidth - browserHundreds;
var browserTens = Math.floor(browserWidth/10) * 10;

urchinTracker("resolution/" + screenWidth + "/" + browserThousands + "/" + browserHundreds + "/" + browserTens);
</script>';
	}
*/

	private function lyrics() {
		global $wgRequest, $wgEnableGA;

		// Only record stats when the user is viewing lyrics rather than performing other actions on it (submitting a form, starting an edit, etc.).
		$action = $wgRequest->getVal("action", "view");
		if(!in_array($action, array("view", "purge"))){
			return "<!-- Not a lyrics view (action: \"$action\"). -->";
		}

		global $wgTitle;
		if (!is_object($wgTitle) || !($wgTitle instanceof Title)) return "";

		$ns = $wgTitle->getNamespace();

		if(!empty($wgEnableGA)) {
			$out  = "<script type=\"text/javascript\">_gaq.push(['_setAccount', 'UA-12241505-1']);_gaq.push(['_trackPageview', '/GN2/".$ns."']);</script>\n";
		} else {
			$out  = "<script type=\"text/javascript\">_uff=0; _uacct=\"UA-12241505-1\"; urchinTracker(\"/GN2/{$ns}\");</script>\n";
		}

		if (in_array($ns, array(0, 220))) {
			if(!empty($wgEnableGA)) {
				$out .= "<script type=\"text/javascript\">_gaq.push(['_setAccount', 'UA-12241505-1']);_gaq.push(['_trackPageview', '/GN4/".$ns."/".$wgTitle->getArticleID()."']);</script>\n";
			} else {
				$out .= "<script type=\"text/javascript\">_uff=0; _uacct=\"UA-12241505-1\"; urchinTracker(\"/GN4/{$ns}/{$wgTitle->getArticleID()}\");</script>\n";
			}
		}

		return $out;
	}
}
