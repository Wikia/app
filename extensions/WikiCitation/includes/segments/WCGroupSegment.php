<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCGroupSegment extends WCSegment implements Countable {

	public $segments;

	protected $delimiter;

	public function __construct(
			array $segments = array(),
			$delimiter = '',
			$prefix = '',
			$suffix = '' ) {
		parent::__construct( $prefix, $suffix );
		$this->segments = $segments;
		$this->delimiter = $delimiter;
		$this->exists = True;
	}


	public function exists() {
		if ( $this->exists ) {
			foreach ( $this->segments as $segment ) {
				if ( $segment->exists() ) {
					return True;
				}
			}
		}
		$this->exists = False;
		return False;
	}


	public function count() {
		$count = 0;
		foreach ( $this->segments as $segment ) {
			if ( $segment->exists() ) {
				$count++;
			}
		}
		return $count;
	}


	public function render( WCStyle $style, $endSeparator = '' ) {
		$segments = $this->segments;
		while ( $segments ) {
			$lastSegment = array_pop( $segments );
			if ( $lastSegment->exists() ) break;
		}
		if ( $lastSegment->exists() ) {
			$text = $this->prefix;
			foreach( $segments as $segment ) {
				if ( $segment->exists() ) {
					$text .= $segment->render( $style, $this->delimiter );
				}
			}
			return $text . $lastSegment->render( $style, $this->extendSuffix( $endSeparator ) );
		}
		return '';
	}


	public function getSortingParts() {
		$parts = array();
		foreach( $this->segments as $segment ) {
			if ( $segment->exists() ) {
				$parts += $segment->getSortingParts();
			}
		}
		return $parts;
	}


	/**
	 * Implements Iterator interface method.
	 * @return string
	 */
	public function key() {
		$segment = current( $this->segments );
		return key( $this->segments) . '–' . $segment->key();
	}


	/**
	 * Implements Iterator interface method.
	 * @return WCSegment
	 */
	public function current() {
		$segment = current( $this->segments );
		return $segment->current();
	}


	/**
	 * Implements Iterator interface method.
	 */
	public function next() {
		$currentSegment = current( $this->segments );
		if ( $currentSegment === False ) {
			return;
		} else {
			$currentSegment->next();
			if ( ! $currentSegment->valid() ) {
				while ( ! ( ( $nextSegment = next( $this->segments ) ) === False ) ) {
					if ( $nextSegment->exists() ) {
						$nextSegment->rewind();
						if ( $nextSegment->valid() ) {
							return;
						}
					}
				}
			}
		}
	}


	/**
	 * Implements Iterator interface method.
	 * @return boolean
	 */
	public function valid() {
		$segment = current( $this->segments );
		return ( ! ( $segment === False ) ) && $segment->valid() ;
	}


	/**
	 * Implements Iterator interface method.
	 */
	public function rewind() {
		$segment = reset( $this->segments );
		while ( ! $segment->exists() ) {
			if ( next( $this->segments ) == False ) {
				return;
			}
		}
		$segment->rewind();
	}

}
