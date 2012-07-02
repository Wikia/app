<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCSection {

	public $citationStyle, $citationType;

	protected static $citeStyleAttributeWords, $typeAttributeWords;

	protected $cites = array();

	protected $notes = array();

	protected $noteCount = 1;

	protected $endnoteMarker;

	protected $subsection;

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
	 * Get a new WCSection object based on HTML arguments.
	 * @param array $args = "citeStyle" or "type" (or equivalent foreign words)
	 * @param WCStyle $defaultStyle
	 * @param WCCitationTypeEnum $defaultType
	 * @return WCSection
	 */
	public static function getSection( array $args, $defaultStyle, $defaultType ) {
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
		if ( isset( $citationType ) ) {
			return new WCSection( $styleObject, $citationType );
		} else {
			return new WCSection( $styleObject, $defaultType );
		}
	}

	/**
	 * Constructor.
	 * WCSection objects will normally be created through WCSection::getSection(...).
	 * @param WCStyle $style
	 * @param WCCitationTypeEnum $type
	 */
	public function __construct( WCStyle $style, WCCitationTypeEnum $type ) {
		$this->citationStyle = $style;
		$this->citationType = $type;
	}


	/**
	 * Add an inline citation (not within an endnote).
	 * @param integer $key
	 * @param integer $distance
	 */
	public function addInlineCite( $key, $citation ) {
		$this->cites[] = $key;
		# If citation length was not explicitly defined, it will be:
		# long if the first citation in the section to that reference, short otherwise
		if ( is_null ( $citation->citationLength) ) {
			$citation->citationLength =
				$citation->distance === 0 ? WCCitationLengthEnum::$long : WCCitationLengthEnum::$short;
		}
	}


	/**
	 * Create a new footnote.
	 * @param array $args
	 */
	public function startNote( array $args ) {
		$this->notes[ $this->noteCount ] = WCNote::getNote( $args, $this->citationStyle );
	}


	/**
	 * Add a citation within an endnote.
	 * @param int $key
	 * @param boolean $isNew
	 * @param WCArticle $article
	 */
	public function addNoteCite( $key, WCCitation $citation ) {
		$this->notes[ $this->noteCount ]->addNoteCite( $key, $citation );
	}


	/**
	 * Store the text of the current footnote and return a marker for the subscript number.
	 * @param string $text
	 * @return string
	 */
	public function finishNote( $text ) {
		return $this->notes[ $this->noteCount ]->getSuperscript( $text, $this->noteCount++ );
	}


	/**
	 * Parse endmotes and Add an endnote citation.
	 * @return string
	 */
	public function addEndnotes() {
		$marker = 'EwC-' . mt_rand();
		$this->endnoteMarker = $marker;
		return $marker;
	}


	/**
	 * Render a section: replace markers for citations, endnote numbers, and endnotes.
	 * @param unknown_type $text
	 * @param array ( int => WCCitation )
	 * @param boolean bibliographyExists
	 */
	public function render( &$text, $citations, $bibliographyExists ) {

		/**
		 * Replace inline citation markers.
		 */
		if ( $this->cites ) {
			$currentStyle = $this->citationStyle;
			$currentType = $this->citationType;
			$textCitations = $markers = array();
			foreach( $this->cites as $key ) {
				$citation = $citations[ $key ];

				# If an explicit style has been defined for $key, use it; otherwise, use the previous style.
				if ( isset( $citation->style ) ) {
					$currentStyle = $citation->style;
				} else {
					$citation->style = $currentStyle;
				}
				if ( isset( $citation->citationType ) ) {
					$currentType = $citation->citationType;
				} else {
					$citation->citationType = $currentType;
				}

				list( $textCitation, ) = $citation->render();
				$pos = strpos( $text, $citation->marker );
				if ( $pos !== false ) {
					$text = substr_replace( $text, $textCitation, $pos, strlen( $citation->marker ) );
				}
			}
		}

		/**
		 * Replace endnote marker with rendered endnotes.
		 */
		if ( $this->endnoteMarker ) {
			if ( $this->notes ) {
				$endnoteText = '<ol class="endnotes"' . $this->styleHTML . '>' . PHP_EOL;
				foreach( $this->notes as $key => $note ) {
					$endnoteText .= $note->render( $bibliographyExists );
				}
				$endnoteText .= '</ol>';
			} else {
				$endnoteText = '';
			}
			$pos = strpos( $text, $this->endnoteMarker );
			if ( $pos !== false ) {
				$text = substr_replace( $text, $endnoteText, $pos, strlen( $this->endnoteMarker ) );
			}
		}
	}

}


/**
 * Static initializer.
 */
WCBibliography::init();
