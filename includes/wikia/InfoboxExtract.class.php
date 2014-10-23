<?php
class InfoboxExtract {

	const INFOBOX_CLASS_NAME = 'infobox';
	const INSERT_FIRST = 0;
	const INSERT_LAST = 1;

	private $domDocument;
	static public $stylesBlacklist = [
		'width' => 'width',
		'height' => 'height',
		'max-width' => 'max-width',
		'min-width' => 'min-width',
		'max-height' => 'max-height',
		'min-height' => 'min-height'
	];

	static public $defaultQuery;

	public function __construct( $content ) {
		$this->setDefaultQuery();
		$this->createDOMDocument( $content );
	}

	/**
	 * Create default query to extract infobox nodes
	 */
	public function setDefaultQuery() {
		self::$defaultQuery = "((//div|//table)[contains(translate(@class, '" . strtoupper( self::INFOBOX_CLASS_NAME ). "', '" .
		self::INFOBOX_CLASS_NAME . "'), '" . self::INFOBOX_CLASS_NAME . "')])[1]";
	}

	/**
	 * Create DOMDocument from HTML string
	 *
	 * @param string $content HTML string
	 */
	public function createDOMDocument( $content ) {
		$this->domDocument = new DOMDocument();
		$this->domDocument->loadHTML( $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
	}

	public function getDOMDocument() {
		return $this->domDocument;
	}

	/**
	 * Insert node as a first child or as the last child
	 * (depending on position value)
	 *
	 * @param DOMNode $parent
	 * @param DOMNode $node
	 * @param int $position
	 */
	public function insertNode( $parent, $node, $position = self::INSERT_FIRST ) {
		if ( $position === self::INSERT_FIRST ) {
			$parent->insertBefore( $node, $parent->firstChild );
		} elseif ( $position === self::INSERT_LAST ) {
			$parent->appendChild( $node );
		}
	}

	/**
	 * Get nodes described by XPath expression.
	 * If there is empty query, default is used @see setDefaultQuery
	 *
	 * @param string $query XPath expression
	 * @return DOMNodeList
	 */
	public function getInfoboxNodes( $query = '' ) {
		$finder = new DOMXPath($this->getDOMDocument());

		if ( empty( $query ) ) {
			$query = self::$defaultQuery;
		}

		$nodes = $finder->query($query);

		return $nodes;
	}

	/**
	 * Remove blacklisted styles from node inline styles
	 *
	 * @param DOMNode $node infobox node
	 * @return DOMNode node with removed styles from blacklist
	 */
	public function clearInfoboxStyles( $infobox ) {
		if ($infobox->hasAttribute('style')) {
			$styles = $infobox->getAttribute('style');
			$styles = $this->removeBlacklistedProperties( $styles );
			$infobox->setAttribute('style', $styles);
		}

		return $infobox;
	}

	/**
	 * Wrap infobox node by div container with id and class name
	 *
	 * @param DOMNode $infobox node with infobox
	 * @param string $id identyfier for infobox container
	 * @param string $className class name for infobox container
	 * @return DOMNode infobox container with infobox node inside
	 */
	public function wrapInfobox( $infobox, $id = '', $className = '' ) {
		$dom = $this->getDOMDocument();

		$infoboxContainer = $dom->createElement( 'div' );

		if ( !empty( $id ) ) {
			$infoboxContainer->setAttribute( 'id', $id );
		}

		if ( !empty( $className ) ) {
			$infoboxContainer->setAttribute( 'class', $className );
		}

		$infoboxContainer->appendChild( $infobox );

		return $infoboxContainer;
	}

	/**
	 * Remove blacklisted style properties from inline styles string
	 *
	 * @param string $styles
	 * @return string
	 */
	public function removeBlacklistedProperties( $styles ) {
		$stylesArray = self::getStylesArray( $styles );

		$stylesArray = array_diff_key( $stylesArray, self::$stylesBlacklist );

		$styles = implode( ';', $stylesArray );

		return $styles;
	}

	/**
	 * Convert inline styles string into array with property name as a key
	 *
	 * @param string $styles inline styles
	 * @return array
	 */
	public function getStylesArray( $styles ) {
		$stylesArray = [];

		$styles = explode( ';', $styles );

		foreach ( $styles as $style ) {
			$styleProperty = explode( ':', $style );
			$stylesArray[trim($styleProperty[0])] = trim($style);
		}

		return $stylesArray;
	}

} 
