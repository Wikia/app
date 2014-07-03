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
		$script = <<<SCRIPT2
<script type="text/javascript">
  function getCustomVarPage() {
    if (window.wgIsMainpage) return 'mainpage';

    return 'other';
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

  _gaq.push(['_setCustomVar', 1, 'wiki', 'hub=' + (window.wgVerticalId || 'unknown') + ';lang=' + (window.wgContentLanguage || 'unknown') + ';slot=' + (getCustomVarSlot() || 'unknown'), 3]);
  _gaq.push(['_setCustomVar', 2, 'page', (getCustomVarPage() || 'unknown'), 3]);
  _gaq.push(['_setCustomVar', 4, 'skin',  window.skin || 'unknown', 3]);
  _gaq.push(['_setCustomVar', 5, 'user', (window.wgUserName == null) ? 'anon' : 'user', 3]);

  $setDomainName

  _gaq.push(['_trackPageview']);

  _gaq.push(['Ads._setAccount', 'UA-17475676-7']);
  _gaq.push(['Ads._setSampleRate', '100']);

  _gaq.push(['Ads._setCustomVar', 1, 'wiki', 'hub=' + (window.wgVerticalId || 'unknown') + ';lang=' + (window.wgContentLanguage || 'unknown') + ';slot=' + (getCustomVarSlot() || 'unknown'), 3]);
  _gaq.push(['Ads._setCustomVar', 2, 'page', (getCustomVarPage() || 'unknown'), 3]);
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
		return ''; // NOP
	}
}
