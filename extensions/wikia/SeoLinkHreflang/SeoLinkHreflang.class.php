<?php

/**
 * Add hreflang links to boost traffic on Japanese Star Wars wiki
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
	 * Link based on static array supplied in $mapping param
	 *
	 * @param OutputPage $out
	 * @param array $mapping (keys used: langTo, urlPrefix and mapping)
	 * @return array (key: lang, value: url)
	 */
	private static function getStaticMappingLinks( OutputPage $out, $mapping ) {
		$articleMapping = $mapping[ 'mapping' ];
		$langTo = $mapping[ 'langTo' ];
		$urlPrefix = $mapping[ 'urlPrefix' ];

		$dbKey = $out->getTitle()->getDBkey();

		if ( !empty( $articleMapping[ $dbKey ] ) ) {
			return [ $langTo => $urlPrefix . $articleMapping[ $dbKey ] ];
		}

		return [];
	}

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

		if ( !empty( $mapping[ $wiki ][ $lang ] ) ) {
			unset( $mapping[ $wiki ][ $lang ] );
			return $mapping[ $wiki ];
		}

		return [];
	}

	private static function generateHreflangLinks( OutputPage $out ) {
		global $wgDBname;

		$links = [];

		if ( $wgDBname === 'starwars' || $wgDBname === 'jastarwars' ) {
			$mapping = require( __DIR__ . '/starwars_mapping.php' );
			$links = self::getStaticMappingLinks( $out, $mapping[ $wgDBname ] );
		} else if ( $out->getTitle()->isMainPage() ) {
			$links = self::getMainPageLinks( $_SERVER['HTTP_HOST'] );
		}

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
