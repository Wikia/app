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

		if (!empty($toc)) {
			$toc = F::app()->renderView('TOCCOntroller', 'index');
		}

		return true;
	}

	/** Add assets */

	private static function addAssets( &$assetsArray ) {

		$title = F::app()->wg->title;

		if ( !$title->isSpecialPage() ) {
			$assetsArray[] = 'toc_js';
		}
		return true;
	}

	/** Add TOC js assets to Oasis */

	public static function onOasisSkinAssetGroups( &$assetsArray ) {

		self::addAssets( $assetsArray );

		return true;
	}

	/** Add TOC js assets to Monobook */

	public static function onMonobookSkinAssetGroups( &$assetsArray ) {

		self::addAssets( $assetsArray );

		return true;
	}
}
