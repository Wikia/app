<?php

class AnalyticsProviderDynamicYield implements iAnalyticsProvider {

	private static $code = <<< SCRIPT
		<!-- BEGIN DY SCRIPT TAG FOR SECTION 8765242 - DO NOT MODIFY -->
		<script type='text/javascript'>
			DY = {scsec : 8765242, sclayout:'default'};
			(function(){var d=document,e='createElement',a='appendChild',g='getElementsByTagName',i=d[e]('iframe');
			i.id=i.name='DY-iframe'; i.style.display='none'; i.width=i.height='1px';d[g]('body')[0][a](i);
			DY.x = function(w) { var d=w.document, s=d[e]('script');s.type='text/javascript'; s.async=true;
			s.src=('https:'==d.location.protocol?'http://st.dynamicyield.com'.replace('http:','https:') : 'http://st.dynamicyield.com')+'/ast?sec='+DY.scsec+'&l='+DY.sclayout;
			d[g]('head')[0][a](s);}; var c = i.contentWindow.document;
			c.open().write('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><body onload="parent.DY.x(window)" style="margin:0"></'+'body></html>');
			c.close();})();
		</script>
		<!-- END TAG -->
SCRIPT;

	public function getSetupHtml($params = array()) {
		static $called = false;

		$code = '';

		if (!$called) {
			$called = true;

			if (F::app()->wg->EnableDynamicYield
				&& F::app()->wg->ShowAds
				&& AdEngine2Service::areAdsShowableOnPage()
			) {
				$code = self::$code;
			}
		}

		return $code;
	}

	public function trackEvent($event, $eventDetails = array()) {
		return '';
	}
}
