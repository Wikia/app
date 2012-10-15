<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCAlternativeSegment extends WCWrapperSegment {

	/**
	 * Choose the first alternative in the array that exists, and cancel all
	 * other alternatives.
	 * @param array $segments Array of WCSegment objects.
	 */
	public function __construct( array $segments = array() ) {
		$this->exists = False;
		$theSegment = Null;
		foreach ( $segments as $segment ) {
			if ( $segment->exists() ) {
				if ( $this->exists ) {
					$segment->cancel();
				} else {
					$this->exists = True;
					$theSegment = $segment;
				}
			}
		}
		parent::__construct( $theSegment );
	}

	
	public function render( WCStyle $style, $endSeparator = '' ) {
		return $this->segment->render( $style, $endSeparator );
	}


}
