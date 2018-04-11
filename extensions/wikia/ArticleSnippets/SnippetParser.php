<?php

/**
 * Class SnippetParser processes MW HTML output to generate brief description snippets used e.g. in meta tags
 */
class SnippetParser {

	const CONTENT_NODE_BLACKLIST = [ 'div', 'figure', 'nav', 'table', 'script', 'sup', 'dl' ];
	const DIV_CONTENT_NODE_BLACKLIST = [ 'figure', 'nav', 'table', 'script', 'sup', 'dl' ];
	const POTENTIAL_LIST_TITLE_NODES = [ 'p', 'h1', 'h2', 'h3', 'h4' ];

	/** @var Language $language */
	private $language;

	public function __construct( Language $language ) {
		$this->language = $language;
	}

	public function getSnippet( string $html ): string {
		if ( empty( $html ) ) {
			return '';
		}

		libxml_disable_entity_loader( true );
		libxml_use_internal_errors( true );

		$document = new DOMDocument();
		$document->loadHTML( '<?xml encoding="UTF-8">' . $html );
		$document->encoding = 'UTF-8';

		$xpath = new DOMXPath( $document );

		$this->cleanupExtraneousContent( $document, $xpath );
		$this->removeBrokenTemplates( $xpath );

		// Portable infobox content is ignored during initial processing
		$portableInfoboxes = $this->extractPortableInfoboxes( $xpath );

		// First try to generate a snippet from the raw article body
		$originalDocument = clone $document;
		$rootDocument = clone $document;
		$rootContent = $this->parseIntoParagraphs( $rootDocument->documentElement->lastChild, static::CONTENT_NODE_BLACKLIST );

		if ( !empty( $rootContent ) ) {
			return $this->cleanSnippet( $rootContent );
		}

		// Process div tags if the article body could not be used to produce a valid snippet
		$divContents = [];
		$contentCount = 0;

		while ( ( $list = $xpath->query( '///*[name() != "div"]/parent::div' ) )->length ) {
			$contentNode = $list->item( 0 );
			$parsedContents = $this->parseIntoParagraphs( $contentNode, static::DIV_CONTENT_NODE_BLACKLIST );

			foreach ( $parsedContents as $paragraph ) {
				$divContents[] = $paragraph;

				if ( ++$contentCount >= 2 ) {
					return $this->cleanSnippet( $divContents );
				}
			}

			$contentNode->parentNode->removeChild( $contentNode );
		}

		if ( !empty( $divContents ) ) {
			return $this->cleanSnippet( $divContents );
		}

		// Fall back to portable infoboxes if other sources could not produce a snippet
		$portableInfoboxContent = $this->getPortableInfoboxContent( $portableInfoboxes, $xpath );

		if ( !empty( $portableInfoboxContent ) ) {
			return $this->cleanSnippet( $portableInfoboxContent );
		}

		return $this->cleanSnippet( $this->parseIntoParagraphs( $originalDocument->documentElement->lastChild, [] ) );
	}

	private function extractPortableInfoboxes( DOMXPath $xpath ): DOMNodeList {
		$portableInfoboxes = $xpath->query( '///*[contains(@class, "portable-infobox")]' );

		$this->removeListedNodes( $portableInfoboxes );

		return $portableInfoboxes;
	}

	private function cleanupExtraneousContent( DOMDocument $document, DOMXPath $xpath ) {
		$toc = $document->getElementById( 'toc' );

		if ( $toc ) {
			$toc->parentNode->removeChild( $toc );
		}

		$redundant = $xpath->query( '///*[contains(@class,"wikia-button") or contains(@class, "editsection")]' );
		$hidden = $xpath->query( '///*[contains(@style, "display:none")]' );

		$this->removeListedNodes( $redundant );
		$this->removeListedNodes( $hidden );
	}

	private function removeBrokenTemplates( DOMXPath $xpath ) {
		$template = $this->language->getNsText( NS_TEMPLATE );
		$redLinks = $xpath->query( "///a[contains(@class, 'new') and starts-with(@title, '$template')]" );

		$this->removeListedNodes( $redLinks );
	}

	private function parseIntoParagraphs( DOMElement $theNode, array $excludedTags ): array {
		$headings = array_flip( [ 'h1', 'h2', 'h3', 'h4' ] );

		foreach ( $excludedTags as $tagName ) {
			$this->removeListedNodes( $theNode->getElementsByTagName( $tagName ) );
		}

		$allContent = [];
		$listContent = [];
		$paragraph = '';

		/** @var DOMElement $childNode */
		foreach ( $theNode->childNodes as $childNode ) {
			if ( $childNode->nodeType === XML_TEXT_NODE ) {
				$paragraph .= $childNode->textContent;
			} elseif ( $childNode->nodeType === XML_ELEMENT_NODE ) {
				if ( $childNode->nodeName === 'ul' || $childNode->nodeName === 'ol' ) {
					$listContent[] .= $this->getListContent( $childNode );
				} elseif ( !isset( $headings[$childNode->nodeName] ) ) {
					$nextElementSibling = $this->nextElementSibling( $childNode );

					if ( !$nextElementSibling || ( $nextElementSibling->nodeName !== 'ul' && $nextElementSibling->nodeName !== 'ol' ) ) {
						if ( $childNode->nodeName === 'p' ) {
							$allContent[] = $paragraph;
							$paragraph = '';
						}

						// convert line breaks found in text into spaces for snippet readability 😶
						$breaks = $childNode->getElementsByTagName( 'br' );

						for ( $i = $breaks->length - 1; $i >= 0; $i -- ) {
							$aBreak = $breaks->item( $i );
							$space = $childNode->ownerDocument->createTextNode( ' ' );

							$aBreak->parentNode->replaceChild( $space, $aBreak );
						}

						$paragraph .= $childNode->textContent . ' ';
					}
				}
			}
		}

		$allContent[] = $paragraph;

		return array_filter( array_merge( $allContent, $listContent ), [ $this, 'isNotEmpty' ] );
	}


