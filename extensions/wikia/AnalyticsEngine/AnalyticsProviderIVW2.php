<?php

class AnalyticsProviderIVW2 implements iAnalyticsProvider {
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
				$code = $this->getTag();

				return '<script type="text/javascript" src="https://script.ioam.de/iam.js"></script>

<!-- SZM VERSION="2.0" -->
<script type="text/javascript">
var iam_data = {
"mg":"yes", // Migrationsmodus AKTIVIERT
"st":"gastar", // site/domain
"cp":"' . $code . '", // code
"oc":"' . $code . '", // code SZM-System 1.5
"sv":"ke" // FRABO-Tag deaktiviert
}

iom.c(iam_data, 2);
</script>
<!-- /SZM -->';
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
			if (in_array($title, array('Videospiele', 'Entertainment', 'Lifestyle', 'Entertainment/Anime'))) return 'RC_WIKIA_START';

			if (WikiaPageType::getPageType() == 'search') return 'RC_WIKIA_SEARCH';

			return 'RC_WIKIA_SVCE';
		}

		if ($dbname == 'de') {
			if ($t->getNamespace() == NS_FORUM) return 'RC_WIKIA_PIN';

			return 'RC_WIKIA_COMMUNITY';
		}

		if (strpos(F::app()->wg->DartCustomKeyValues, 'anime') !== false) return 'RC_WIKIA_UGCANIME';

		$cat_name = HubService::getCategoryInfoForCurrentPage()->cat_name;
		if ($cat_name == 'Entertainment') return 'RC_WIKIA_UGCENT';
		if ($cat_name == 'Gaming') return 'RC_WIKIA_UGCGAMES';
		if ($cat_name == 'Lifestyle') return 'RC_WIKIA_UGCLIFESTYLE';

		return 'RC_WIKIA_UGC';
	}
}
