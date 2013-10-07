<?php

/**
 * Class TruebloodScrollWrapperVisitor
 * trueblood wiki is using scroll wrapper that looks like this:
 * <table cellpadding="0" cellspacing="0" border="0" style="width:{{{width|100%}}}; margin-bottom:3px; margin-top:3px;">\
 *   <tr>
 *     <td style="background:transparent;">
 *       <div style="overflow:auto; height:500px; width:{{{width|100%}}};  -moz-border-radius-topleft:0.5em; border:0px solid #AAAAAA; padding-left:0.5em; background:transparent;">
 *         {{{content|{{{1}}}}}}
 *       </div>
 *     </td>
 *     <td style="width:5px;"></td>
 *   </tr>
 * </table>
 */
class TruebloodScrollWrapperVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		return DomHelper::isElement( $currentNode, 'table' ) &&
			$currentNode->childNodes->length > 0 &&
			DomHelper::isElement( $currentNode->childNodes->item(0), 'tr' ) &&
			$currentNode->childNodes->item(0)->childNodes->length > 0 &&
			DomHelper::isElement( $currentNode->childNodes->item(0)->childNodes->item(0), 'td' ) &&
			$currentNode->childNodes->item(0)->childNodes->item(0)->childNodes->length > 0 &&
			DomHelper::isElement( $currentNode->childNodes->item(0)->childNodes->item(0)->childNodes->item(0), 'div' ) &&
			$currentNode->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->attributes->getNamedItem("style") &&
			(strpos($currentNode->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->attributes->getNamedItem("style")->nodeValue, "overflow:auto;") !== false) &&
			$currentNode->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->childNodes->length > 0;
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		//die($currentNode->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->nodeValue);
		$this->iterate($currentNode->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->childNodes);
	}
}
