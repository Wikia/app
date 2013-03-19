<?php

class AnalyticsProviderAmazonDirectTargetedBuy implements iAnalyticsProvider {

	private static $code = <<< SCRIPT
		<script>
			(function() {
				var aax_src='3006';
				var aax_url = encodeURIComponent(document.location);
				try { aax_url = encodeURIComponent("" + window.top.location); } catch(e) {}
				var s = document.createElement('script');
				s.type = 'text/javascript';
				s.async = true;
				s.src = '//aax-us-east.amazon-adsystem.com/e/dtb/bid?src=' + aax_src + '&u=' + aax_url + "&cb=" + Math.round(Math.random()*10000000);
				var insertLoc = document.getElementsByTagName('script')[0];
				insertLoc.parentNode.insertBefore(s, insertLoc);
			})();
		</script>
SCRIPT;

	public function getSetupHtml($params = array()) {
		static $called = false;

		$code = '';

		if (!$called) {
			$called = true;

			if (F::app()->wg->EnableAmazonDirectTargetedBuy) {
				$code = self::$code;
			}

/** FAKE CODE BELOW, REMOVE WHEN NOT NEEDED */
if (F::app()->wg->EnableAmazonDirectTargetedBuyFake) {
$code = <<< FAKE
<script>
function amzn_Ads(data) {
	document.amzn_Ads = data.Ads;
		try {
		   window.amzn_targs = "";
		   for(var slot in data.Ads) {
			   window.amzn_targs += slot + "=1;";
		   }
		} catch(e) {}
}

function amzn_render(slot) {
	try {
		var ad = document.amzn_Ads[slot];
		if(ad!=null) document.writeln(ad);
	} catch(e) {}
}

amzn_Ads({
   "Ads":{
		  "amzn_728x90": "<div style='width: 728px; height:  90px; background: #000; color: #fff; font-size: 20px'>Fake amazon test ad 728x90 </iframe>",
		  "amzn_300x250":"<div style='width: 300px; height: 250px; background: #000; color: #fff; font-size: 20px'>Fake amazon test ad 300x250</iframe>",
   },
	"status":"ok"
});
</script>
FAKE;
}
/** FAKE CODE ABOVE, REMOVE WHEN NOT NEEDED */

		}

		return $code;
	}

	public function trackEvent($event, $eventDetails = array()) {
		return '';
	}
}
