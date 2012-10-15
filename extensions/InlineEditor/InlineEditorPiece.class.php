<?php
/**
 * InlineEditorPiece is a base (abstract) class for everything that describes a start
 * and end point, and provides some basic functionality. Subclasses have to implement
 * getStart() and getEnd(), and then things like getLength(), equals(), etc. are provided
 * for your convenience. 
 */
abstract class InlineEditorPiece {
	/**
	 * Get the start position of the piece, to be implemented by an extending class.
	 * @return int
	 */
	abstract public function getStart();
	
	/**
	 * Get the end position of the piece, to be implemented by an extending class.
	 * @return int
	 */
	abstract public function getEnd();
	
	/**
	 * Get the length by taking the difference between getEnd() and getStart()
	 * @return int
	 */
	public final function getLength() {
		return $this->getEnd() - $this->getStart();
	}
	
	/**
	 * Check whether another piece has the exact same position as this one.
	 * @param $piece
	 * @return bool
	 */
	public final function samePositionAs( InlineEditorPiece $piece ) {
		return ( $piece->getStart() == $this->getStart() && $piece->getEnd() == $this->getEnd() );
	}
	
	/**
	 * Check whether another piece is exactly the same as this one. By default this is
	 * the same as samePositionAs(), but it can be overridden by a subclass.
	 * @param $piece InlineEditorPiece
	 * @return bool
	 */
	public function equals( InlineEditorPiece $piece ) {
		return $this->samePositionAs( $piece );
	}
	
	/**
	 * Check whether another piece may fit inside this piece.
	 * @param $piece InlineEditorPiece
	 * @return bool
	 */
	public final function canContain( InlineEditorPiece $piece ) {
		return ($piece->getStart() >= $this->getStart() && 
		        $piece->getStart() <= $this->getEnd()   &&
		        $piece->getEnd()   >= $this->getStart() &&
		        $piece->getEnd()   <= $this->getEnd() );
	}
	
	/**
	 * Check whether another piece overlaps with this piece with one character or more.
	 * @param $piece InlineEditorPiece
	 * @return bool
	 */
	public final function hasOverlap( InlineEditorPiece $piece ) {
		return ( $piece->getStart() < $this->getEnd() && $piece->getEnd() > $this->getStart() );
	}
	
	/**
	 * Check whether another piece touches this piece at the start or end.
	 * @param $piece InlineEditorPiece
	 * @return bool
	 */
	public final function touches( InlineEditorPiece $piece ) {
		return ( $piece->getStart() == $this->getEnd() || $piece->getEnd() == $this->getStart() );
	}
	
	/**
	 * Simple check to prevent invalid values.
	 * @return bool
	 */
	public function isValid() {
		return $this->getEnd() > $this->getStart();
	}
}
