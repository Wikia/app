<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCBibliography {

	const bibliographyHTML = 'bibliography';        # HTML class for the note marker

	protected static $citeStyleAttributeWords, $typeAttributeWords;

	protected $marker;

	protected $citationStyle, $citationType;

	protected $styleHTML;

	/**
	 * Static initializer.
	 */
	public static function init() {
		$citeStyleMW = MagicWord::get( 'wc_citestyle_attrib' );
		self::$citeStyleAttributeWords = $citeStyleMW->getSynonyms();
		$typeMW = MagicWord::get( 'wc_type_attrib' );
		self::$typeAttributeWords = $typeMW->getSynonyms();
	}

	/**
	 * Get a new WCBibliography object based on HTML arguments.
	 * @param array $args
	 * @return WCBibliography
	 */
	public static function getBibliography( array $args, WCStyle $defaultStyle ) {
		foreach( $args as $attrib => $value ) {
			if ( in_array( $attrib, self::$citeStyleAttributeWords ) ) {
				$styleClassName = WCArgumentReader::matchStyleClassName( $value );
			} elseif ( in_array( $attrib, self::$typeAttributeWords ) ) {
				$citationTypeID = WCCitationTypeEnum::match( $value );
				if ( isset( $citationTypeID ) ) {
					$citationType = new WCCitationTypeEnum( $citationTypeID );
				}
			} elseif ( $args[ 'style' ] ) {
				$this->styleHTML = ' style="' . $args[ 'style' ] . '"';
			} elseif ( $args[ 'id' ] ) {
				$this->styleHTML = ' id="' . $args[ 'id' ] . '"';
			}
		}

		if ( isset( $styleClassName ) ) {
			# See if a specific style object has already been defined, and if so, use it.
			$styleObject = WCArticle::getStyle( $styleClassName );
		} else {
			# Use default citation style.
			$styleObject = $defaultStyle;
		}

		if ( isset( $citationType ) && $citationTypeID === WCCitationTypeEnum::authorDate ) {
			return new WCBibliography( $styleObject, WCCitationTypeEnum::$authorDate );
		} else {
			return new WCBibliography( $styleObject, WCCitationTypeEnum::$biblio );
		}
	}

	public function __construct( WCStyle $style, WCCitationTypeEnum $type ) {
		$this->citationStyle = $style;
		$this->citationType = $type;
		$this->marker = 'BwC-' . mt_rand();
	}

	public function getMarker() {
		return $this->marker;
	}

	/**
	 * Need to create separate WCCitation object for each entry here!!
	 * Enter description here ...
	 * @param unknown_type $text
	 * @param WCArticle $article
	 */
	public function render( &$text, WCReferenceStore $referenceStore ) {

		$references = $referenceStore->getReferences();

		$entries = array();

		# Render entries in biblio format.
		foreach( $references as $key => $reference ) {
			$citation = new WCCitation( $reference );
			$citation->style = $this->citationStyle;
			$citation->citationType = $this->citationType;
			$citation->citationLength = WCCitationLengthEnum::$long;
			$entries[ $key ] = $citation->render();
		}

		# Sort bibliography.
		$this->sortBibliography( $entries );

		# Generate bibliography.
		$bibliography = '<ul class="bibliography"' . $this->styleHTML . '>' . PHP_EOL;
		foreach ( $entries as $key => $entry ) {
			$bibliography .= '<li id="' . $references[ $key ]->id . '">' . $entry[0] . '</li>' . PHP_EOL;
		}
		$bibliography .= '</ul>';
		$text = str_replace( $this->marker, $bibliography, $text );
	}

	protected function sortBibliography( array &$entries ) {
		uasort( $entries, array( 'WCBibliography', 'compareBibliographyEntries' ) );
	}

	protected static function compareBibliographyEntries( array $entry1, array $entry2 ) {
		$segment1 = $entry1[1]; # WCSegment objects (usually WCGroupSegment).
		$segment2 = $entry2[1]; #
		$segment1->rewind();
		$segment2->rewind();
		while ( $segment1->valid() && $segment2->valid() ) {
			$part1 = $segment1->current();
			$part2 = $segment2->current();
			$cmp = strnatcasecmp( $part1, $part2 );
			if ( $cmp ) {
				return $cmp;
			}
			$segment1->next();
			$segment2->next();
		}
		return 0;
	}

}


/**
 * Static initializer.
 */
WCBibliography::init();
