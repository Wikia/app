<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Data structure WCNames.
 * Contains information about a group of names,
 * such as authors, editors, translators, composers, etc.
 */
class WCNames extends WCData implements Countable, Iterator {

	/**
	 * Array of names
	 * @var array
	 */
	protected $names = array();


	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function count() {
		return count( $this->names );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function key() {
		return key( $this->names );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function current() {
		return current( $this->names );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function next() {
		return next( $this->names );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function valid() {
		return (bool) current( $this->names );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function rewind() {
		return reset( $this->names );
	}


	/**
	 * Sort names on the basis of number.
	 */
	public function sort() {
		ksort( $this->names );
	}


	/**
	 * Determine if $this can be considered a short form of the argument.
	 * If so, then determine the number of matches.
	 *
	 * @param WCNames $names
	 * @return integer|boolean
	 */
	public function shortFormMatches( WCData $names ) {
		$matches = 0;
		foreach( $this->names as $nameKey => $thisName ) {
			$otherName = $names->getName( $nameKey );
			$subMatches = $thisName->shortFormMatches( $otherName );
			if ( $subMatches === False ) {
				return False;
			} else {
				$matches += $subMatches;
			}
		}
		return $matches;

	}


	/**
	 * Renders a section of name info based on a group of names,
	 * such as authors, editors, etc.
	 *
	 * @param boolean $namesort = whether the surname appears first
	 * @return string = rendereded name section
	 */
	public function render(
			WCStyle $style,
			WCCitationPosition $citationPosition,
			WCCitationLengthEnum $citationLength,
			$endSeparator = '',
			$namesort = False ) {

		$nameCount = $this->count();

		# no names:
		if ( !$nameCount ) {
			return '';
		}

		# single name:
		if ( $nameCount == 1 ) {
			return $this->rewind()->render( $style, $citationLength, $endSeparator, $namesort );
		}

		# determine whether we are using "et al." or equivalent
		if( $citationPosition->key == WCCitationPosition::first ) {
			$etAlMin = $style->etAlMin;
			$etAlUseFirst = $style->etAlUseFirst;
		} else {
			$etAlMin = $style->etAlSubsequentMin;
			$etAlUseFirst = $style->etAlSubsequentUseFirst;
		}
		$usingEtAl = $nameCount > $etAlMin;
		if ( $usingEtAl ) {
			$nameCount = $etAlUseFirst;
		}

		# single name with et al.:
		if ( $nameCount == 1 ) {
			$text = $this->rewind()->render( $style, $citationLength, $nameStyle->$etAlDelimiter, $namesort );
		}

		# two names
		elseif ( $nameCount == 2 ) {
			$text = $this->rewind()->render( $style, $citationLength, $style->and2, $namesort );
			if ( $usingEtAl ) {
				$text .= $this->next()->render( $style, $citationLength, $nameStyle->$etAlDelimiter, False );
			} else {
				$text .= $this->next()->render( $style, $citationLength, $endSeparator, False );
			}
		}

		# three or more names:
		else {
			$text = $this->rewind()->render( $style, $citationLength, $style->namesDelimiter, $namesort );
			for ( $i = 2; $i < $nameCount-1; $i++ ) {
				$text .= $this->next()->render( $style, $citationLength, $style->namesDelimiter, False );
			}
			$text .= $this->next()->render( $style, $citationLength, $style->and3, False );
			if ( $usingEtAl ) {
				$text .= $this->next()->render( $style, $citationLength, $nameStyle->$etAlDelimiter, False );
			} else {
				$text .= $this->next()->render( $style, $citationLength, $endSeparator, False );
			}
		}

		# et al.
		if ( $usingEtAl ) {
			# Trim redundant separator characters
			$etal = $style->etAl;
			$chrL = mb_substr( $etal, -1, 1 );
			$chrR = mb_substr( $endSeparator, 0, 1 );
			$text .= $etal;
			if ( $chrL == $chrR ) {
				$endSeparator = ltrim( $endSeparator, $chrR );
			}
			$text .= $endSeparator;

		}

		return $text;
	}


	public function __toString() {
		return implode( ' ', $this->names );
	}


	public function getName( $nameNumber ) {
		if ( isset( $this->names[ $nameNumber ] ) ) {
			return $this->names[ $nameNumber ];
		} else {
			return Null;
		}
	}

	public function setName( $nameNumber, $value ) {
		$this->names[ $nameNumber ] = $value;
	}

	public function getNamePart( $nameNumber, WCNamePartEnum $namePart ) {
		if ( isset( $this->names[ $nameNumber ] ) ) {
			return $this->names[ $nameNumber ]->getPart( $namePart->key );
		} else {
			return Null;
		}
	}

	public function setNamePart( $nameNumber, WCNamePartEnum $namePart, $value ) {
		$name = &$this->names[ $nameNumber ];
		if ( is_null( $name ) ) {
			$name = new WCName( $nameNumber );
		}
		$name->setPart( $namePart, $value );
	}

}

