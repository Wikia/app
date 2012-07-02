<?php
/**
 * Hooks for ShortUrl for adding link to toolbox
 *
 * @file
 * @ingroup Extensions
 * @author Yuvi Panda, http://yuvi.in
 * @copyright © 2011 Yuvaraj Pandian (yuvipanda@yuvi.in)
 * @licence Modified BSD License
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

class ShortUrlHooks {
	/**
	 * @param $tpl
	 * @return bool
	 */
	public static function addToolboxLink( &$tpl ) {
		global $wgShortUrlPrefix;

		if ( !is_string( $wgShortUrlPrefix ) ) {
			$urlPrefix = SpecialPage::getTitleFor( 'ShortUrl' )->getFullUrl() . '/';
		} else {
			$urlPrefix = $wgShortUrlPrefix;
		}

		$title = $tpl->getSkin()->getTitle();
		if ( ShortUrlUtils::needsShortUrl( $title ) ) {
			$shortId = ShortUrlUtils::encodeTitle( $title );
			$shortURL = $urlPrefix . $shortId;
			$html = Html::rawElement( 'li',	array( 'id' => 't-shorturl' ),
				Html::Element( 'a', array(
					'href' => $shortURL,
					'title' => wfMsg( 'shorturl-toolbox-title' )
				),
				wfMsg( 'shorturl-toolbox-text' ) )
			);

			echo $html;
		}
		return true;
	}

	/**
	 * @param $out OutputPage
	 * @param $text string the HTML text to be added
	 * @return bool
	 */
	public static function onOutputPageBeforeHTML( &$out, &$text ) {
		$title = $out->getTitle();
		if ( ShortUrlUtils::needsShortUrl( $title ) ) {
			$out->addModules( 'ext.shortUrl' );
		}
		return true;
	}

	/**
	 * @param $du DatabaseUpdater
	 * @return bool
	 */
	public static function setupSchema( DatabaseUpdater $du ) {
		$base = dirname( __FILE__ ) . '/schemas';
		$du->addExtensionTable( 'shorturls', "$base/shorturls.sql" );
		return true;
	}

}

