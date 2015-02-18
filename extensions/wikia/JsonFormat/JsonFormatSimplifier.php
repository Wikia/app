<?php


namespace Wikia\JsonFormat;


use Wikia\Measurements\Time;

class JsonFormatSimplifier {

	protected function getParagraphs( \JsonFormatContainerNode $containerNode, &$contentElements ) {
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
					"elements" => $this->processList( $childNode )
				];
			}
		}
	}

	protected function processList( \JsonFormatContainerNode $childNode ) {
		$out = [];
		$text = null;
		$children = $childNode->getChildren();
		$numChild = count( $children );
		$i = 0;

		if ( $numChild ) {
			$text = $this->readText( $childNode );
			$elements = [];
			$listItem = false;

			while ( $i < $numChild ) {
				$type = $children[ $i ]->getType();
				if ( $type == 'list' ) {
					$elements = array_merge( $elements, self::processList( $children[ $i ] ) );
				}
				elseif ( $type == 'listItem' ) {
					$listItem = true;
					$arr = $this->processList( $children[ $i ] );
					$out[ ] = array_shift( $arr );
				}
				$i++;
			}

			if ( !$listItem ) {
				$out[ ] = ['text' => $text, 'elements' => $elements];
			}
		}

		return $out;
	}

	protected function readText( \JsonFormatContainerNode $parentNode ) {
		$texts = [];
		foreach ( $parentNode->getChildren() as $childNode ) {
			$type = $childNode->getType();
			if ( $type == 'text' || $type == "link" ) {
				$texts[] = $childNode->getText();
			} else if ( $type == 'paragraph' ) {
				$texts[] = $this->readText( $childNode );
			}
		}
		return trim(implode("", $texts));
	}

	private function getImages( \JsonFormatContainerNode $containerNode, &$images ) {
		foreach( $containerNode->getChildren() as $childNode ) {
			$type = $childNode->getType();
			if ( $type == 'section' ) {
				return;
			} else if ( $type == 'image' && !$childNode->isBlank() ) {
				/** @var \JsonFormatImageNode $childNode  */
				$images[] = [
					"src" => $childNode->getSrc()
				];
			} else if ( $type == 'imageFigure' ) {
				/** @var \JsonFormatImageFigureNode $childNode  */
				$images[] = [
					"src" => $childNode->getSrc(),
					"caption" => $childNode->getCaption()
				];
			} else if ( $type == 'paragraph' ) {
				$this->getParagraphs( $childNode, $paragraphs );
			}
		}
	}

	private function clearParagraphs( &$paragraphs ) {
		$paragraphs = array_values( array_filter( array_map ( function( $element ) {
			if ( $element["type"] == "paragraph" ) {
				$element['text'] = trim($element['text']);
				if ($element['text'] == "") return false;
			}
			return $element;
		}, $paragraphs )));
	}

	private function newParagraph( &$sectionElements) {
		$sectionElements[] = [ "type" => "paragraph", "text" => "" ];
	}

	/**
	 * @param String[] $sectionElements
	 * @param String $inlineText
	 */
	private function appendInline( &$sectionElements, $inlineText ) {
		if( count( $sectionElements ) == 0 || $sectionElements[count($sectionElements) - 1 ]["type"] != "paragraph") {
			if ( trim($inlineText) != "" ) {
				$sectionElements[] = [ "type" => "paragraph", "text" => $inlineText ];
			}
		} else {
			$sectionElements[ count($sectionElements) - 1 ]["text"] .= $inlineText;
		}
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


	public function simplify( \JsonFormatRootNode $rootNode, $articleTitle ) {
		$timer = Time::start([__CLASS__, __METHOD__]);
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
			$this->clearParagraphs( $content );
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
		$timer->stop();
		return [
			"sections" => $returnSections
		];
	}
}
