<?php

$wgHooks["MakeGlobalVariablesScript"][] = "wfPartnerWidgetJSVars";

function wfPartnerWidgetJSVars($vars) {
	global $wgEnablePartnerWidget;
	if ($wgEnablePartnerWidget) {
		$vars['partnerKeywords'] = getPartnerWidgetKeywords();
	}

	return true;
}

function getPartnerWidgetKeywords() {
	global $wgTitle, $wgDBname, $wgOut;
	
	$keywords = null;

	switch ($wgDBname) {
		case 'hotwheels':
			$HOTWHEELS = 'Hot Wheels';
			$LIST_OF = 'List of ';
			$CATEGORY_PREFIX_HOTWHEELSBY = 'Hot Wheels by';
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
		default:
	}

	return $keywords;
}
