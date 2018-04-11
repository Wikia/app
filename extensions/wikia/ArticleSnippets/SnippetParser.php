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
		$document->loadHTML( $html );

		$xpath = new DOMXPath( $document );

		$this->cleanupExtraneousContent( $document, $xpath );
		$this->removeBrokenTemplates( $xpath );

		// Portable infobox content is ignored during initial processing
		$portableInfoboxes = $this->extractPortableInfoboxes( $xpath );

		// First try to generate a snippet from the raw article body
		$rootContent = $this->parseIntoParagraphs( $document->documentElement->lastChild, static::CONTENT_NODE_BLACKLIST );

		if ( !empty( $rootContent ) ) {
			return $this->cleanSnippet( $rootContent );
		}

		// Process div tags if the article body could not be used to produce a valid snippet
		$divContents = [];
		$contentCount = 0;

		/** @var DOMElement $divContentNode */
		foreach ( $xpath->query( '///*[name() != \"div\"]/parent::div' ) as $divContentNode ) {
			foreach ( $this->parseIntoParagraphs( $divContentNode, static::DIV_CONTENT_NODE_BLACKLIST ) as $paragraph ) {
				$divContents[] = $paragraph;

				if ( ++$contentCount >= 2 ) {
					break;
				}
			}
		}

		if ( !empty( $divContents ) ) {
			return $this->cleanSnippet( $divContents );
		}

		// Fall back to portable infoboxes if other sources could not produce a snippet
		$portableInfoboxContent = $this->getPortableInfoboxContent( $portableInfoboxes, $xpath );

		if ( !empty( $portableInfoboxContent ) ) {
			return $this->cleanSnippet( $portableInfoboxContent );
		}

		return $this->cleanSnippet( $this->parseIntoParagraphs( $document->documentElement->lastChild, [] ) );
	}

	private function extractPortableInfoboxes( DOMXPath $xpath ): DOMNodeList {
		$portableInfoboxes = $xpath->query( '///*[contains(@class, "portable-infobox")]' );

		/** @var DOMElement $node */
		foreach ( $portableInfoboxes as $node ) {
			$node->parentNode->removeChild( $node );
		}

		return $portableInfoboxes;
	}

	private function cleanupExtraneousContent( DOMDocument $document, DOMXPath $xpath ) {
		$toc = $document->getElementById( 'toc' );

		if ( $toc ) {
			$toc->parentNode->removeChild( $toc );
		}

		/** @var DOMElement $node */
		foreach ( $xpath->query( '///*[contains(@class,"wikia-button") or contains(@class, "editsection")]' ) as $redundantNode ) {
			$redundantNode->parentNode->removeChild( $redundantNode );
		}

		/** @var DOMElement $node */
		foreach ( $xpath->query( '///*[contains(@style, "display:none")]' ) as $hiddenNode ) {
			$hiddenNode->parentNode->removeChild( $hiddenNode );
		}
	}

	private function removeBrokenTemplates( DOMXPath $xpath ) {
		$template = $this->language->getNsText( NS_TEMPLATE );
		$redLinks = $xpath->query( "///a[contains(@class, 'new') and starts-with(@title, '$template')]" );

		/** @var DOMElement $node */
		foreach ( $redLinks as $node ) {
			$node->parentNode->removeChild( $node );
		}
	}

	private function parseIntoParagraphs( DOMElement $theNode, array $excludedTags ): array {
		$headings = array_flip( [ 'h1', 'h2', 'h3', 'h4' ] );

		foreach ( $excludedTags as $tagName ) {
			foreach ( $theNode->getElementsByTagName( $tagName ) as $notWantedNode ) {
				$notWantedNode->parentNode->removeChild( $notWantedNode );
			}
		}

		$allContent = [];
		$listContent = [];
		$paragraph = '';

		/** @var DOMNode $childNode */
		foreach ( $theNode->childNodes as $childNode ) {
			if ( $childNode->nodeType === XML_TEXT_NODE ) {
				$paragraph .= $childNode->textContent;
			} elseif ( $childNode->nodeType === XML_ELEMENT_NODE ) {
				if ( $childNode->nodeName === 'ul' || $childNode->nodeName === 'ol' ) {
					$listContent[] .= $this->getListContent( $childNode );
				} elseif ( !isset( $headings[$childNode->nodeName] ) ) {
					if ( $childNode->nodeName === 'p' ) {
						$allContent[] = $paragraph;
						$paragraph = '';
					}

					if ( !$childNode->nextSibling || ( $childNode->nextSibling->nodeName !== 'ul' && $childNode->nextSibling->nodeName !== 'ol' ) ) {
						$paragraph .= $childNode->textContent;
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

			if ( $itemNode->nextSibling ) {
				$content .= ', ';
			}
		}

		if ( $listNode->previousSibling && in_array( $listNode->previousSibling->nodeName, static::POTENTIAL_LIST_TITLE_NODES ) ) {
			return "{$listNode->previousSibling->textContent} $content";
		}

		return $content;
	}

	private function getPortableInfoboxContent( DOMNodeList $portableInfoboxes, DOMXPath $xpath ): array {
		$all = [];

		foreach ( $portableInfoboxes as $infobox ) {
			$snippet = '';
			$content = [];

			$titleNode = $xpath->query( '///*[contains(@class, "pi-title")]', $infobox )->item( 0 );
			$title = $titleNode ? $titleNode->textContent : '';

			foreach ( $xpath->query( '///*[contains(@class, "pi-data")]', $infobox ) as $dataNode ) {
				$label = $xpath->query( '///*[contains(@class, "pi-data-label")]', $dataNode )->item( 0 );
				$value = $xpath->query( '///*[contains(@class, "pi-data-value")]', $dataNode )->item( 0 );

				$content[] = $label->textContent . ':' . $value->textContent;
			}

			foreach ( $xpath->query( '///*[contains(@class, "pi-smart-group")]', $infobox ) as $groupNode ) {
				$labels = $xpath->query( '///*[contains(@class, "pi-data-label")]', $groupNode );
				$values = $xpath->query( '///*[contains(@class, "pi-data-value")]', $groupNode );

				for ( $i = 0; $i < $values->length; $i++ ) {
					$content[] = $labels->item( $i )->textContent . ':' . $values->item( $i )->textContent;
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

	private function isNotEmpty( string $content ): bool {
		return trim( str_replace( "\u{00a0}", '', preg_replace('/\p{S}/', '', $content ) ) ) !== '';
	}

	private function cleanSnippet( array $paragraphs ): string {
		$snippet = implode( ' ', array_slice( $paragraphs, 0, 2 ) );

		// Remove double encoded leftover tags that might be present if the source HTML was invalid
		$sanitized = strip_tags( html_entity_decode( $snippet ) );

		// Normalize whitespace
		$cleared = str_replace( "\u{00a0}", '', preg_replace( '/\\s+/', ' ', $sanitized ) );

		// remove spaces before punctuation
		return preg_replace( '/\\s((?![\(\)\[\]"\-<>])\p{P})/', '$1', $cleared );
	}
}
