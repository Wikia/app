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
		if ( static::shouldBeProcessed() ) {
			// marks wikitext tables
			if ( preg_match_all( "/\\{\\|(.*)/\n", $wikitext, $matches ) ) {
				for ( $i = 0; $i < count( $matches[ 0 ] ); $i++ ) {
					$wikitext = static::markTable( $wikitext, $matches[ 0 ][ $i ], $matches[ 1 ][ $i ], '{|' );
				}
			}
			// marks html tables
			if ( preg_match_all( "/<table(.*)(\\/?>)/sU", $wikitext, $htmlTables ) ) {
				for ( $i = 0; $i < count( $htmlTables[ 0 ] ); $i++ ) {
					$wikitext = static::markTable( $wikitext,
						$htmlTables[ 0 ][ $i ], $htmlTables[ 1 ][ $i ], '<table', $htmlTables[ 2 ][ $i ] );
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * Mark data tables with data-portable attribute after parsing
	 *
	 * @param Parser $parser
	 * @param $html
	 *
	 * @return mixed
	 */
	public static function markDataTables( $parser, &$html ) {
		wfProfileIn( __METHOD__ );

		if ( $html && static::shouldBeProcessed() ) {
			$document = new DOMDocument();
			//encode for correct load
			$document->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );

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
				$body = $document->getElementsByTagName( 'body' )->item( 0 );
				for ( $i = 0; $i < $body->childNodes->length; $i++ ) {
					$result[] = $document->saveXML( $body->childNodes->item( $i ) );
				}

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

	private static function markTable( $wikitext, $table, $attributes, $startTag = '', $endTag = '', $portable = false ) {
		if ( mb_stripos( $attributes, self::DATA_PORTABLE_ATTRIBUTE ) === false ) {
			$p = $portable ? 'true' : 'false';

			return str_replace(
				$table,
				$startTag . ' ' . trim( self::DATA_PORTABLE_ATTRIBUTE . "=\"{$p}\" " . ltrim( $attributes ) ) . $endTag,
				$wikitext
			);
		}

		return $wikitext;
	}
}
