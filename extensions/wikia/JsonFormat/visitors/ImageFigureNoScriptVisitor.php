<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 13:59
 */

class ImageFigureNoScriptVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		return
			DomHelper::isElement( $currentNode, 'figure' )
			&& DomHelper::isElement( $currentNode->childNodes->item(0), 'a' )
			&& DomHelper::isElement( $currentNode->childNodes->item(0)->childNodes->item(1), 'noscript' )
			&& DomHelper::isElement( $currentNode->childNodes->item(0)->childNodes->item(1)->childNodes->item(0), 'img' )
			&& DomHelper::isElement( $currentNode->childNodes->item(2), 'figcaption' )
			&& DomHelper::isTextNode( $currentNode->childNodes->item(2)->childNodes->item(0) );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		$img = $currentNode->childNodes->item(0)->childNodes->item(1)->childNodes->item(0);
		/** @var DOMElement $img */
		$src = $img->getAttribute('src');
		$caption = $currentNode->childNodes->item(2)->childNodes->item(0)->textContent;
		$imageFigure = new JsonFormatImageFigureNode( $src, $caption );

		$this->getJsonFormatBuilder()->add( $imageFigure );
	}
}
