<?php

class DataTables {
	const DATA_PORTABLE_ATTRIBUTE = 'data-portable';

	/**
	 * Mark wikitext tables coming from templates, so we can distinguish them on tables parse step
	 *
	 * @param $wikitext
	 *
	 * @return mixed
	 */
	public static function markTranscludedTables( $wikitext ) {
		//check for tables
		if ( preg_match_all( "/\\{\\|(.*)/\n", $wikitext, $matches ) ) {
			foreach ( $matches[ 1 ] as $key => $match ) {
				$wikitext = str_replace( $matches[ 0 ][ $key ], static::markTable( $match ), $wikitext );
			}
		}

		return $wikitext;
	}

	public static function markDataTables( $html ) {
		wfProfileIn( __METHOD__ );

		$document = new DOMDocument();
		$document->loadHTML( $html );

		$tables = $document->getElementsByTagName( 'table' );
		if ( $tables->length > 0 ) {
			$xpath = new DOMXPath( $document );
			/** @var DOMElement $table */
			foreach ( $tables as $table ) {
				if ( !$table->hasAttribute( static::DATA_PORTABLE_ATTRIBUTE ) &&
					 $xpath->query( '*//*[@rowspan]|//*[@colspan]', $table )->length == 0
				) {
					$table->setAttribute( 'data-portable', 'true' );
				}
			}
			// strip html and body tags
			preg_match( '/<body>(.*)<\\/body>/sU', $document->saveHTML(), $match );

			wfProfileOut( __METHOD__ );

			return isset( $match[ 1 ] ) ? $match[ 1 ] : $html;
		}

		wfProfileOut( __METHOD__ );

		return $html;
	}

	private static function markTable( $attributes, $portable = false ) {
		if ( mb_stripos( $attributes, self::DATA_PORTABLE_ATTRIBUTE ) !== false ) {
			return "{|" . $attributes;
		}
		$p = $portable ? "true" : "false";

		return "{| " . self::DATA_PORTABLE_ATTRIBUTE . "=\"{$p}\" " . $attributes;
	}
}
