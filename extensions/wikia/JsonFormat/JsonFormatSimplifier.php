<?php


namespace Wikia\JsonFormat;


class JsonFormatSimplifier {

	private function getParagraphs( \JsonFormatContainerNode $containerNode, &$contentElements ) {
		foreach( $containerNode->getChildren() as $childNode ) {
			if ( $childNode->getType() == 'section' ) {
				return;
			} else if ( $childNode->getType() == 'link' ) {
				/** @var \JsonFormatLinkNode $childNode */
				$this->appendInline( $contentElements, $childNode->getText() );
			} else if ( $childNode->getType() == 'text' ) {
				/** @var \JsonFormatTextNode $childNode */
				$this->appendInline( $contentElements, $childNode->getText() );
			} else if ( $childNode->getType() == 'paragraph' ) {
				/** @var \JsonFormatParagraphNode $childNode */
				$this->newParagraph( $contentElements );
				$this->getParagraphs( $childNode, $contentElements );
			} else if ( $childNode->getType() == "list" ) {

				$contentElements[ ] = [
					"type" => "list",
					"elements" => self::processList( $childNode )
				];
			}
		}
	}

	private static function processList( \JsonFormatNode $childNode ) {
		$out = [];
		$text = null;

		$children = $childNode->getChildren();
		$numChild = count( $children );

		$i = 0;

		if ( $numChild ) {

			while ( $i < $numChild ) {
				$type = $children[ $i ]->getType();

				if ( $type == 'text' ) {
					$text = $children[ $i ]->getText();

					$elements = [];
					$i++;

					if ( $i < $numChild && $children[ $i ]->getType() == 'list' ) {
						$elements = self::processList( $children[ $i ] );
					}
					else {
						$i--;
					}

					$out[ ] = ['text' => $text, 'elements' => $elements];

				}
				elseif ( $type == 'listItem' ) {
					$arr = self::processList( $children[ $i ] );
					$out[ ] = array_shift( $arr );
				}

				$i++;
			}
		}

		return $out;
	}


	private function readText( \JsonFormatContainerNode $parentNode ) {
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

	private function getImages( \JsonFormatContainerNode $containerNode, &$images ) {
		foreach( $containerNode->getChildren() as $childNode ) {
			if ( $childNode->getType() == 'section' ) {
				return;
			} else if ( $childNode->getType() == 'image' ) {
				/** @var \JsonFormatImageNode $childNode  */
				$images[] = [
					"src" => $childNode->getSrc()
				];
			} else if ( $childNode->getType() == 'imageFigure' ) {
				/** @var \JsonFormatImageFigureNode $childNode  */
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
		$paragraphs = array_slice( array_filter( $paragraphs, function( $element ) {
			if ( $element["type"] == "paragraph" ) {
				return strlen( trim( $element["text"] ) ) > 0;
			}
			return true;
		}), 0 );
	}

	private function newParagraph( &$sectionElements) {
		$sectionElements[] = [ "type" => "paragraph", "text" => "" ];
	}

	/**
	 * @param String[] $sectionElements
	 * @param String $inlineText
	 */
	private function appendInline( &$sectionElements, $inlineText ) {
		$inlineText = trim( $inlineText, " " );
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
	 * @throws \InvalidParameterApiException
	 */
	public function getJsonFormat( \JsonFormatRootNode $rootNode, $articleTitle ) {
		/** @var \JsonFormatSectionNode[]|\JsonFormatRootNode[] $sections */
		$sections = [];
		$this->findSections( $rootNode, $sections );

		/** @var \JsonFormatSectionNode[]|\JsonFormatRootNode[] $returnSections */
		$returnSections = [];
		for ( $i = sizeof($sections)-1; $i >= 0; $i-=1 ) {
			$section = $sections[$i];
			/** @var \JsonFormatSectionNode $section  */
			$content = [];
			$images = [];
			$this->getParagraphs( $section, $content );
			$this->clearEmptyParagraphs( $content );
			$this->getImages( $section, $images );
			if ( sizeof($content) == 0 && sizeof($images) == 0
				&& ( ( sizeof($returnSections) == 0 ) || ($section->getLevel() >= $returnSections[sizeof($returnSections)-1]["level"]) )
				&& ($sections[$i]->getLevel() != 1 ) ) {
				continue;
			}
			$returnSections[] = [
				"title" => ( $section->getType() == "section" ) ? $section->getTitle() : $articleTitle,
				"level" => ( $section->getType() == "section" ) ? $section->getLevel() : 1,
				"content" => $content,
				"images" => $images
			];
		}
		$returnSections = array_reverse($returnSections);
		return [
			"sections" => $returnSections
		];
	}
}
