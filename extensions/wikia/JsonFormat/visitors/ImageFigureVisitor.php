<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 13:59
 */

class ImageFigureVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		return
			DomHelper::isElement( $currentNode, 'figure' )
			&& DomHelper::isElement( $currentNode->childNodes->item(0), 'a' )
			&& DomHelper::isElement( $currentNode->childNodes->item(0)->childNodes->item(0), 'img' )
			&& DomHelper::isElement( $currentNode->childNodes->item(2), 'figcaption' )
			&& DomHelper::isTextNode( $currentNode->childNodes->item(2)->childNodes->item(0) );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		$figcaption = $currentNode->childNodes->item(2);
		$img = $currentNode->childNodes->item(0)->childNodes->item(0);
		// @var DataElement $figcaption
		// @var DataElement $img

		$src = $img->getAttribute('src');


		$caption = DomHelper::getTextValue($figcaption);

		$imageFigure = new JsonFormatImageFigureNode( $src, $caption );

		$this->getJsonFormatBuilder()->add( $imageFigure );
	}
}

