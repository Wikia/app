<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 22:20
 */

class CompositeVisitor implements IDOMNodeVisitor {
	/**
	 * @var array
	 */
	private $visitors;

	/**
	 * @param array $visitors
	 */
	function __construct( $visitors = array() ) {
		$this->visitors = $visitors;
	}

	/**
	 * @return array
	 */
	public function getVisitors() {
		return $this->visitors;
	}

	/**
	 * @param IDOMNodeVisitor $visitor
	 */
	public function addVisitor( IDOMNodeVisitor $visitor ) {
		$this->visitors[] = $visitor;
	}

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		foreach ( $this->visitors as $visitor ) {
			if( $visitor->canVisit( $currentNode ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		foreach ( $this->visitors as $visitor ) {
			if( $visitor->canVisit( $currentNode ) ) {
				$visitor->visit( $currentNode );
				break;
			}
		}
	}
}
