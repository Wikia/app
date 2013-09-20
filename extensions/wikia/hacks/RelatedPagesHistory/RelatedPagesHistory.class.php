<?php

/**
 * RelatedPagesHistory
 * @author Jakub "Szeryf" Kurcek
 */

class RelatedPagesHistory {

	public static function onBeforePageDisplay( &$out, &$skin ) {

		$app = F::app();
	
		$jsMimeType = $app->wg->JsMimeType;
		$extensionsPath = $app->wg->ExtensionsPath;
		$styleVersion = $app->wg->StyleVersion;
		
		$out->addScript("<script type=\"{$jsMimeType}\" src=\"{$extensionsPath}/wikia/hacks/RelatedPagesHistory/js/RelatedPagesHistory.js?{$styleVersion}\" ></script>\n");
		return true;
	}
}

