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
			// marks wikitext tables, omits {{{{{|subst:}}} cases by checking if there is only one '{' before '|'
			if ( preg_match_all( "/^(.*[^\\{])?\\{\\|(.*)/\n", $wikitext, $wikiTables ) ) {
				for ( $i = 0; $i < count( $wikiTables[ 0 ] ); $i++ ) {
					$wikitext = static::markTable( $wikitext, $wikiTables[ 0 ][ $i ], $wikiTables[ 2 ][ $i ], $wikiTables[1][$i].'{|' );
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
			$html = self::processTables( $html );
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

	private static function processTables( $html ) {
		$result = "";
		$document = HtmlHelper::createDOMDocumentFromText( $html );

		$tables = $document->getElementsByTagName( 'table' );
		if ( $tables->length > 0 ) {
			$xpath = new DOMXPath( $document );
			/** @var DOMElement $table */
			foreach ( $tables as $table ) {
				$nestedTables = $xpath->query( './/table', $table );
				// mark nested tables and parent table as not portable
				if ( $nestedTables->length > 0 ) {
					$table->setAttribute( self::DATA_PORTABLE_ATTRIBUTE, 'false' );
					// mark nested tables as not portable
					/** @var DOMElement $nestedTable */
					foreach ( $nestedTables as $nestedTable ) {
						$nestedTable->setAttribute( self::DATA_PORTABLE_ATTRIBUTE, 'false' );
					}
				} elseif ( !$table->hasAttribute( static::DATA_PORTABLE_ATTRIBUTE ) &&
						   $xpath->query( '*//*[@rowspan]|*//*[@colspan]', $table )->length == 0
				) {
					$table->setAttribute( self::DATA_PORTABLE_ATTRIBUTE, 'true' );
				}
			}
			$result = HtmlHelper::getBodyHtml( $document );
		}

		return !empty( $result ) ? $result : $html;
	}
}
