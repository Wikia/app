<?php

/**
 * Add hreflang links to main pages of wikis sharing a domain
 *
 * @link https://support.google.com/webmasters/answer/189077
 */
class SeoLinkHreflang {
	public static function getMainPageLinks() {
		global $wgServer;

		$url = parse_url( $wgServer );
		$languageWikis = WikiFactory::getWikisUnderDomain( $url['host'], true );

		$links = [];

		foreach ( $languageWikis as $wiki ) {
			$mainPageTitle = GlobalTitle::newMainPage( $wiki['city_id'] );

			if ( $mainPageTitle->exists() ) {
				$links[ $wiki['city_lang'] ] = $mainPageTitle->getFullURL();
			}
		}

		return $links;
	}

	private static function generateHreflangLinks( OutputPage $out ) {
		$title = $out->getTitle();
		$article = Article::newFromTitle( $title, $out->getContext() );

		if ( !empty( $article->mRedirectedFrom ) || !$title->isMainPage() ) {
			return [];
		}

		$links = static::getMainPageLinks();

		return array_map( function ( $lang, $url ) {
			return Html::element( 'link', [
				'rel' => 'alternate',
				'hreflang' => $lang,
				'href' => $url,
			] );
		}, array_keys( $links ), array_values( $links ) );
	}

	public static function onOutputPageBeforeHTML( OutputPage $out/*, $text*/ ) {
		global $wgServer;

		// Add hreflang links only on domains where we have language wikis share the root domain
		if ( !wfHttpsEnabledForURL( $wgServer ) ) {
			return true;
		}

		$links = static::generateHreflangLinks( $out );

		if ( count( $links ) > 0 ) {
			$out->addHeadItem( 'SeoLinkHreflang', "\t" . join( "\n\t", $links ) . "\n" );
		}

		return true;
	}
}
