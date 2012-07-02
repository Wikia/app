<?php
/**
 * This class wraps an InlineEditorMarking to be a part of a tree spanning the
 * wikitext. It is closely connected to the wikitext, and should be recreated whenever a 
 * marking or wikitext changes.
 */
class InlineEditorNode extends InlineEditorPiece {
	protected $wiki;     /// < reference to the original wikitext
	protected $children; /// < array of children (InlineEditorNode)
	protected $isSorted; /// < bool whether or not the children are sorted
	protected $lastEnd;  /// < largest endposition of children, to verify during adding the children are sortd
	protected $marking; /// < marking this nodes wraps
	protected $parent;  /// < parent node (InlineEditorNode)
	
	/**
	 * @param $wiki String Reference to the original wikitext
	 * @param $marking InlineEditorMarking Marking to wrap in the tree
	 */
	public function __construct( &$wiki, InlineEditorMarking $marking ) {
		$this->wiki =& $wiki;
		$this->children = array();
		$this->lastEnd = 0;
		$this->isSorted = true;
		$this->marking  = $marking;
	}
	
	/**
	 * Get the start position from the corresponding marking.
	 * @return int
	 */
	public function getStart() {
		return $this->marking->getStart();
	}
	
	/**
	 * Get the end position from the corresponding marking.
	 * @return int
	 */
	public function getEnd() {
		return $this->marking->getEnd();
	}
	
	/**
	 * Get the id from the corresponding marking.
	 * @return string
	 */
	public function getId() {
		return $this->marking->getId();
	}
	
	/**
	 * Get an array of children of type InlineEditorNode.
	 * @return array
	 */
	public function getChildren() {
		return $this->children;
	}
	
	/**
	 * Get the corresponding marking.
	 * @return InlineEditorMarking
	 */
	public function getMarking() {
		return $this->marking;
	}
	
	/**
	 * Get the parent node.
	 * @return InlineEditorNode
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Render the start tag by calling the corresponding marking.
	 * @return string HTML
	 */
	public function renderStartTag() {
		return $this->marking->renderStartTag();
	}
	
	/**
	 * Render the end tag by calling the corresponding marking.
	 * @return string HTML
	 */
	public function renderEndTag() {
		return $this->marking->renderEndTag();
	}
	
	/**
	 * Add a node to the list of children.
	 * 
	 * Checks whether or not the child can be added. Returns false if it cannot add the
	 * child, and true when it can. The calling class is responsible to add the node to
	 * the innermost node, this will not be done by the function.
	 * 
	 * It is recommended to add nodes from left to right, as this gives the best performance.
	 * 
	 * @param $child InlineEditorNode
	 * @return bool
	 */
	public function addChild( InlineEditorNode $child ) {
		// if we cannot contain the child, we cannot add it
		if( !$this->canContain( $child ) ) return false;
		
		// if the start is before the largest endpoint, check all children for overlap
		if( $child->getStart() < $this->lastEnd) {
			foreach( $this->children as $otherChild ) {
				if( $child->hasOverlap( $otherChild ) ) return false;
			}
			
			// if there is no overlap, we're sure that the list isn't sorted anymore 
			$this->isSorted = false;
		}
		
		// add the child and set the parent of the child to $this
		$this->children[$child->getStart()] = $child;
		$child->parent = $this;
		
		// move $this->lastEnd if needed
		if( $child->getEnd() > $this->lastEnd ) $this->lastEnd = $child->getEnd();
		
		return true;
	}
	
	/**
	 * Find the node with the smallest length still able to contain $piece.
	 * @param $piece InlineEditorPiece
	 * @return InlineEditorNode
	 */
	public function findBestParent( InlineEditorPiece $piece ) {
		// if we cannot contain the piece, return false
		if( !$this->canContain( $piece ) ) return false;
		
		// sorted children is a precondition for the algoritm
		$this->sort();
		
		foreach( $this->children as $start => $child ) {
			// if we've move past the end of the piece, stop
			if( $piece->getEnd() < $start ) break;
			
			// try to fit the piece to this child
			if( $piece->getStart() >= $start ) {
				$fit = $child->findBestParent( $piece );
				// if we found a child that fits the piece, return it
				if( $fit !== false ) {
					return $fit;
				}
			}
		}
		
		// if we cannot find a suitable child, but we can contain it in this piece, return $this
		return $this;
	}
	
	/**
	 * Find the highest level of children that can be fit into a certain piece.
	 * This will return an array of nodes that are best fit.
	 * @param $piece InlineEditorPiece
	 * @return array
	 */
	public function findBestChildren( InlineEditorPiece $piece ) {
		// try to find a parent that fits $piece (which can very well be $this!)
		$parent = $this->findBestParent( $piece );
		
		// if we cannot find a parent, return false
		if( !$parent ) return false;
		
		// if the piece can contain the entire parent piece, just return that piece
		if( $piece->canContain( $parent ) ) return array( $parent );
		
		// sorting is a precondition of the algoritm
		$this->sort();
		
		$children = array();
		foreach( $parent->children as $start => $child ) {
			// if we've moved past the end of the piece, stop
			if( $start > $piece->getEnd() ) break;
			
			// add the child to the list if it can be contained in the piece
			if( $piece->canContain( $child ) ) {
				$children[] = $child;
			}
		}
		return $children;
	}
	
	/**
	 * Render the entire tag, with recursion on the children.
	 * @return string HTML
	 */
	public function render() {
		return $this->renderStartTag() . $this->renderInside() . $this->renderEndTag();
	}
	
	/**
	 * Render the inside of the tag.
	 */
	public function renderInside() {
		$this->sort();
		$lastPos = $this->getStart();
		$output  = '';
		foreach( $this->children as $child ) {
			$output .= substr( $this->wiki, $lastPos, $child->getStart() - $lastPos );
			$output .= $child->render();
			$lastPos = $child->getEnd();
		}
		
		$output .= substr( $this->wiki, $lastPos, $this->getEnd() - $lastPos );
		return $output;
	}
	
	/**
	 * Sort the children by start position (key).
	 */
	protected function sort() {
		if( $this->isSorted ) return;
		ksort( $this->children );
		$this->isSorted = true;
	}
}