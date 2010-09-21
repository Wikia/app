<?php

class AnalyticsProviderGA_Urchin implements iAnalyticsProvider {


	public function getSetupHtml(){
		static $called = false;
		if ($called == true){
			return '';
		} else {
			$called = true;
		}

		return  '<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>' . "\n";
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
			return '<script type="text/javascript">_uff=0;_uacct="UA-288915-2";urchinTracker("' .addslashes($hub).'");</script>';
		  case 'onewiki':
			return $this->onewiki($eventDetails[0]);

		  case 'pagetime':
			return $this->pagetime($eventDetails[0]);
                  case 'noads':
		        return $this->noads();
		case 'female':
		    return $this->female();

                  default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	/* For certain wikis, we issue an additional call to track page views independently */
	private function onewiki($city_id){
		global $wgGoogleAnalyticsAccount;

		if (empty($wgGoogleAnalyticsAccount)){
			return '<!-- No tracking for this wiki -->';
		} else {
			return '<script type="text/javascript">_uff=0;_uacct="' . addslashes($wgGoogleAnalyticsAccount) . '";urchinTracker();</script>';
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
				_uff=0;
				_uacct="UA-288915-42";
				urchinTracker(slashtime);
			}
			</script>';
	}

	private function noads() {
		return '<script type="text/javascript">
if(document.cookie.match(/wikia-test=selected/)) {
_uff=0;
_uacct="UA-288915-45";
urchinTracker();
} else if(document.cookie.match(/wikia-test=control/)) {
_uff=0;
_uacct="UA-288915-46";
urchinTracker();
}
</script>';
	}

	private function female() {
		return '<script type="text/javascript">
if(document.cookie.match(/id%22%3A%222463/)) {
_uff=0;
_uacct="UA-288915-47";
urchinTracker();
}
</script>';
	}

	private function lyrics() {
		global $wgRequest;
		if ("view" != $wgRequest->getVal("action", "view")) return "";

		global $wgTitle;
		if (!is_object($wgTitle) || !($wgTitle instanceof Title)) return "";

		$ns = $wgTitle->getNamespace();

		$out  = "<script type=\"text/javascript\">_uff=0; _uacct=\"UA-12241505-1\"; urchinTracker(\"/GN2/{$ns}\");</script>\n";

		if (in_array($ns, array(0, 220)))
		$out .= "<script type=\"text/javascript\">_uff=0; _uacct=\"UA-12241505-1\"; urchinTracker(\"/GN4/{$ns}/{$wgTitle->getArticleID()}\");</script>\n";

		return $out;
	}
}
