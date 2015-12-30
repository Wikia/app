<?php

use Wikia\Logger\WikiaLogger;

abstract class NodeSanitizer implements NodeTypeSanitizerInterface {
	private $rootNodeTag = 'root';
	protected $alwaysValidTags = [ '#text' ];
	protected $fullyAllowedTags = [ ];
	protected $fullyRemovedTags = [ ];
	protected $allNodesXPath = '';


	public function __construct() {
		$this->allNodesXPath = sprintf('//%s/* | //%s//text()', $this->rootNodeTag, $this->rootNodeTag);
	}

	/**
	 * process single title or label
	 *
	 * @param $elementText
	 * @param string $allowedTags
	 * @return string
	 */
	protected function sanitizeElementData( $elementText, $allowedTags = [] ) {
		$elementTextAfterTrim = trim( $this->cleanUpMarkup( $elementText, $allowedTags ) );

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
	 * @param $elementText
	 * @param $allowedTags array of tags, i.e. [ 'a', 'em' ]
	 * @return string
	 */
	protected function cleanUpMarkup( $elementText, $allowedTags = [] ) {
		$dom = new \DOMDocument();
		$dom->loadHTML( $this->wrapTextInRootNode( $elementText ) );
		$xpath = new \DOMXPath( $dom );

		$this->removeUnneededTagNodes( $xpath );
		$nodes = $this->extractNeededNodes( $allowedTags, $xpath );
		$result = $this->generateHTML( $nodes, $dom );

		libxml_clear_errors();
		return $result;
	}

	/**
	 * @param $DOMnode \DOMNode
	 * @return bool
	 */
	protected function shouldNodeBeRemoved( $DOMnode ) {
		return ( $DOMnode && $DOMnode->nodeName === 'a' && $DOMnode->nodeValue === '' );
	}

	/**
	 * @param $node
	 * @param $allowedTags
	 * @param $xpath
	 * @return bool
	 */
	protected function isAllowedTagNode( $node, $allowedTags, $xpath ) {
		// tags that are explicitly allowed
		if ( in_array( $node->nodeName, array_merge( $this->alwaysValidTags, $allowedTags ), true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $node
	 * @param $allowedTags
	 * @param $xpath
	 * @return bool
	 */
	protected function isFullyAllowedFeatureNode( $node, $allowedTags, $xpath ) {
		// specific structures that are explicitly allowed
		foreach ( $this->fullyAllowedTags as $allowedTag ) {
			$nodeQueryResult = $xpath->query( sprintf( '//root//%s', $allowedTag ), $node );
			if ( $nodeQueryResult->length ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param $node DOMNode
	 * @param $nodes
	 * @param $featureNodes
	 * @return bool
	 */
	protected function doesProcessedAncestorPreventProcessing( $node, $nodes, $featureNodes ) {
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

	/**
	 * @param $xpath
	 */
	protected function removeUnneededTagNodes( $xpath ) {
		foreach ( $this->fullyRemovedTags as $filteredTag ) {
			$nodesToRemove = $xpath->query( sprintf( '//root//%s', $filteredTag ) );
			foreach ( $nodesToRemove as $node ) {
				$node->parentNode->removeChild( $node );
			}
		}
	}

	/**
	 * @param $nodes
	 * @param $dom
	 * @param $result
	 * @return array
	 */
	protected function generateHTML( $nodes, $dom, $result ) {
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
	 * @param $allowedTags
	 * @param $xpath
	 * @return array
	 */
	protected function extractNeededNodes( $allowedTags, $xpath ) {
		$nodes = [ ];
		$featureNodes = [ ];
		$remainingNodes = $xpath->query( $this->allNodesXPath );
		foreach ( $remainingNodes as $node ) {
			if ( ( $this->isAllowedTagNode( $node, $allowedTags, $xpath ) || $this->isFullyAllowedFeatureNode( $node, $allowedTags, $xpath ) ) && !$this->shouldNodeBeRemoved( $node ) && !$this->doesProcessedAncestorPreventProcessing( $node, $nodes, $featureNodes ) ) {
				if ( $this->isFullyAllowedFeatureNode( $node, $allowedTags, $xpath ) ) {
					$featureNodes [] = $node;
				}
				$nodes [] = $node;
			}
		}
		return $nodes;
	}

	/**
	 * @param $elementText
	 * @return string
	 */
	protected function wrapTextInRootNode( $elementText ) {
		$wrappedText = \Xml::openElement( $this->rootNodeTag ) . $elementText . \Xml::closeElement( $this->rootNodeTag );
		return $wrappedText;
	}

}
