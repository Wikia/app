<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * parts structure WCName.
 * Contains all information needed to be known about one name,
 * such as an author, editor, translator, composer, etc.
 */
class WCName extends WCData implements Iterator {

	# The numerical order of the name.
	public $nameNumber;

	/**
	 * An array of name parts keyed to WCNamePartEnum keys
	 */
	protected $parts = array();

	/**
	 * Constructor.
	 * @param WCScopeEnum $scope = the scope (i.e., work, container, series, etc.)
	 * @param WCNameTypeEnum $nameType = the type of name.
	 * @param integer $nameNumber = the numerical order of the name.
	 */
	public function __construct( $nameNumber ) {
		$this->nameNumber = $nameNumber;
	}


	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function key() {
		return key( $this->parts );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function current() {
		return current( $this->parts );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function next() {
		return next( $this->parts );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function valid() {
		return (bool) current( $this->parts );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function rewind() {
		return reset( $this->parts );
	}


	public function getPart( $partKey ) {
		if ( isset( $this->parts[ $partKey ] ) ) {
			return $this->parts[ $partKey ];
		} else {
			return Null;
		}
	}


	public function setPart( WCNamePartEnum $part, $value ) {
		$this->parts[ $part->key ] = $value;
	}


	/**
	 * Determine if $this can be considered a short form of argument.
	 * If so, then determine the number of matches.
	 *
	 * @param WCName $name
	 * @return integer|boolean
	 */
	public function shortFormMatches( WCData $name ) {
		$matches = 0;
		foreach( $this->parts as $partKey => $part ) {
			$otherPart = $name->getPart( $partKey );
			if ( isset( $otherPart ) && strnatcasecmp( $part, $otherPart ) === 0 ) {
				++$matches;
			} else {
				return False;
			}
		}
		return $matches;

	}


	/**
	 * Composes a single name based on name parts and flags
	 *
	 * @param boolean $namesort = whether the surname appears first
	 * @return string = composed name
	 */
	public function render(
			WCStyle $style,
			WCCitationLengthEnum $citationLength,
			$endSeparator = '',
			$namesort = False ) {


		$surname = isset( $this->parts[ WCNamePartEnum::surname ] ) ?
			$this->parts[ WCNamePartEnum::surname ] : Null;
		$given   = isset( $this->parts[ WCNamePartEnum::given ] ) ?
			$this->transformGivenNames( $this->parts[ WCNamePartEnum::given ] ) : Null;
		$link    = isset( $this->parts[ WCNamePartEnum::nameLink ] ) ?
			$this->parts[ WCNamePartEnum::nameLink ] : Null;
		$dp      = isset( $this->parts[ WCNamePartEnum::droppingParticle ] ) ?
			$this->parts[ WCNamePartEnum::droppingParticle ] : Null;
		$dpSpace = $ndpSpace = $suffixSpace = '';
		if ( $dp ) {
			# if the dropping particle ends in punctuation, there is no space between it and the surname or dropping particle.
			if ( preg_match( '/\p{P}$/u', $dp, $matches ) ) {
				$dpSpace = '';
			} else {
				$dpSpace = $style->nameWhitespace;
			}
		}
		$ndp     = isset( $this->parts[ WCNamePartEnum::nonDroppingParticle ] ) ?
			$this->parts[ WCNamePartEnum::nonDroppingParticle ] : Null;
		if ( $ndp ) {
			# if the non-dropping particle ends in punctuation, there is no space between it and the surname.
			if ( preg_match( '/\p{P}$/u', $ndp, $matches ) ) {
				$ndpSpace = '';
			} else {
				$ndpSpace = $style->nameWhitespace;
			}
		}
		$suffix  = isset( $this->parts[ WCNamePartEnum::suffix ] ) ?
			$this->parts[ WCNamePartEnum::suffix ] : Null;
		if ( $suffix ) {
			$suffixSpace = $style->nameSuffixDelimiter;
		}
		$literal = isset( $this->parts[ WCNamePartEnum::literal ] ) ?
			$this->parts[ WCNamePartEnum::literal ] : Null;

		# literal/organizational name
		if ( $literal ) {
			# Trim redundant separator characters
			$chrL = mb_substr( $literal, -1, 1 );
			$chrR = mb_substr( $endSeparator, 0, 1 );
			if ( $chrL == $chrR ) {
				$endSeparator = ltrim( $endSeparator, $chrR );
			}
			return WCStyle::makeWikiLink( $link, $literal, WCStyle::nameHTML ) . $endSeparator;
		};

		$pre = $post = '';

		# short form
		if ( $citationLength->key == WCCitationLengthEnum::short ) {
			if ( $surname ) {
				if ( $ndp ) {
					$surname = $ndp . $ndpSpace . $surname;
				}
			} else {
				if ( $link ) {
					$post = $link;
				} elseif ( $given ) {
					$post = $given;
				} else {
					$post = $dp . $dpSpace . $ndp . $ndpSpace . $style->missingName . $suffixSpace . $suffix;
				}
			}
		}

		# long form, name sort order
		elseif ( $namesort ) {
			if ( $surname ) {
				if ( !$style->demoteNonDroppingParticle && $ndp ) {
					$pre = $ndp . $ndpSpace;
				}
				if ( $given ) {
					$post = $style->sortOrderSurnameDelimiter . $given;
					if ( $dp ) {
						$post .= $style->nameWhitespace . $dp;
					}
					if ( $style->demoteNonDroppingParticle && $ndp ) {
						if ( $dp ) {
							$post .= $dpSpace;
						} else {
							$post .= $style->nameWhitespace;
						}
						$post .= $ndp;
					}
				} else {
					if ( $dp ) {
						$post .= $style->sortOrderSurnameDelimiter . $dp;
					}
					if ( $style->demoteNonDroppingParticle && $ndp ) {
						if ( $dp ) {
							$post .= $dpSpace;
						} else {
							$post .= $style->nameWhitespace;
						}
						$post .= $ndp;
					}
				}
				if ( $suffix ) {
					$post .= $suffixSpace . $suffix;
				}
			} elseif ( $link ) {
				$post = $link;
			} elseif ( $given ) {
				if ( $dp || $ndp || $suffix ) {
					if ( !$style->demoteNonDroppingParticle && $ndp ) {
						$post = $ndp . $ndpSpace;
					}
					$post = $style->missingName . $style->sortOrderSurnameDelimiter . $given;
					if ( $dp ) {
						$post .= $style->nameWhitespace . $dp;
					}
					if ( $style->demoteNonDroppingParticle && $ndp ) {
						if ( $dp ) {
							$post .= $dpSpace;
						} else {
							$post .= $style->nameWhitespace;
						}
						$post .= $ndp;
					}
					if ( $suffix ) {
						$post .= $suffixSpace . $suffix;
					}
				} else {
					$post = $given;
				}
			} else {
				if ( !$style->demoteNonDroppingParticle && $ndp ) {
					$post = $ndp . $ndpSpace;
				} else {
					$post = '';
				}
				$post = $style->missingName . $style->sortOrderSurnameDelimiter . $style->missingName;
				if ( $dp ) {
					$post .= $style->nameWhitespace . $dp;
				}
				if ( $style->demoteNonDroppingParticle && $ndp ) {
					if ( $dp ) {
						$post .= $dpSpace;
					} else {
						$post .= $style->nameWhitespace;
					}
					$post .= $ndp;
				}
				if ( $suffix ) {
					$post .= $suffixSpace . $suffix;
				}
			}
		}

		# long form, non-name sort order
		else {
			if ( $surname ) {
				if ( $given ) {
					$pre = $given . $style->nameWhitespace;
				}
				$pre .= $dp . $dpSpace . $ndp . $ndpSpace;
				$post = $suffixSpace . $suffix;
			} elseif ( $link ) {
				$post = $link;
			} elseif ( $given ) {
				$post = $given . $style->nameWhitespace;
				if ( $dp || $ndp || $suffix ) {
					$post .= $dp . $dpSpace . $ndp . $ndpSpace . $style->missingName . $suffixSpace . $suffix;
				}
			} else  {
				$post = $style->missingName . $style->nameWhitespace;
				if ( $dp ) {
					$post .= $dp . $dpSpace . $ndp . $ndpSpace . $style->missingName . $suffixSpace . $suffix;
				}
			}
		}

		$htmlClass = WCStyle::nameHTML;

		if ( $namesort ) {
			$surnameClass = WCStyle::surnameSortOrderHTML;
		} else {
			$surnameClass = WCStyle::surnameHTML;
		}

		# Trim redundant separator characters
		if ( $post ) {
			$chrL = mb_substr( $post, -1, 1 );
			$chrR = mb_substr( $endSeparator, 0, 1 );
			if ( $chrL == $chrR ) {
				$endSeparator = ltrim( $endSeparator, $chrR );
			}
			if ( $surname) {
				$nameText = $pre . WCStyle::wrapHTMLSpan( $surname, $surnameClass ) . $post;
			} else {
				$nameText = $pre . $post;
			}
		} elseif ( $surname) {
			$chrL = mb_substr( $surname, -1, 1 );
			$chrR = mb_substr( $endSeparator, 0, 1 );
			if ( $chrL == $chrR ) {
				$endSeparator = ltrim( $endSeparator, $chrR );
			}
			if ( $pre ) {
				$nameText = $pre . WCStyle::wrapHTMLSpan( $surname, $surnameClass );
			} else {
				$nameText = $surname;
				$htmlClass .= ' ' . $surnameClass;
			}
		} else {
			$chrL = mb_substr( $pre, -1, 1 );
			$chrR = mb_substr( $endSeparator, 0, 1 );
			if ( $chrL == $chrR ) {
				$endSeparator = ltrim( $endSeparator, $chrR );
			}
			$nameText = $pre;
		}

		return WCStyle::makeWikiLink( $link, $nameText, $htmlClass ) . $endSeparator;

	}


	public function __toString() {
		return implode( ' ', $this->parts );
	}


	public function getSortingParts() {
		if ( isset( $this->parts[ WCNamePartEnum::literal ] ) ) {
			return array( $this->parts[ WCNamePartEnum::literal ] );
		}
		$sortName = '';
		if ( isset( $this->parts[ WCNamePartEnum::surname ] ) ) {
			if ( isset( $this->parts[ WCNamePartEnum::nonDroppingParticle ] ) ) {
				$sortName = $this->parts[ WCNamePartEnum::nonDroppingParticle ] . ' ';
			}
			$sortName .= $this->parts[ WCNamePartEnum::surname ];
		}
		if ( isset( $this->parts[ WCNamePartEnum::given ] ) ) {
			$sortName .= ' ' . $this->parts[ WCNamePartEnum::given ];
		}
		if ( isset( $this->parts[ WCNamePartEnum::suffix ] ) ) {
			$sortName .= ' ' . $this->parts[ WCNamePartEnum::suffix ];
		}
		if ( isset( $this->parts[ WCNamePartEnum::droppingParticle ] ) ) {
			$sortName .= ' ' . $this->parts[ WCNamePartEnum::droppingParticle ];
		}
		return array( $sortName );
	}


	/**
	 * Transform the given names, such as by shortening them to initials only.
	 *
	 * To be defined by child classes. An idname function by default.
	 * @return string
	 */
	protected function transformGivenNames( $givenNames ) {
		return $givenNames;
	}


}

