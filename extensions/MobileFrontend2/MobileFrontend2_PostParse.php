<?php

/**
 * Take the bodycontent and manipulate it for mobile
 */
class MobileFrontend2_PostParse {

	/**
	 * HTML to parse
	 *
	 * @var string
	 */
	protected $html;

	/**
	 * DOM of the bodycontent
	 *
	 * @var DOMDocument
	 */
	protected $dom;

	/**
	 * Private constructor, use the mange function
	 *
	 * @param $html
	 */
	protected function __construct( $html ) {
		$this->html = $html;

		$this->initDom();
	}

	/**
	 * Entry point for the class
	 *
	 * @param $text string
	 * @return string
	 */
	public static function mangle( $text ) {
		$postParse = new self( $text );
		$postParse->parse();

		return $postParse->html;
	}

	/**
	 * Sets up the DOM document
	 */
	protected function initDom() {
		// LibXML is noisy apparently
		libxml_use_internal_errors( true );
		$dom = new DOMDocument();
		$dom->loadHTML( '<?xml encoding="UTF-8">' . $this->html );
		libxml_use_internal_errors( false );

		$dom->strictErrorChecking = false;
		$dom->encoding = 'UTF-8';

		$this->dom = $dom;
	}

	/**
	 * Actually parse  the DOM
	 */
	public function parse() {
		// Remove the TOC
		$this->removeToc();

		// Render the now manipulated HTML
		$this->render();
	}

	/**
	 * Removes the TOC (#toc) from the body
	 */
	protected function removeToc() {
		$element = $this->dom->getElementById( 'toc' );

		if ( $element !== null ) {
			$element->parentNode->removeChild( $element );
		}
	}

	/**
	 * Saves the HTML to $html
	 */
	protected function render() {
		$this->html = $this->dom->saveXML(
			$this->dom->getElementsByTagName( 'body' )
				->item( 0 )->childNodes->item( 0 ) );
	}
}