	private function getListContent( DOMElement $listNode ): string {
		$content = '';

		/** @var DOMElement $itemNode */
		foreach ( $listNode->getElementsByTagName( 'li' ) as $itemNode ) {
			$content .= $itemNode->textContent;
			$nextElementSibling = $this->nextElementSibling( $itemNode );

			if ( $nextElementSibling && $nextElementSibling->nodeName === 'li' ) {
				$content .= ', ';
			}
		}

		$previousElementSibling = $this->previousElementSibling( $listNode );

		if ( $previousElementSibling && in_array( $previousElementSibling->nodeName, static::POTENTIAL_LIST_TITLE_NODES ) ) {
			return "{$previousElementSibling->textContent} $content";
		}

		return $content;
	}

	private function getPortableInfoboxContent( DOMNodeList $portableInfoboxes, DOMXPath $xpath ): array {
		$all = [];

		foreach ( $portableInfoboxes as $infobox ) {
			$snippet = '';
			$content = [];

			$titleNode = $xpath->query( './/*[contains(@class, "pi-title")]', $infobox )->item( 0 );
			$title = $titleNode ? $titleNode->textContent : '';

			foreach ( $xpath->query( './/*[contains(@class, "pi-item pi-data")]', $infobox ) as $dataNode ) {
				$label = $xpath->query( './/*[contains(@class, "pi-data-label")]', $dataNode )->item( 0 );
				$value = $xpath->query( './/*[contains(@class, "pi-data-value")]', $dataNode )->item( 0 );

				$content[] = $label->textContent . ': ' . $value->textContent;
			}

			foreach ( $xpath->query( './/*[contains(@class, "pi-smart-group")]', $infobox ) as $groupNode ) {
				$labels = $xpath->query( './/*[contains(@class, "pi-data-label")]', $groupNode );
				$values = $xpath->query( './/*[contains(@class, "pi-data-value")]', $groupNode );

				for ( $i = 0; $i < $labels->length && $i < $values->length; $i++ ) {
					$content[] = $labels->item( $i )->textContent . ': ' . $values->item( $i )->textContent;
				}
			}

			$snippet .= $title;

			if ( !empty( $title ) && !empty( $content ) ) {
				$snippet .= ' - ';
			}

			$snippet .= implode( ', ', $content );

			$all[] = $snippet;
		}

		return $all;
	}

	/**
	 * Helper function to remove all elements of a node list (can't do this in a simple iteration)
	 * @param DOMNodeList $nodeList
	 */
	private function removeListedNodes( DOMNodeList $nodeList ) {
		$remove = [];

		foreach ( $nodeList as $toRemove ) {
			$remove[] = $toRemove;
		}

		/** @var DOMNode $toRemove */
		foreach ( $remove as $toRemove ) {
			$toRemove->parentNode->removeChild( $toRemove );
		}
	}

	private function previousElementSibling( DOMNode $node ) {
		$sibling = $node->previousSibling;

		while ( $sibling && $sibling->nodeType !== XML_ELEMENT_NODE ) {
			$sibling = $sibling->previousSibling;
		}

		return $sibling;
	}

	private function nextElementSibling( DOMNode $node ) {
		$sibling = $node->nextSibling;

		while ( $sibling && $sibling->nodeType !== XML_ELEMENT_NODE ) {
			$sibling = $sibling->nextSibling;
		}

		return $sibling;
	}

	private function isNotEmpty( string $content ): bool {
		return trim( str_replace( "\u{00a0}", ' ', preg_replace('/\p{S}/u', '', $content ) ) ) !== '';
	}

	private function cleanSnippet( array $paragraphs ): string {
		$snippet = implode( ' ', array_slice( $paragraphs, 0, 2 ) );

		// Remove double encoded leftover tags that might be present if the source HTML was invalid
		$sanitized = strip_tags( html_entity_decode( $snippet ) );

		// Normalize whitespace
		$cleared = preg_replace( '/\s+/', ' ', str_replace( "\u{00a0}", ' ', $sanitized  ) );

		// remove spaces before punctuation
		return trim( preg_replace( '/\s((?![\(\)\[\]"\-<>])\p{P})/', '$1', $cleared ) );
	}
}
