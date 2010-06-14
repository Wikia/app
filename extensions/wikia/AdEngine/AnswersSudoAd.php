<?php

$wgHooks["fillInAdPlaceholder"][] = "AnswersSudoAd::getAd";

$wgExtensionMessagesFiles["AnswersSudoAd"] = dirname(__FILE__) . "/AnswersSudoAd.i18n.php";

class AnswersSudoAd {

	static public function getAd($placeholdertype, $slotname, $AdEngine, $html) {
		if (("HOME_TOP_LEADERBOARD" != $slotname) && ("TOP_LEADERBOARD" != $slotname)) return true;

		$var = "wgAdslot_{$slotname}";
		if (!empty($GLOBALS[$var]) && "null" == strtolower($GLOBALS[$var])) return true;

		global $wgUser;
		if (empty($_GET["showads"]) && is_object($wgUser) && $wgUser->isLoggedIn() && !$wgUser->getOption("showAds")) return true;
						 
		wfLoadExtensionMessages("AnswersSudoAd");

		$html = wfMsgForContent("asa-leaderboard");
		if (empty($html)) {
			$html = self::getImgAd();
			$html = '<div id="' . htmlspecialchars($slotname) . '" class="noprint">' . $html . '</div>';
			return true;
		}

		if (preg_match_all("/ASA::([A-Z0-9_]+)/", $html, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				list($placeholder, $HPL) = $match;
				$data = self::getHPL($HPL);

				if (empty($data)) {
					$html = self::getImgAd();
					$html = '<div id="' . htmlspecialchars($slotname) . '" class="noprint">' . $html . '</div>';
					return true;
				}

				$html = str_replace($placeholder, $data, $html);
				$html = '<div id="' . htmlspecialchars($slotname) . '" class="noprint">' . $html . '</div>';
			}
		}

		return true;
	}

	static public function getHPL($name) {
		$name = strtolower($name);

		global $wgContLang, $wgAnswersURLs;
		$domain = Wikia::langToSomethingMap($wgAnswersURLs, $wgContLang->getCode(), "{$wgContLang->getCode()}.answers.wikia.com");

		global $wgWidgetAnswersForceDomain;
		if (!empty($wgWidgetAnswersForceDomain)) $domain = $wgWidgetAnswersForceDomain;

		$dbname = WikiFactory::DomainToDB($domain);

		global $wgMemc;
		$mkey =  wfForeignMemcKey($dbname, "", "HPL", $name);
		$html = $wgMemc->get($mkey);
		$html = str_replace("href=\"/wiki", "href=\"http://{$domain}/wiki", $html);
		$html = str_replace("WET.byStr('", "WET.byStr('asa-", $html);

		return $html;
	}

	static public function getImgAd() {
		wfLoadExtensionMessages("AnswersSudoAd");

		$list = wfMsgForContent("asa-leaderboard-list");
		if (empty($list)) return "";

		if (!preg_match_all("/http[^\s]+\.(?:png|jpg|jpeg)/", $list, $matches)) return "";

		$images = $matches[0];
		$html = wfMsgForContent("asa-leaderboard-image", $images[array_rand($images)]);
		return $html;
	}
}
