<?php

/**
 * Add hreflang links to boost traffic on Star Wars wiki family
 *
 * Add hreflang links to main pages of selected wikis
 *
 * This is an experiment and we'll either extend it to all wikis and languages or remove this
 *
 * @link https://wikia-inc.atlassian.net/browse/SEO-65
 * @link https://wikia-inc.atlassian.net/browse/SEO-57
 * @link https://support.google.com/webmasters/answer/189077?hl=pl
 */
class SeoLinkHreflang {
	const SEO_LINK_SECTION_BEGIN = '<!-- Alternate languages begin -->';
	const SEO_LINK_SECTION_END = '<!-- Alternate languages end -->';

	/**
	 * Get links to the main pages of the same wiki in other languages
	 * Based on static mapping in mainpages_mapping.php
	 *
	 * @return array (key: lang, value: url)
	 */
	private static function getMainPageLinks( $domain ) {
		// Get the language and the wiki name from the domain in the following formats:
		// <wiki>.wikia.com -- muppet.wikia.com
		// <prefix>.<wiki>.wikia.com -- fr.muppet.wikia.com or preview.muppet.wikia.com
		// <prefix1>.<prefix2>.<wiki>.wikia.com -- preview.fr.muppet.wikia.com
		// <wiki>.<devbox>.wikia-dev.com -- muppet.rychu.wikia-dev.com
		// <prefix>.<devbox>.wikia-dev.com -- fr.muppet.rychu.wikia-dev.com
		$matching = preg_match( '/(?:([a-z-]+)\.)?([a-z]+)\.(?:[a-z]+\.wikia-dev|wikia)\.com$/', $domain, $m );

		if ( !$matching ) {
			return [];
		}

		$wiki = $m[2];
		$lang = $m[1];
		$validLang = !empty( $lang ) && ( $lang === 'pt-br' || strlen( $lang ) <= 3 );
		if ( !$validLang ) {
			$lang = 'en';
		}

		$mapping = require __DIR__ . '/mainpages_mapping.php';

		if ( !empty( $mapping[$wiki][$lang] ) ) {
			return $mapping[$wiki];
		}

		return [];
	}

	private static function getLillyLinks( $url ) {
		$lilly = new Lilly();
		//$url = str_replace( '.rychu.wikia-dev.com', '.wikia.com', $url );
		return $lilly->getCluster( $url );
	}

	private static function generateHreflangLinks( OutputPage $out ) {
		global $wgEnableLillyExt, $wgArticle;

		$title = $out->getTitle();

		// No mapping for redirect pages
		if ( empty( $wgArticle ) || !empty( $wgArticle->mRedirectedFrom ) ) {
			return [];
		}

		$links = [];

		if ( $wgEnableLillyExt ) {
			$links = self::getLillyLinks( $title->getFullURL() );
		} else if ( $title->isMainPage() ) {
			$links = self::getMainPageLinks( $_SERVER['HTTP_HOST'] );
		}

		// Remove link to self
		$lang = $title->getPageLanguage()->getCode();
		unset( $links[$lang] );

		return array_map( function ( $lang, $url ) {
			return Html::element( 'link', [
				'rel' => 'alternate',
				'hreflang' => $lang,
				'href' => $url,
			] );
		}, array_keys( $links ), array_values( $links ) );
	}

	public static function onOutputPageBeforeHTML( OutputPage $out, $text ) {
		$links = self::generateHreflangLinks( $out );
		if ( count( $links ) > 0 ) {
			array_unshift( $links, self::SEO_LINK_SECTION_BEGIN );
			array_push( $links, self::SEO_LINK_SECTION_END );
			$out->addHeadItem( 'SeoLinkHreflang', "\t" . join( "\n\t", $links ) . "\n" );
		}
		return true;
	}
}
