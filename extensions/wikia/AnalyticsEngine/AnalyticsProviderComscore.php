<?php

class AnalyticsProviderComscore implements iAnalyticsProvider {

	private $account = 'p-8bG6eLqkH6Avk';

	function getSetupHtml(){
		return null;
	}

	function trackEvent($event, $eventDetails=array()){
		switch ($event){
		  case AnalyticsEngine::EVENT_PAGEVIEW : return '
<!-- Begin comScore Tag -->
<script type="text/javascript">
setTimeout(function(){ var url = "http" + (/^https:/.test(document.location.href) ? "s" : "") + "://beacon.scorecardresearch.com/scripts/beacon.dll" + "?c1=2&c2=6177433&c3=&c4=&c5=&c6=&c7=" + escape(document.location.href) + "&c8=" + escape(document.title) + "&c9=" + escape(document.referrer) + "&c10=" + escape(screen.width+\'x\'+screen.height) + "&rn=" + (new Date()).getTime(); var i = new Image(); i.src = url; }, 1);
</script>
<noscript>
<img src="http://beacon.scorecardresearch.com/scripts/beacon.dll?c1=2&c2=6177433&c3=&c4=&c5=&c6=&c7=&x=NOJAVASCRIPT" alt="" />
</noscript>
<!-- End comScore Tag -->'; 
			break;
                  default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}


}
