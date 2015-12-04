<?php

class DataTables {
	const DATA_PORTABLE_ATTRIBUTE = 'data-portable';

	/**
	 * Mark wikitext tables coming from templates, so we can distinguish them on tables parse step
	 *
	 * @param $wikitext
	 * @param $finalTitle
	 *
	 * @return mixed
	 */
	public static function markTranscludedTables( &$wikitext, &$finalTitle ) {
		wfProfileIn( __METHOD__ );
		//check for tables
		if ( static::shouldBeProcessed() && preg_match_all( "/\\{\\|(.*)/\n", $wikitext, $matches ) ) {
			foreach ( $matches[ 1 ] as $key => $match ) {
				$wikitext = str_replace( $matches[ 0 ][ $key ], static::markTable( $match ), $wikitext );
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * Mark data tables with data-portable attribute after parsing
	 *
	 * @param $html
	 *
	 * @return mixed
	 */
	public static function markDataTables( &$html ) {
		wfProfileIn( __METHOD__ );

		if ( static::shouldBeProcessed() ) {
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

				// strip <html> and <body> tags
				$result = [ ];
				$bodyElements = $xpath->query( '/html/body/*' );
				for ( $i = 0; $i < $bodyElements->length; $i++ ) {
					$result[] = $document->saveXML( $bodyElements->item( $i ) );
				}

				wfProfileOut( __METHOD__ );

				$html = !empty( $result ) ? implode( "", $result ) : $html;
			}

			// clear user generated html parsing errors
			libxml_clear_errors();
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	private static function shouldBeProcessed() {
		global $wgEnableDataTablesParsing, $wgArticleAsJson;

		return $wgEnableDataTablesParsing && $wgArticleAsJson;
	}

	private static function markTable( $attributes, $portable = false ) {
		if ( mb_stripos( $attributes, self::DATA_PORTABLE_ATTRIBUTE ) !== false ) {
			return "{|" . $attributes;
		}
		$p = $portable ? "true" : "false";

		return "{| " . self::DATA_PORTABLE_ATTRIBUTE . "=\"{$p}\" " . $attributes;
	}
}
