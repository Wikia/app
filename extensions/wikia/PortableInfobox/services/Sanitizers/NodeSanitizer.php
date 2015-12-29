<?php

use Wikia\Logger\WikiaLogger;

abstract class NodeSanitizer implements NodeTypeSanitizerInterface {
	private $uniqTag = 'uniq';

	/**
	 * process single title or label
	 *
	 * @param $elementText
	 * @param string $allowedTags
	 * @return string
	 */
	protected function sanitizeElementData( $elementText, $allowedTags = null ) {
		$elementTextAfterTrim = trim( strip_tags( $elementText, $allowedTags ) );

		if ( $elementTextAfterTrim !== $elementText ) {
			WikiaLogger::instance()->info( 'Striping HTML tags from infobox element' );
			$elementText = $elementTextAfterTrim;
		}
		return $elementText;
	}

	/**
	 * Removes elements that do not need to remain in the resulting output (i.e. empty link tags)
	 * @param $elementText
	 * @return string
	 */
	protected function stripUnneededElements( $elementText ) {
		// Make sure there is always an explicit root node
		$wrappedText = \Xml::openElement( $this->uniqTag ) . $elementText . \Xml::closeElement( $this->uniqTag );

		$dom = new \DOMDocument();
		$dom->loadHTML( $wrappedText );

		$contents = $dom->getElementsByTagName( $this->uniqTag )->item( 0 );
		foreach ( $contents->childNodes as $childNode ) {
			if ( $this->shouldNodeBeKept( $childNode ) ) {
				$result[] = $dom->saveHTML( $childNode );
			}
		}

		libxml_clear_errors();
		return implode( '', $result );
	}

	/**
	 *
	 * @param $childNode \DOMNode
	 * @return bool
	 */
	protected function shouldNodeBeKept( $childNode ) {
		return !( $childNode && $childNode->nodeName === 'a' && $childNode->nodeValue === '' );
	}

}
