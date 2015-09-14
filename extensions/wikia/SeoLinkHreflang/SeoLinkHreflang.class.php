<?php

/**
 * Add hreflang links to boost traffic on Japanese Star Wars wiki
 *
 * This is an experiment and we'll either extend it to all wikis and languages or remove this
 *
 * @link https://wikia-inc.atlassian.net/browse/SEO-65
 * @link https://support.google.com/webmasters/answer/189077?hl=pl
 */
class SeoLinkHreflang {

	private static function generateHreflangLink( OutputPage $out ) {
		global $wgDBname;

		if ( $wgDBname !== 'starwars' ) {
			return;
		}

		$dbKey = $out->getTitle()->getDBkey();
		$mapping = require __DIR__ . '/starwars_en_ja_mapping.php';

		if ( !empty( $mapping[ $dbKey ] ) ) {
			return Html::element( 'link', [
				'rel' => 'alternate',
				'hreflang' => 'ja',
				'href' => 'http://ja.starwars.wikia.com/wiki/' . $mapping[ $dbKey ],
			] );
		}
	}

	public static function onOutputPageBeforeHTML( OutputPage $out, $text ) {
		$link = self::generateHreflangLink( $out );
		if ( $link ) {
			$out->addHeadItem( 'SeoLinkHreflang', "\t" . $link . PHP_EOL );
		}
		return true;
	}
}
