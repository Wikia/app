<?php


namespace Wikia\JsonFormat;


class JsonFormatSimplifier {

	public function getParagraphs( \JsonFormatContainerNode $containerNode, &$contentElements ) {
		foreach( $containerNode->getChildren() as $childNode ) {
			if ( $childNode->getType() == 'section' ) {
				return;
			} else if ( $childNode->getType() == 'link' ) {
				$this->appendInline( $contentElements, $childNode->getText() );
			} else if ( $childNode->getType() == 'text' ) {
				$this->appendInline( $contentElements, $childNode->getText() );
			} else if ( $childNode->getType() == 'paragraph' ) {
				$this->newParagraph( $contentElements );
				$this->getParagraphs( $childNode, $contentElements );
			} else if ( $childNode->getType() == "list" ) {
				$simpleListElements = [];
				foreach ( $childNode->getChildren() as $listElement ) {
					$simpleListElements[] = $this->readText( $listElement );
				}
				$contentElements[] = [
					"type" => "list",
					"elements" => $simpleListElements
				];
			}
		}
	}

	public function readText( \JsonFormatContainerNode $parentNode ) {
		$text = "";
		foreach ( $parentNode->getChildren() as $childNode ) {
			if ( $childNode->getType() == 'text' ) {
				/** @var \JsonFormatTextNode $childNode */
				$text .= " " . $childNode->getText();
			} else if ( $childNode->getType() == 'link' ) {
				/** @var \JsonFormatLinkNode $childNode */
				$text .= " " . $childNode->getText();
			} else if ( $childNode->getType() == 'paragraph' ) {
				/** @var \JsonFormatParagraphNode $childNode */
				$text .= " " . $this->readText( $childNode );
			}
		}
		return $text;
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

	private function clearEmptyParagraphs( &$paragraphs ) {
		$paragraphs = array_filter( $paragraphs, function( $element ) {
			if ( $element["type"] == "paragraph" ) {
				return strlen( trim( $element["text"] ) ) > 0;
			}
			return true;
		});
	}

	public function newParagraph( &$sectionElements) {
		$sectionElements[] = [ "type" => "paragraph", "text" => "" ];
	}

	/**
	 * @param String[] $sectionElements
	 * @param String $inlineText
	 */
	public function appendInline( &$sectionElements, $inlineText ) {
		$inlineText = trim( $inlineText );
		if ( $inlineText == "" ) {
			return;
		}
		if( sizeof( $sectionElements ) == 0 ) {
			$sectionElements[] = [ "type" => "paragraph", "text" => "" ];
		}
		if ( $sectionElements[ sizeof($sectionElements) - 1 ]["type"] != "paragraph" ) {
			$sectionElements[] = [ "type" => "paragraph", "text" => "" ];
		}
		$sectionElements[ sizeof($sectionElements) - 1 ]["text"] .= " " . $inlineText;
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
		for ( $i = 0; $i < sizeof($sections); $i+=1 ) {
			$section = $sections[$i];
			/** @var \JsonFormatSectionNode $section  */
			$content = [];
			$images = [];
			$this->getParagraphs( $section, $content );
			$this->getImages( $section, $images );
			if ( sizeof($content) == 0 && sizeof($images) == 0
				&& ( ( $i == sizeof($sections)-1 ) || ($sections[$i]->getLevel() >= $sections[$i+1]->getLevel()) ) ) {
				continue;
			}
			$this->clearEmptyParagraphs( $content );
			$returnSections[] = [
				"title" => ( $section->getType() == "section" ) ? $section->getTitle() : "",
				"level" => ( $section->getType() == "section" ) ? $section->getLevel() : 1,
				"content" => $content,
				"images" => $images
			];
		}
		return [
			"sections" => $returnSections
		];
	}
}
