<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCNote {

	public $citationStyle, $citationType;

	public $marker;

	public $number;

	protected $cites = array();

	protected static $citeStyleAttributeWords, $typeAttributeWords;

	protected $style, $type;

	protected $text;

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
	 * Get a new WCNote object based on HTML arguments.
	 * @param array $args = "citeStyle" or "type" (or equivalent foreign words)
	 * @param WCStyle $defaultStyle
	 * @param WCCitationTypeEnum $defaultType
	 * @return WCSection
	 */
	public static function getNote( array $args, $defaultStyle ) {
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
			return new WCNote( $styleObject, $citationType );
		} else {
			return new WCNote( $styleObject, WCCitationTypeEnum::$note );
		}
	}

	public function __construct( WCStyle $style, WCCitationTypeEnum $type ) {
		$this->citationStyle = $style;
		$this->citationType = $type;
		# Leave behind a marker, later to be replaced by the subscript.
		$this->marker = 'NwC-' . mt_rand();
	}


	public function getSuperscript( $text, $number ) {
		# Store the text, to be inserted in endnote list during $this->render().
		$this->text = $text;
		$this->number = $number;
		# Leave behind a marker, later to be replaced by the subscript.
		return '<sup id="t' . $this->marker . '" class="notesuperscript"><a href="#n' .
			$this->marker . '">' . $number . '</a></sup>';
	}


	/**
	 * Add a single citation within the note.
	 * @param integer $key
	 * @param integer $distance = # of citations from last citation to this reference
	 * @param WCArticle $article
	 */
	public function addNoteCite( $key, WCCitation $citation ) {
		$this->cites[ $key ] = $citation;
	}


	/**
	 * Render the note.
	 * @param boolean $bibliographyExists
	 * @return string
	 */
	public function render( $bibliographyExists ) {
		# Replace citation markers in note with rendered citations.
		if ( $this->cites ) {
			$currentStyle = $this->citationStyle;
			$currentType = $this->citationType;
			foreach( $this->cites as $key => $citation ) {
				# If an explicit style has been defined for $key, use it on subsequent citations.
				if ( isset( $citation->style ) ) {
					$currentStyle = $citation->style;
				} else {
					$citation->style = $currentStyle;
				}
				# If an explicit type has been defined, use it on subsequent citations.
				if ( isset( $citation->citationType ) ) {
					$currentType = $citation->citationType;
				} else {
					$citation->citationType = $currentType;
				}
				# The first citation is long, and subsequent citations are short.
				# If there is a bibliography, they are all short.
				if ( is_null ( $citation->citationLength) ) {
					if ( $citation->distance === 0 && !$bibliographyExists ) {
						$citation->citationLength = WCCitationLengthEnum::$long;
					} else {
						$citation->citationLength = WCCitationLengthEnum::$short;
					}
				}
				list( $textCitation, ) = $citation->render();
				$pos = strpos( $this->text, $citation->marker );
				if ( $pos !== false ) {
					$text = substr_replace( $this->text, $textCitation, $pos, strlen( $citation->marker ) );
				}
			}
		}
		$markedupText = '<li id="n' . $this->marker . '">';
		$markedupText .= '<a href="#t' . $this->marker . '">' . $this->number . '</a>. ';
		$markedupText .= $text;
		$markedupText .= '</li>' . PHP_EOL;
		return $markedupText;
	}

}


/**
 * Static initializer.
 */
WCBibliography::init();
