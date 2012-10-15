<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


abstract class WCSegment implements Iterator {

	protected $prefix;

	protected $suffix;

	protected $exists;

	public function __construct( $prefix = '', $suffix = '' ) {
		$this->prefix = $prefix;
		$this->suffix = $suffix;
	}

	public function exists() {
		return $this->exists;
	}

	public function cancel() {
		$this->exists = False;
	}

	abstract public function render( WCStyle $style, $endSeparator = '' );

	protected function extendSuffix( $endSeparator ) {
		if ( $this->suffix ) {
			if ( $endSeparator ) {
				$chrL = mb_substr( $this->suffix, -1, 1 );
				$chrR = mb_substr( $endSeparator, 0, 1 );
				if ( $chrL == $chrR ) {
					$endSeparator = ltrim( $endSeparator, $chrR );
				}
				return $this->suffix . $endSeparator;
			} else {
				return $this->suffix;
			}
		} else {
			return $endSeparator;
		}
	}

	abstract public function getSortingParts();

}
