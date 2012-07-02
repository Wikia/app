<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCConditionalSegment extends WCWrapperSegment {

	/**
	 * Construct a conditional segment.
	 * If $condition is true, use the first segment.
	 * Otherwise, use the second segment if it is defined.
	 * If not defined, then segment does not exist.
	 */
	public function __construct( $condition, WCSegment $segment1, WCSegment $segment2 = Null ) {
		if ( $condition ) {
			parent::__construct( $segment1 );
			$this->exists = True;
		} elseif ( $segment2 == Null ) {
			$this->exists = False;
		} else {
			parent::__construct( $segment2 );
			$this->exists = True;
		}
	}


	/**
	 * Unlike other WCWrapperSegment objects, if the wrapper does not exist,
	 * the underlying segment is not cancelled. Thus, one may use a reference
	 * to the same (non-canceled) object in multiple places within a
	 * WCGroupSegment, turning them off independently.
	 * @return boolean
	 */
	public function exists() {
		return $this->exists;
	}


	public function render( WCStyle $style, $endSeparator = '' ) {
		return $this->segment->render( $style, $endSeparator );
	}


}
