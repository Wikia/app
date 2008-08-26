<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'OpenX ad provider for AdEngine',
);

class AdProviderOpenX implements iAdProvider {

	protected static $instance = false;

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderOpenX();
		}
		return self::$instance;
	}

	private $zoneIds = array(	'HOME_TOP_LEADERBOARD' => 626,
								'HOME_TOP_RIGHT_BOXAD' => 627,
								'HOME_LEFT_SKYSCRAPER_1' => 628,
								'HOME_LEFT_SKYSCRAPER_2' => 629,
								'TOP_LEADERBOARD' => 630,
								'TOP_RIGHT_BOXAD' => 631,
								'LEFT_SKYSCRAPER_1' => 632,
								'LEFT_SKYSCRAPER_2' => 633,
								'FOOTER_BOXAD' => 634,
								'LEFT_SPOTLIGHT_1' => 635,
								'FOOTER_SPOTLIGHT_LEFT' => 636,
								'FOOTER_SPOTLIGHT_MIDDLE' => 637,
								'FOOTER_SPOTLIGHT_RIGHT' => 638);

	public function getAd($slotname, $slot) {

		if(empty($this->zoneIds[$slotname])) {
			throw new Exception();
		}

		$zoneId = $this->zoneIds[$slotname];

		$adtag = <<<EOT
<!-- AdProviderOpenX slot: $slotname zoneid: $zoneId  -->
<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://wikia-ads.wikia.com/www/delivery/ajs.php':'http://wikia-ads.wikia.com/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=$zoneId");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script>
EOT;
		return $adtag;

	}

}