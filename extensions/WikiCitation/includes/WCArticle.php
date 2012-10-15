<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Represents a page with citations.
 */
class WCArticle implements Countable {

	/**
	 * Constants
	 */
	const defaultStyleID = 'wc_default'; # magic word for default citation style:
	const noteMarkerHTML = 'notemarker'; # HTML class for the note marker
	const endnotesHTML   = 'endnotes';   # HTML class for endnotes list
	const noteNumberHTML = 'notenumber'; # HTML class for the note number

	public static $defaultStyle;

	/**
	 * Style objects.
	 * These are created as needed, and then kept in memory.
	 * @var array Array in the form of string class name => WCStyle object.
	 */
	protected static $styleObjects = array();

	/**
	 * Database of unique references.
	 * @var WCReferenceStore
	 */
	protected $referenceStore;

	/**
	 * Arrays keyed to the citation key.
	 * These represent a master database of all citations in the article.
	 * @var array
	 */
	public $citations = array();
	public $styles = array();
	public $citationTypes = array(), $citationLengths = array();

	protected $currentDefaultStyle;

	protected $bibliography;

	protected $bibliographyLevel = 0, $noteLevel = 0;

	/**
	 * Stack containing note text and markers
	 * @var array = ( level => ( note number => note text ) )
	 */
	protected $sectionStack;

	protected $sectionStackPointer = 0;

	/**
	 * Keeps a running count fo the number of $citations.
	 * @var int
	 */
	protected $citationCount = 0;


	/**
	 * Static initializer.
	 */
	public static function init() {
		global $wgWCCitationStyles;
		$defaultStyleName = $wgWCCitationStyles[ self::defaultStyleID ];
		self::$defaultStyle = self::getStyle( $defaultStyleName );
	}


	/**
	 * Construct article.
	 * @global type $wgWCCitationStyles
	 */
	public function __construct() {
		$this->currentDefaultStyle = self::$defaultStyle;
		# Create an initial section, representing the entire article.
		$this->sectionStack[0] = new WCSection( self::$defaultStyle, WCCitationTypeEnum::$inline );
		$this->referenceStore = new WCReferenceStore();
	}


	/**
	 * Creates a citation object for each citation parser function.
	 *
	 * Reads flags and parameters from WCArgumentReader object,
	 * then creates an appropriate child of class WCStyle based on the
	 * first parameter after the colon, then returns the citation as text.
	 * @remark Note that this $parser is guaranteed to be the same parser that
	 * initialized the object.
	 *
	 * @param WCArgumentReader $argumentReader
	 * @return string Unique marker for citation.
	 */
	public function parseCitation( WCArgumentReader $argumentReader ) {

		# Use the explicit citation style if defined, or use last style.
		$styleClassName = $argumentReader->getStyleClassName();
		if ( $styleClassName ) {
			# Store citation style in a running database of style object singlets.
			$this->currentDefaultStyle = self::getStyle($styleClassName);
		}

		# A citation function, with no data, may exist merely to define the citation style.
		if ( $argumentReader->isEmpty() ) {
			++$this->citationCount;
			return '';
		}

		$reference = new WCReference();
		$citation = new WCCitation( $reference );
		$citation->readArguments( $argumentReader );
		$reference->finalize();

		# Store reference in database that checks for uniqueness.
		# $citation->reference will be reloaded later, after all citations are read.
		$citation->distance = $this->referenceStore->addUniqueReference( $this->citationCount, $reference );

		# Is this a citation explicitly inserted in bibliography tags?
		# If so, then we will not be leaving behind a marker.
		if ( $this->bibliographyLevel > 0 ) {
			++$this->citationCount;
			return ''; # Only a single marker is left behind per bibliography.
		}

		# Determine whether the citation is in a note, or inline.
		$section = $this->sectionStack[ $this->sectionStackPointer ];
		if ( $this->noteLevel > 0 ) {
			$section->addNoteCite( $this->citationCount, $citation );
		} else {
			$section->addInlineCite( $this->citationCount, $citation );
		}

		# Store citation and leave behind a random marker for later replacement by the citation:
		$this->citations[ $this->citationCount++ ] = $citation;
		return $citation->marker;

	}


