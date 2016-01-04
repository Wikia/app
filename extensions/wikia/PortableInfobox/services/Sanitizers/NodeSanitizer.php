<?php

use Wikia\Logger\WikiaLogger;

abstract class NodeSanitizer implements NodeTypeSanitizerInterface {
	private $rootNodeTag = 'body';

	/**
	 * Sanitizer configuration
	 * Can be overridden by child classes
	 */
	protected $validNodeNames = [ '#text' ];
	protected $selectorsWrappingAllowedFeatures = [ ];
	protected $selectorsForFullRemoval = [ ];

	/**
	 * Sanitize a single text element, i.e. title or label
	 *
	 * @param $elementText
	 * @param string $allowedTags array of tags, i.e. [ 'a', 'em' ]
	 * @return string
	 */
	protected function sanitizeElementData( $elementText, $allowedTags = [] ) {
		$dom = new \DOMDocument();
		$dom->loadHTML( $this->wrapTextInRootNode( $elementText ) );
		$elementTextAfterTrim = trim( $this->cleanUpDOM( $dom, $allowedTags ) );
		libxml_clear_errors();

		if ( $elementTextAfterTrim !== $elementText ) {
			WikiaLogger::instance()->info(
				'Stripping HTML tags from infobox element',
				[
					'originalText' => $elementText,
					'trimmedText' => $elementTextAfterTrim
				]
			);
			$elementText = $elementTextAfterTrim;
		}
		return $elementText;
	}

	/**
	 * Removes nodes that do not need to remain in the resulting output. By default leaves only text nodes
	 *
	 * @param $dom DOMDocument
	 * @param $allowedTags array
	 * @return string
	 */
	protected function cleanUpDOM( $dom, $allowedTags = [] ) {
		$xpath = new \DOMXPath( $dom );
		$this->removeNodesBySelector( $xpath, $this->selectorsForFullRemoval );
		$nodes = $this->extractNeededNodes( $xpath, $allowedTags );

		return $this->generateHTML( $nodes, $dom );
	}


	/**
	 * @param $elementText
	 * @return string
	 */
	protected function wrapTextInRootNode( $elementText ) {
		$wrappedText = \Xml::openElement( $this->rootNodeTag ) . $elementText . \Xml::closeElement( $this->rootNodeTag );
		return $wrappedText;
	}

	/**
	 * Produces sanitized HTML markup from DOMNode array
	 *
	 * @param $nodes array of DOMNode
	 * @param $dom DOMDocument
	 * @return string
	 */
	protected function generateHTML( $nodes, $dom ) {
		$result = [];
		foreach ( $nodes as $node ) {
			/*
			 * store the result; As the input text is already escaped, we make sure that
			 * our output will be escaped too
			 */
			$result[] = ( $node->nodeName === '#text' ) ? htmlspecialchars( $dom->saveHTML( $node ), ENT_QUOTES ) : $dom->saveHTML( $node );
		}
		return implode( '', $result );
	}

	/**
	 * Returns xpath string covering all legal tag and text nodes concerning the sanitizer
	 * @return string
	 */
	protected function getAllNodesXpath() {
		return sprintf('//%s/* | //%s//text()', $this->rootNodeTag, $this->rootNodeTag);
	}

	/**
	 * @param $DOMnode DOMNode
	 * @return bool
	 */
	protected function shouldNodeBeRemoved( $DOMnode ) {
		return ( $DOMnode && $DOMnode->nodeName === 'a' && $DOMnode->nodeValue === '' );
	}

	/**
	 *
	 * @param $node DOMNode
	 * @param $allowedTags
	 * @return bool
	 */
	protected function isNodeAllowedByTag( $node, $allowedTags ) {
		// tags that are explicitly allowed
		if ( in_array( $node->nodeName, array_merge( $this->validNodeNames, $allowedTags ), true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Removes nodes specified by tag completely
	 * @param $xpath DOMXPath
	 * @param $selectorsToRemove array
	 */
	protected function removeNodesBySelector( $xpath, $selectorsToRemove = [] ) {
		foreach ( $selectorsToRemove as $selector ) {
			$nodesToRemove = $xpath->query( sprintf( '//%s//%s', $this->rootNodeTag, $selector ) );
			foreach ( $nodesToRemove as $node ) {
				$node->parentNode->removeChild( $node );
			}
		}
	}

	/**
	 * @param $xpath DOMXPath
	 * @param $allowedTags
	 * @return array
	 */
	protected function extractNeededNodes( $xpath, $allowedTags ) {
		$nodes = [ ];
		$featureNodes = [ ];
		$remainingNodes = $xpath->query( $this->getAllNodesXpath() );

		foreach ( $remainingNodes as $node ) {
			if ( (
					$this->isNodeAllowedByTag( $node, $allowedTags )
					|| $this->isAllowedFeatureNode( $node, $xpath, $this->selectorsWrappingAllowedFeatures  ) )
				&& !$this->shouldNodeBeRemoved( $node )
				&& !$this->isDescendantOfValidFeatureNode( $node, $nodes, $featureNodes )
			) {
				if ( $this->isAllowedFeatureNode( $node, $xpath, $allowedTags ) ) {
					$featureNodes [] = $node;
				}
				$nodes [] = $node;
			}
		}
		return $nodes;
	}

	/**
	 * Checks if current node is a wrapping tag for a feature
	 *
	 * @param $node DOMNode
	 * @param $xpath DOMXPath
	 * @param $validFeatureNodeSelectors
	 * @return bool
	 */
	protected function isAllowedFeatureNode( $node, $xpath, $validFeatureNodeSelectors = [] ) {
		foreach ( $validFeatureNodeSelectors as $selector ) {
			$nodeQueryResult = $xpath->query( sprintf( '//%s//%s', $this->rootNodeTag, $selector ), $node );
			if ( $nodeQueryResult->length ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Used for skipping processing on subnodes of feature nodes (i.e. citation)
	 *
	 * @param $node DOMNode
	 * @param $nodes
	 * @param $featureNodes
	 * @return bool
	 */
	protected function isDescendantOfValidFeatureNode( $node, $nodes, $featureNodes ) {
		if ( in_array( $node->parentNode, $nodes, true ) && $node->parentNode->childNodes->length === 1 ) {
			return true;
		}

		$parent = $node->parentNode;
		while ( $parent ) {
			if ( in_array( $parent, $featureNodes, true ) ) {
				return true;
			}
			$parent = $parent->parentNode;
		}

		return false;
	}
}
