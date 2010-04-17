<?php

class AnalyticsProviderComscore implements iAnalyticsProvider {

	function getSetupHtml(){
		return null;
	}

	function trackEvent($event, $eventDetails=array()){
		switch ($event){
		  case AnalyticsEngine::EVENT_PAGEVIEW : return '
<!-- Begin comScore Tag -->
<script type="text/javascript">
document.write(unescape("%3Cscript src=\'" + (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js\' %3E%3C/script%3E"));
</script>
<script type="text/javascript">
COMSCORE.beacon({
  c1:2,
  c2:6177433,
  c3:"",
  c4:"",
  c5:"",
  c6:"",
  c15:""
});
</script>
<noscript>
<img src="http://b.scorecardresearch.com/p?c1=2&amp;c2=6177433&amp;c3=&amp;c4=&amp;c5=&amp;c6=&amp;c15=&amp;cj=1" />
</noscript>
<!-- End comScore Tag -->';
			break;
                  default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}


}
