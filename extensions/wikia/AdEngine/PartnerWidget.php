<?php

$wgHooks["MakeGlobalVariablesScript"][] = "wfPartnerWidgetJSVars";

function wfPartnerWidgetJSVars(Array &$vars) {
	global $wgEnablePartnerWidget;
	if ($wgEnablePartnerWidget) {
		$vars['partnerKeywords'] = PartnerWidget::getPartnerWidgetKeywords();
	}

	return true;
}

class PartnerWidget {
	public static function getPartnerWidgetKeywords() {
		global $wgTitle, $wgDBname, $wgOut;

		$keywords = null;

		switch ($wgDBname) {
			case 'hotwheels':
				$HOTWHEELS = 'Hot Wheels';
				$LIST_OF = 'List of ';
				$CATEGORY_PREFIX_HOTWHEELSBY = 'Hot Wheels by';

				$keywords = $wgTitle->getText();

				if (stripos($keywords, $LIST_OF) === 0) {
					$keywords = substr($keywords, strlen($LIST_OF));
				}
				else {
					$hotwheelsbyPos = stripos($keywords, $CATEGORY_PREFIX_HOTWHEELSBY);
					if ($hotwheelsbyPos !== FALSE) {
						$keywords = substr($keywords, $hotwheelsbyPos+strlen($CATEGORY_PREFIX_HOTWHEELSBY));
					}
				}

				if (stripos($keywords, $HOTWHEELS) === FALSE) {
					$keywords = $HOTWHEELS . ' ' . $keywords;
				}

				break;
			case 'ipod': // apple.wikia.com
				$cats = $wgOut->getCategories();
				foreach ($cats as $cat) {
					switch (strtolower($cat)) {
						case 'apple hardware':
						case 'apple lineup':
						case 'macintosh ii':
						case 'macintosh lc':
						case 'mac models':
						case 'modular macs':
						case 'old stuff':
						case 'portable computers':
						case 'portable macs':
						case 'powerbook g4':
						case 'power macintosh':
						case 'power macintosh g3':
						case 'power macintosh g4':
							$keywords = $wgTitle->getText();
							break 2; // break out of foreach
						default:
					}
				}
				break;
			case 'muppet':
				$MUPPET_PREFIX = 'muppet';
				$SESAME_STREET_PREFIX = 'sesame street';

				$cats = $wgOut->getCategories();
				foreach ($cats as $cat) {
					$lowercaseCat = strtolower($cat);
					switch ($lowercaseCat) {
						case 'muppet characters':
							$keywords = $MUPPET_PREFIX . ' ' . $wgTitle->getText();
							$keywords = self::stripParentheticalSubstring($keywords);
							break 2; // break out of foreach
						case 'sesame street characters':
							$keywords = $SESAME_STREET_PREFIX . ' ' . $wgTitle->getText();
							$keywords = self::stripParentheticalSubstring($keywords);
							break 2; // break out of foreach
						default:
							if (stripos($lowercaseCat, 'albums') !== FALSE
							|| stripos($lowercaseCat, 'books') !== FALSE
							|| stripos($lowercaseCat, 'buttons') !== FALSE
							|| stripos($lowercaseCat, 'clothing') !== FALSE
							|| stripos($lowercaseCat, 'collectibles') !== FALSE
							|| stripos($lowercaseCat, 'figures') !== FALSE
							|| stripos($lowercaseCat, 'merchandise') !== FALSE
							|| stripos($lowercaseCat, 'paper products') !== FALSE
							|| stripos($lowercaseCat, 'pins') !== FALSE
							|| stripos($lowercaseCat, 'plush') !== FALSE
							|| stripos($lowercaseCat, 'puzzles') !== FALSE
							|| stripos($lowercaseCat, 'supplies') !== FALSE
							|| stripos($lowercaseCat, 'toys') !== FALSE
							|| stripos($lowercaseCat, 'video games') !== FALSE
							|| stripos($lowercaseCat, 'watches') !== FALSE
							) {
								$keywords = $wgTitle->getText();
								$keywords = self::stripParentheticalSubstring($keywords);
								break 2; // break out of foreach
							}
					}
				}
				break;
			//case 'vintagepatterns':
				//if ($wgTitle->getNamespace() == NS_CATEGORY) {
					//$keywords = $wgTitle->getText();
				//}
				//elseif (in_array('Vintage Sewing Patterns', $wgOut->getCategories())) {
					//$keywords = $wgTitle->getText();
					// strip trailing "A", "B", etc.
					//if (preg_match('/ [A-Za-z]$/', $keywords)) {
						//$keywords = substr($keywords, 0, strlen($keywords)-2);
					//}
				//}
				//break;
			case 'yugioh':
				$CATEGORY_WHITELIST_INDICATOR = 'card';

				// show widget only on articles in whitelisted categories
				$cats = $wgOut->getCategories();
				foreach ($cats as $cat) {
					if (stripos($cat, $CATEGORY_WHITELIST_INDICATOR) !== FALSE) {
						$keywords = $wgDBname . ' ' . $wgTitle->getText();
						$keywords = self::stripParentheticalSubstring($keywords);
					}
					break;
				}
				break;
		}

		return $keywords;
	}

	/**
	 * If input string has parentheses and anything afterward, then strips
	 * whitespace around that string. For example, if input is
	 * "Title (subtitle) description", result is "Title".
	 * @param string $str
	 * @return string
	 */
	private static function stripParentheticalSubstring($str) {
		$STRIP_SUBSTRING_FIRST_CHAR = '(';
		$stripSubstrPos = strpos($str, $STRIP_SUBSTRING_FIRST_CHAR);
		if ($stripSubstrPos !== FALSE) {
			$str = trim(substr($str, 0, $stripSubstrPos));
		}

		return $str;
	}
}
