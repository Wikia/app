<?php

/**
 * Class AmericandadWrapperVisitor
 * americandad wiki is using wrapper that looks like this:
 * <div 'style'="padding: 1em 1.5em; min-height:500px;">
 *   <div 'style'="float: right; width: 310px; padding: 35px;">
 * url: http://americandad.wikia.com/wiki/Francine%27s_Flashback
 */
class AmericandadWrapperVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		return DomHelper::isElement( $currentNode, 'div' ) &&
			$currentNode->childNodes->length > 0 &&
			$currentNode->hasAttribute('style') &&
			$currentNode->getAttribute('style') === 'clear:both; width:100%; border:2px solid #1E90FF; background-color:#E3F2FF' &&
			DomHelper::isElement( $currentNode->childNodes->item(0), 'div' ) &&
			$currentNode->childNodes->item(0)->hasAttribute('style') &&
			$currentNode->childNodes->item(0)->getAttribute('style') === 'padding: 1em 1.5em; min-height:500px;';
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		$this->iterate($currentNode->childNodes->item(0)->childNodes);
	}
}
