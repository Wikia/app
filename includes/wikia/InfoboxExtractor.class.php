<?php
class InfoboxExtractor {

	const INFOBOX_CLASS_NAME = 'infobox';
	const STYLES_SEPARATOR = ';';
	const UTF8_ENCODING = 'UTF-8';

	private $domDocument;
	static public $stylesBlacklist = [
		'float',
		'height',
		'margin',
		'margin-bottom',
		'margin-left',
		'margin-right',
		'margin-top',
		'max-width',
		'min-width',
		'max-height',
		'min-height'
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
	public function createDOMDocument( $content, $encoding = null ) {
		if ( is_null( $encoding ) ) {
			$encoding = self::UTF8_ENCODING;
		}

		$this->domDocument = new DOMDocument( '1.0', $encoding );
		$this->domDocument->loadHTML(
			mb_convert_encoding( $content, 'HTML-ENTITIES', $encoding ),
			LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
		);
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
	public function insertNode( $parent, $node, $prepend = false ) {
		if ( $prepend === true ) {
			$parent->insertBefore( $node, $parent->firstChild );
		} else {
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
		$stylesBlacklist = array_flip(self::$stylesBlacklist);

		$stylesArray = array_diff_key( $stylesArray, $stylesBlacklist );

		$styles = implode( self::STYLES_SEPARATOR, $stylesArray );

		if ( !empty( $styles ) ) {
			$styles .= ';';
		}

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

		if ( !empty( $styles ) ) {
			$styles = explode( ';', $styles );

			foreach ( $styles as $style ) {
				if ( !empty( $style ) ) {
					$styleProperty = explode( ':', $style );
					$stylesArray[trim($styleProperty[0])] = trim($style);
				}
			}
		}

		return $stylesArray;
	}
} 
