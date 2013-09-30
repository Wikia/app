<?php


namespace Wikia\JsonFormat;


class JsonFormatSimplifier {

	public function getParagraphs( \JsonFormatContainerNode $containerNode, &$paragraphs ) {
		foreach( $containerNode->getChildren() as $childNode ) {
			if ( $childNode->getType() == 'section' ) {
				return;
			} else if ( $childNode->getType() == 'link' ) {
				$this->appendInline( $paragraphs, $childNode->getText() );
			} else if ( $childNode->getType() == 'text' ) {
				$this->appendInline( $paragraphs, $childNode->getText() );
			} else if ( $node->getType() == 'list' ) {
				$tag = $node->getOrdered() ? 'ol' : 'ul';
				return "<$tag>{$this->iterate( $node )}</$tag>";
			} else if ( $node->getType() == 'listItem' ) {
				return "<li>{$this->iterate( $node )}</li>";
			} else if ( $node->getType() == 'table' ) {
				return "<table>{$this->iterate( $node )}</table>";
			} else if ( $node->getType() == 'tableRow' ) {
				return "<tr>{$this->iterate( $node )}</tr>";
			} else if ( $node->getType() == 'tableCell' ) {
				return "<td>{$this->iterate( $node )}</td>";
			} else if ( $node->getType() == 'paragraph' ) {
				return "<p>{$this->iterate( $node )}</p>";
			} else if ( $node->getType() == 'imageFigure' ) {
				return "<div style=\"\"><img src=\"{$node->getSrc()}\"/></div>";
			} else if ( $node->getType() == 'image' ) {
				return "<img src=\"{$node->getSrc()}\"/>";
			} else if ( $node->getType() == 'quote' ) {
				return "<div><i>{$node->getText()}</i></div><div><i>{$node->getAuthor()}</i></div>";
			}
		}
	}

	/**
	 * @param String[] $paragraphs
	 * @param String $inlineText
	 */
	public function appendInline( &$paragraphs, $inlineText ) {
		if( sizeof( $paragraphs ) == 0 ) {
			$paragraphs[] = "";
		}
		$paragraphs[ sizeof($paragraphs) - 1 ] .= $inlineText;
	}

	private function findSections( \JsonFormatNode $node, &$sections ) {
		if ( $node instanceof \JsonFormatRootNode || $node instanceof \JsonFormatSectionNode ) {
			$sections[] = $node;
		}
		if ( $node instanceof \JsonFormatContainerNode ) {
			foreach( $node->getChildren() as $childNode ) {
				$this->findSections( $childNode, $sections );
			}
		}
	}

	/**
	 * @throws InvalidParameterApiException
	 */
	public function getJsonFormatAsText( \JsonFormatRootNode $rootNode ) {
		$sections = [];
		$this->findSections( $rootNode, $sections );

		foreach ( $sections as $section ) {
			$paragraphs = [];
			$this->getParagraphs( $sections, $paragraphs );
		}
	}
}
