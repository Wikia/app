<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 17:35
 */

interface IDOMNodeVisitor {
	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode );

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode );
}
