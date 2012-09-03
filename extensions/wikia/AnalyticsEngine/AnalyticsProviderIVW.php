<?php

class AnalyticsProviderIVW implements iAnalyticsProvider {
	function getSetupHtml($params = array()) {
		return null;
	}

	function trackEvent($event, $eventDetails = array()) {
		// IVW is de-only tracking
		if (F::app()->wg->Title->getPageLanguage()->getCode() != 'de') {
			return '<!-- Unsupported language for ' . __CLASS__ . ' -->';
		}

		switch ($event) {
			case AnalyticsEngine::EVENT_PAGEVIEW: 
				$url = "http://gastar.ivwbox.de/cgi-bin/ivw/CP/" . $this->getTag();
				
				return '<!-- *IVW PIXEL* -->
<!-- ************** IVW begin **************  -->
<!-- SZM VERSION="1.5" -->
<script type="text/javascript">
<!--
	var IVW = "' . $url . '";
	document.write("<img src=\""+IVW+"?r="+escape(document.referrer)+"&d="+(Math.random()*100000)+"\" width=\"1\" height=\"1\" alt=\"szmtag\" style=\"display:none\" />");
//-->
</script>
<noscript>
<img src="' . $url . '" width="1" height="1" alt="szmtag" />
</noscript>
<!-- /SZM -->
<!-- ************** IVW end **************  -->';
				break;
			default:
				return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	private function getTag() {
		$dbname = F::app()->wg->DBname;		

		$t = F::app()->wg->Title;
		$title = $t->getText();

		if ($dbname == 'dehauptseite') {
			if (Wikia::isMainPage()) return 'RC_WIKIA_HOME';

			if (strpos($title, 'Mobil') === 0) return 'RC_WIKIA_MOBIL';
			if (in_array($title, array('Videospiele', 'Entertainment', 'Lifestyle'))) return 'RC_WIKIA_START';
			
			if (WikiaPageType::getPageType() == 'search') return 'RC_WIKIA_SEARCH';

			return 'RC_WIKIA_SVCE';
		}
		
		if ($dbname == 'de') {
			if ($t->getNamespace() == NS_FORUM) return 'RC_WIKIA_PIN';
			
			return 'RC_WIKIA_COMMUNITY';
		}

		if (HubService::getComscoreCategory(F::app()->wg->CityId)->cat_name == 'Entertainment') return 'RC_WIKIA_UGCENT';

		return 'RC_WIKIA_UGC';
	}
}