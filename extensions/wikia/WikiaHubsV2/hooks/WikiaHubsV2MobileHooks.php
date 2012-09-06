<?php

/**
 * Hubs V2 Hook Handlers
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class WikiaHubsV2Mobile {
	public static function onWikiaMobileAssetsPackages( Array &$jsHeadPackages, Array &$jsBodyPackages, Array &$scssPackages ) {
		//this hook is fired only by the WikiaMobile skin, no need to check for what skin is being used
		if ( F::app()->wg->EnableWikiaHubsExt && WikiaPageType::isWikiaHub() ) {
			$scssPackages[] = 'wikiahubs_scss_wikiamobile';
		}

		return true;
	}
}