	/**
	 * Begin a new endnote section.
	 * Citation style and type may be inherited from enclosing section, if undefined.
	 * @param array $args = HTML attributes
	 */
	public function startSection( array $args ) {
		$superSection = $this->sectionStack[ $this->sectionStackPointer ];
		$this->sectionStack[ ++$this->sectionStackPointer ] =
			WCSection::getSection( $args, $superSection->citationStyle, $superSection->citationType );
	}


	/**
	 * End the existing endnote section.
	 */
	public function endSection() {
		--$this->sectionStackPointer;
	}


	public function startNote( array $args ) {
		++$this->noteLevel;
		# If a note tag is nested, ignore it but keep track of nesting level.
		if ( $this->noteLevel > 1 || $this->bibliographyLevel > 0 ) {
			return;
		}
		$this->sectionStack[ $this->sectionStackPointer ]->startNote( $args );
	}


	/**
	 * Parse endnote text and save. Leave behind a marker for later replacement.
	 * @param string $text Parsed text of the endnote.
	 * @return string Marker to later be replaced with subscripted note mark.
	 */
	public function finishNote( $text ) {
		# Do not insert footnote if nested, or within biblio tags
		if ( --$this->noteLevel > 0 || $this->bibliographyLevel > 0) {
			return $text;
		}
		return $this->sectionStack[ $this->sectionStackPointer ]->finishNote( $text );
	}


	public function markEndnotes() {
		return $this->sectionStack[ $this->sectionStackPointer ]->addEndnotes();
	}


	public function startBibliography( array $args ) {
		++$this->bibliographyLevel;
		# If a bibliography already exists, or is nested, ignore it, but keep track of nesting level.
		if ( isset( $this->bibliography ) || $this->bibliographyLevel > 1 ) {
			return;
		}
		$this->bibliography = WCBibliography::getBibliography( $args, $this->currentDefaultStyle );
	}


	public function endBibliography() {
		# If the bibliography end tag is nested, ignore it. Otherwise, leave marker.
		if ( --$this->bibliographyLevel > 0 ) {
			return '';
		} else {
			return $this->bibliography->getMarker();
		}
	}


	/**
	 * Renders and inserts citations and other material, replacing all markers.
	 *
	 * @global type $wgWCCitationStyles
	 * @param string $text = the current parsed text of the article
	 */
	public function render( &$text ) {

		# Update references, which might have changed due to consolidation, from referenceStore.
		foreach( $this->citations as $key => $citation ) {
			$citation->reference = $this->referenceStore->getReference($key);
		}

		# Render note marks, free-standing citations, and endnotes.
		$this->sectionStack[ $this->sectionStackPointer ]->render(
			$text,
			$this->citations,
			(boolean) $this->bibliography
		);

		# Render bibliography.
		if ( $this->bibliography ) {
			$this->bibliography->render( $text, $this->referenceStore );
		}
	}


	/**
	 * Given a style name, return the style object singlet.
	 * @param string $styleClassName = Style class name (e.g., "WCChicagoStyle")
	 * @return WCStyle
	 */
	public static function getStyle( $styleClassName ) {
		$styleObject = & self::$styleObjects[ $styleClassName ];
		if ( is_null( $styleObject ) ) {
			$styleObject = new $styleClassName();
		}
		return $styleObject;
	}


	/**
	 * Clear page of citations.
	 * @param PPFrame_DOM $frame
	 * @param array $args
	 */
	public function clear() {
		$this->citations = array();
		$this->citationCount = $this->bibliographyLevel = 0;
		$this->sectionStackPointer = $this->noteLevel = 0;
		$this->currentDefaultStyle = self::$defaultStyle;
		$this->sectionStack[0] = new WCSection( self::$defaultStyle, WCCitationTypeEnum::$inline );
		$this->referenceStore = new WCReferenceStore();
	}


	/**
	 * Implements the count() function in the Countable interface (SPL).
	 * @return int
	 */
	public function count() {
		return $this->citationCount;
	}

}

/**
 * Static initializer.
 */
WCArticle::init();
