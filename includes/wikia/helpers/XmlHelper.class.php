<?php
/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 17/01/2018
 * Time: 11:41
 */

class XmlHelper {
	public static function createXmlDocumentFromText(string $xml): DOMDocument {
		$error_setting = libxml_use_internal_errors( true );
		$document = new DOMDocument();

		if ( !empty( $xml ) ) {
			//encode for correct load, loading as xml instead of HTML to avoid html parser fixing html issues like
			// block element inside inline one
			$document->loadXML( mb_convert_encoding( $xml, 'HTML-ENTITIES', 'UTF-8' ) );
		}

		// clear user generated html parsing errors
		libxml_clear_errors();
		libxml_use_internal_errors( $error_setting );

		return $document;
	}

	public static function renameNode( DOMElement $node, string $newName ): DOMElement {
		// For unknown reason iterating through $node->childNodes did not iterate over all of children, for example
		// <i> and <b> was omitted
		$xpath = new DOMXPath( $node->ownerDocument );
		$children = $xpath->query("child::*", $node);
		$newnode = $node->ownerDocument->createElement($newName);

		foreach($children as $child) {
			$child = $node->ownerDocument->importNode($child, true);
			$newnode->appendChild($child);
		}
		foreach ($node->attributes as $attrName => $attrNode) {
			$newnode->setAttribute($attrName, $attrNode->nodeValue);
		}
		$node->parentNode->replaceChild($newnode, $node);

		return $newnode;
	}


	public static function getNodeHtml( DOMDocument $document, DOMNode $node ) {
		// strip <html> and <body> tags
		$result = [ ];
		for ( $i = 0; $i < $node->childNodes->length; $i++ ) {
			$result[] = $document->saveHTML( $node->childNodes->item( $i ) );
		}

		return implode( "", $result );
	}
}