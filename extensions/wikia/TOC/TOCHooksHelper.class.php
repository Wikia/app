<?php

class TOCHooksHelper {

	/**
	 * Overwrite MediaWiki TOC with Wikia TOC
	 *
	 * @param {String} $title - TOC title
	 * @param {String} $toc - Media Wiki TOC HTML
	 * @return bool
	 */

	public static function onOverwriteTOC( &$title, &$toc ) {

        $app = F::app();
		$isWikiaMobile = $app->checkSkin( 'wikiamobile' );

		if ( !empty( $toc ) && !$isWikiaMobile ) {
			$toc = $app->renderView( 'TOCController', 'index' );
		} else if ( $isWikiaMobile ) {
			$toc = '';
		}

		return true;
	}

	/**
	 * Add TOC js assets to Oasis
	 * @param $assetsArray
	 */
	public static function onOasisSkinAssetGroups( &$assetsArray ) {

		$title = F::app()->wg->title;

		if ( !$title->isSpecialPage() ) {
			$assetsArray[] = 'toc_js';
		}

	}
}
