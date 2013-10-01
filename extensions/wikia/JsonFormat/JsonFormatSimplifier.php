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
			} else if ( $childNode->getType() == 'paragraph' ) {
				$this->getParagraphs( $childNode, $paragraphs );
			}
		}
	}

	public function getImages( \JsonFormatContainerNode $containerNode, &$images ) {
		foreach( $containerNode->getChildren() as $childNode ) {
			if ( $childNode->getType() == 'section' ) {
				return;
			} else if ( $childNode->getType() == 'image' ) {
				/** @var \JsonFormatImageNode $a  */
				$images[] = [
					"src" => $childNode->getSrc()
				];
			} else if ( $childNode->getType() == 'imageFigure' ) {
				/** @var \JsonFormatImageFigureNode $a  */
				$images[] = [
					"src" => $childNode->getSrc(),
					"caption" => $childNode->getCaption()
				];
			} else if ( $childNode->getType() == 'paragraph' ) {
				$this->getParagraphs( $childNode, $paragraphs );
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
	public function getJsonFormat( \JsonFormatRootNode $rootNode ) {
		$sections = [];
		$this->findSections( $rootNode, $sections );

		$returnSections = [];
		foreach ( $sections as $section ) {
			/** @var \JsonFormatSectionNode $section  */
			$paragraphs = [];
			$images = [];
			$this->getParagraphs( $section, $paragraphs );
			$this->getImages( $section, $images );
			$returnSections[] = [
				"title" => ( $section->getType() == "section" ) ? $section->getTitle() : "",
				"level" => ( $section->getType() == "section" ) ? $section->getLevel() : 1,
				"paragraphs" => $paragraphs,
				"images" => $images
			];
		}
		return [
			"sections" => $returnSections
		];
	}
}
