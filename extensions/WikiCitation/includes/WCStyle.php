<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */

class WCSegmentImportance extends WCEnum {
	const mandatory     = 0;  # The segment must be present, and if not, will show a visible blank.
	const important     = 1;  # The segment should be present, but will be omitted if it cannot be inferred.
	const optional      = 2;  # The segment is optional. If not present, it will not be inferred.
	const __default     = self::mandatory;
}


class WCTextCaseEnum extends WCEnum {
	const normal          = 0;
	const lowercase       = 1;
	const uppercase       = 2;
	const capitalizeFirst = 3;
	const capitalizeAll   = 4;
	const title           = 5;
	const __default       = self::normal;
}


/**
 * An abstract class providing some of the functionality of its
 * child referencing styles.
 *
 * @abstract
 */
abstract class WCStyle {

	/**
	 * Constants
	 */
	const citationHTML         = 'citation';  # HTML class for a citation as a whole
	const errorHTML            = 'error';     # class for validation errors in citation template
	const italicTitleHTML      = 'italic';    # class for italic titles
	const quotedTitleHTML      = 'quoted';    # class for quoted titles
	const nameHTML             = 'name';      # class for names
	const surnameHTML          = 'surname';   # class for surnames
	const surnameSortOrderHTML = 'sortorder'; # class for surnames in sort order

	/**
	 * General style variables.
	 */
	# HTML class (must be redefined by children)
	public $styleHTML = '';      # class representing the citation style--children should redefine

	# citation separators and punctuation
	public $segmentMissing;      # blank to indicate missing segment
	public $rangeDelimiter;      # delimiter for ranges

	# Labels
	public $nameLabels, $propertyLabels, $circaLabels;

	/**
	 * Title style variables.
	 */
	# switch
	public $punctuationInQuotes   = False; # whether punctuation such as commas or periods is inside quotes, or outside
	public $replaceAmpersands     = False; # whether ampersand ("&") is replaced with "and"
	public $eraWithoutPunctuation = False; # whether the era is written as AD, BC, BCE, etc. rather than A.D., etc.
	public $eraNoSpace            = False; # whether there is a space between the year and the era
	public $eraBeforeYear         = False; # whether the era appears before or after the year


	# citation separators and punctuation
	public $iExQuote;             # initial exterior quote symbol
	public $fExQuote;             # final exterior quote symbol
	public $iInQuote;             # initial interior quote symbol
	public $fInQuote;             # final interior quote symbol

	/**
	 * Date style variables.
	 */
	# flags
	public $stripMonthPeriods; # boolean; e.g. Jan or Feb

	# citation text, separators, and punctuation
	public $ad, $adNoPunct;    # AD
	public $ce, $ceNoPunct;    # CE
	public $bc, $bcNoPunct;    # BC
	public $bce, $bceNoPunct;  # BCE

	# literal text
	public $personalCommunication;

	/**
	 * Name style variables
	 */
	# name formatting flag
	public $demoteNonDroppingParticle;

	# formatting strings:
	public $nameWhitespace;            # whitespace between name name parts
	public $sortOrderDelimiter;        # punctuation between name name parts in name-sort mode
	public $missingName;               # blank to represent a missing name
	public $sortOrderSurnameDelimiter; # punctuation after surname in name-sort mode
	public $nameSuffixDelimiter;       # delimiter before name suffix

	/**
	 * Names style variables
	 */
	# name formatting flags
	public $etAlMin;                 # when names exceeds this value, 'et al.' is used...
	public $etAlUseFirst;            # ...and the number of names is dropped to this number.
	public $etAlSubsequentMin;       # same as $etAlMin, except applies in later cites referencing earlier cites
	public $etAlSubsequentUseFirst;  # same as $etAlUseFirst, except applies in later cites referencing earlier cites

	# name formatting delimiters and punctuation:
	public $namesDelimiter; # the normal punctuation between names
	public $etAlDelimiter;  # the punctuation before "et al." or equivalent
	public $and2;           # the delimiter between two names if there are only two
	public $and3;           # the last delimiter for three or more names
	public $etAl;           # "and others"

	/**
	 * Convenience variables
	 */
	protected $mandatory, $important, $optional;
	protected $normalCase, $lowercase, $uppercase, $capitalizeFirst, $capitalizeAll, $titleCase;
	protected $labelFormNone, $labelFormLong, $labelFormVerb, $labelFormShort, $labelFormVerbShort, $labelFormSymbol;
	protected $singular, $plural;
	protected $contextual, $alwaysPlural, $neverPlural;
	protected $before, $after;


	/**
	 * Constructor.
	 */
	public function __construct() {

		# Convenience variables
		$this->mandatory        = new WCSegmentImportance( WCSegmentImportance::mandatory );
		$this->important        = new WCSegmentImportance( WCSegmentImportance::important );
		$this->optional         = new WCSegmentImportance( WCSegmentImportance::optional );
		$this->first            = new WCCitationPosition( WCCitationPosition::first );
		$this->subsequent       = new WCCitationPosition( WCCitationPosition::subsequent );
		$this->normalCase       = new WCTextCaseEnum( WCTextCaseEnum::normal );
		$this->lowercase        = new WCTextCaseEnum( WCTextCaseEnum::lowercase );
		$this->uppercase        = new WCTextCaseEnum( WCTextCaseEnum::uppercase );
		$this->capitalizeFirst  = new WCTextCaseEnum( WCTextCaseEnum::capitalizeFirst );
		$this->capitalizeAll    = new WCTextCaseEnum( WCTextCaseEnum::capitalizeAll );
		$this->titleCase        = new WCTextCaseEnum( WCTextCaseEnum::title );
		$this->labelFormNone      = new WCLabelFormEnum( WCLabelFormEnum::none );
		$this->labelFormLong      = new WCLabelFormEnum( WCLabelFormEnum::long );
		$this->labelFormVerb      = new WCLabelFormEnum( WCLabelFormEnum::verb );
		$this->labelFormShort     = new WCLabelFormEnum( WCLabelFormEnum::short );
		$this->labelFormVerbShort = new WCLabelFormEnum( WCLabelFormEnum::verbShort );
		$this->labelFormSymbol    = new WCLabelFormEnum( WCLabelFormEnum::symbol );
		$this->singular           = new WCPluralEnum( WCPluralEnum::singular );
		$this->plural             = new WCPluralEnum( WCPluralEnum::plural );
		$this->contextual         = new WCLabelPluralEnum( WCLabelPluralEnum::contextual );
		$this->alwaysPlural       = new WCLabelPluralEnum( WCLabelPluralEnum::always );
		$this->neverPlural        = new WCLabelPluralEnum( WCLabelPluralEnum::never );
		$this->before             = new WCRelativePositionEnum( WCRelativePositionEnum::before );
		$this->after              = new WCRelativePositionEnum( WCRelativePositionEnum::after );


		# General style variables.
		$this->biblioSegSep              = wfMsg( 'wc-biblio-segment-separator' );
		$this->noteSegSep                = wfMsg( 'wc-note-segment-separator' );
		$this->inlineSegSep              = wfMsg( 'wc-inline-segment-separator' );
		$this->biblioEndPunct            = wfMsg( 'wc-biblio-segment-end-punct' );
		$this->noteEndPunct              = wfMsg( 'wc-note-segment-end-punct' );
		$this->segmentMissing            = wfMsg( 'wc-segment-missing' );
		$this->rangeDelimiter            = wfMsg( 'wc-range-delimiter' );

		# Labels.
		$this->nameLabels = array();
		foreach( array(
			WCNameTypeEnum::author            => 'author',
			WCNameTypeEnum::publisher         => 'publisher',
			WCNameTypeEnum::editorTranslator  => 'editor-translator',
			WCNameTypeEnum::editor            => 'editor',
			WCNameTypeEnum::translator        => 'translator',
			WCNameTypeEnum::interviewer       => 'interviewer',
			WCNameTypeEnum::recipient         => 'recipient',
			WCNameTypeEnum::composer          => 'composer',
			) as $key => $name ) {
			foreach ( array(
				WCLabelFormEnum::long        => 'long',
				WCLabelFormEnum::verb        => 'verb',
				WCLabelFormEnum::short       => 'short',
				WCLabelFormEnum::verbShort   => 'verb-short',
				WCLabelFormEnum::symbol      => 'symbol',
				) as $form => $formText ) {
				foreach ( array(
					WCPluralEnum::singular   => 'singular',
					WCPluralEnum::plural     => 'plural',
					) as $num => $numText ) {
					$this->nameLabels[ $key ][ $form ][ $num ] = wfMsg( 'wc-' . $name . '-' . $formText . '-' . $numText );
				}
			}
		}
		$this->propertyLabels = array();
		foreach( array(
			WCPropertyEnum::page              => 'page',
			WCPropertyEnum::section           => 'section',
			WCPropertyEnum::paragraph         => 'paragraph',
			WCPropertyEnum::volume            => 'volume',
			WCPropertyEnum::issue             => 'issue',
			) as $key => $name ) {
			foreach ( array(
				WCLabelFormEnum::long         => 'long',
				WCLabelFormEnum::verb         => 'verb',
				WCLabelFormEnum::short        => 'short',
				WCLabelFormEnum::verbShort    => 'verb-short',
				WCLabelFormEnum::symbol       => 'symbol',
				) as $form => $formText ) {
				foreach ( array(
					WCPluralEnum::singular    => 'singular',
					WCPluralEnum::plural      => 'plural',
					) as $num => $numText ) {
					$this->propertyLabels[ $key ][ $form ][ $num ] = wfMsg( 'wc-' . $name . '-' . $formText . '-' . $numText );
				}
			}
		}
		$this->circaLabels = array();
		foreach ( array(
			WCLabelFormEnum::long         => 'long',
			WCLabelFormEnum::verb         => 'verb',
			WCLabelFormEnum::short        => 'short',
			WCLabelFormEnum::verbShort    => 'verb-short',
			WCLabelFormEnum::symbol       => 'symbol',
			) as $form => $formText ) {
			foreach ( array(
				WCPluralEnum::singular    => 'singular',
				WCPluralEnum::plural      => 'plural',
				) as $num => $numText ) {
				$this->dateTermLabels[ $key ][ $form ][ $num ] = wfMsg( 'wc-circa-' . $formText . '-' . $numText );
			}
		}

		# Title style variables.
		$this->iExQuote            = wfMsg( 'wc-initial-exterior-quote' );
		$this->fExQuote            = wfMsg( 'wc-final-exterior-quote' );
		$this->iInQuote            = wfMsg( 'wc-initial-interior-quote' );
		$this->fInQuote            = wfMsg( 'wc-final-interior-quote' );

		# Date style variables.
		$this->stripMonthPeriods   = False;
		$this->monthDayYear        = True;  # Whether month-day-year is preferred over day-month-year
		$this->ad                  = wfMsg( 'wc-ad' );
		$this->adNoPunct           = wfMsg( 'wc-ad-no-punct' );
		$this->ce                  = wfMsg( 'wc-ce' );
		$this->ceNoPunct           = wfMsg( 'wc-ce-no-punct' );
		$this->bc                  = wfMsg( 'wc-bc' );
		$this->bcNoPunct           = wfMsg( 'wc-bc-no-punct' );
		$this->bce                 = wfMsg( 'wc-bce' );
		$this->bceNoPunct          = wfMsg( 'wc-bce-no-punct' );

		$this->spring              = wfMsg( 'wc_spring' );
		$this->summer              = wfMsg( 'wc_summer' );
		$this->autumn              = wfMsg( 'wc_autumn' );
		$this->winter              = wfMsg( 'wc_winter' );
		$this->year                = wfMsg( 'wc_year' );
		$this->month               = wfMsg( 'wc_month' );
		$this->day                 = wfMsg( 'wc_day' );

		# Literal text
		$this->personalCommunitation = wfMsg( 'wc-personal-communication' );

		# Name style variables.
		$this->demoteNonDroppingParticle = False;
		$this->nameWhitespace            = wfMsg( 'wc-name-whitespace' );
		$this->sortOrderDelimiter        = wfMsg( 'wc-name-sort-order-delimiter' );
		$this->missingName               = wfMsg( 'wc-name-missing' );
		$this->sortOrderSurnameDelimiter = wfMsg( 'wc-surname-delimiter' );
		$this->nameSuffixDelimiter       = wfMsg( 'wc-name-suffix-delimiter' );

		# Names style variables.
		$this->etAlMin                = 3;
		$this->etAlUseFirst           = 1;
		$this->etAlSubsequentMin      = 3;
		$this->etAlSubsequentUseFirst = 1;
		$this->namesDelimiter         = wfMsg( 'wc-names-delim' );
		$this->etAlDelimiter          = wfMsg( 'wc-names-et-al-delim' );
		$this->and2                   = wfMsg( 'wc-names-and-2' );
		$this->and3                   = wfMsg( 'wc-names-and-3' );
		$this->etAl                   = wfMsg( 'wc-names-and-others' );
	}


	/**
	 * Composes a short citation for in-text use.
	 * The resulting citation should omit closing punctuation, and be suitable
	 * for inclusion as part of a larger sentence.
	 * @abstract
	 * @return string
	 */
	abstract public function renderShortInlineCitation( WCCitation $citation );


	/**
	 * Composes a short citation for use in a footnote or endnote.
	 * The resulting citation should include closing sentence punctuation.
	 * @abstract
	 * @return string
	 */
	abstract public function renderShortNoteCitation( WCCitation $citation );


	/**
	 * Composes a short citation for use in an author-date system.
	 * The resulting citation should omit closing sentence punctuation.
	 * @abstract
	 * @return string
	 */
	abstract public function renderShortAuthorDateCitation( WCCitation $citation );


	/**
	 * Composes a long inline citation.
	 * This citation should omit ending punctuation, and be suitable for
	 * inclusion in inline text as part of a larger sentence.
	 * @abstract
	 * @return string
	 */
	abstract public function renderLongInlineCitation( WCCitation $citation );


	/**
	 * Composes a long citation for a bibliography
	 * @abstract
	 * @return string
	 */
	abstract public function renderLongBiblioCitation( WCCitation $citation );


	/**
	 * Composes a long note citation
	 * @abstract
	 * @return string
	 */
	abstract public function renderLongNoteCitation( WCCitation $citation );


	/**
	 * Composes a long author-date citation
	 * @abstract
	 * @return string
	 */
	abstract public function renderLongAuthorDateCitation( WCCitation $citation );


	/**
	 * Create a wikilink. If no article, the function returns the $title.
	 *
	 * @param string $article = the wikipedia article name
	 * @param string $text = text for the link
	 * @param string $classes = the HTML classes.
	 * @return string $text if no $article, otherwise wrap $text in anchor
	 */
	public static function makeWikiLink( $article, $text, $classes = '' ) {
		if ( $article ) {
			$title = Title::newFromText( $article );
			$attribs = array( 'class' => $classes );
			global $wgVersion;
			if ( version_compare( $wgVersion, '1.18', '<' ) ) {
				global $wgUser;
				return $wgUser->getSkin()->link( $title, $text, $attribs );
			} else {
				return Linker::link( $title, $text, $attribs );
			}
		} elseif ( $classes ) {
			return self::wrapHTMLSpan( $text, $classes );
		} else {
			return $text;
		}
	}


	/**
	 * Wrap text in an HTML span element.
	 * @param string $text
	 * @param string $htmlClasses
	 * @return string
	 */
	public static function wrapHTMLSpan( $text, $htmlClasses ) {
		return '<span class="' . $htmlClasses . '">' . $text . '</span>';
	}


	/**
	 * Stylize text as a quotation.
	 *
	 * Eventually, literal quoting might be replaced by html <q> tags, which
	 * are already localized and are more accessible. When browser
	 * compatibility increases, this function will simply wrap the text in
	 * <q>..</q> tags.
	 *
	 * @param string $text
	 * @return string
	 */
	public function quote( $text ) {
		return $this->iExQuote . $text . $this->fExQuote;
	}

	/**
	 * Perform any text transformations of a title that a style may require.
	 * @param string $title
	 * @return string
	 */
	public function transformTitle( $title ) {
		if ( $this->replaceAmpersands ) {
			$title = str_replace( ' &amp; ', ' and ', $title );
		}
		#$title = $wgContLang->ucwords( $title );
		/*
		 * The following are not capitalized:
		 * both definite and indefinite articles
		 * prepositions
		 * coordinating conjunctions
		 * to when used in infinitives
		 * In foreign languages, capitalization follows foreign practice.
		 * After hypen, capitalize if it is a noun, proper adjective, or it has
		 * equal force with the first word.
		 */
		return $title;
	}


	/**
	 * Convert semantic quotes to localized character-based quotes.
	 * When old browsers die, at some point this method will not be necessary,
	 * because the browser should do this conversion itself.
	 *
	 * @param string $text
	 * @param boolean $internal
	 * @return string
	 */
	public function convertSemanticToCharacterQuotes( $text, $internal = False ) {
		if( ! $text ) return '';

		$openPos = mb_stripos( $text, '<q>');
		$closePos = mb_stripos( $text, '</q>');
		if ( is_int( $openPos ) ) {
			if ( is_int( $closePos ) && $closePos < $openPos ) {
				# Next quote is a close quote.
				$head = mb_substr( $text, 0, $closePos );
				$tail = mb_substr( $text, $closePos + 4 );
				$quote = $internal ? $this->fExQuote : $this->fInQuote;
				return $head . $quote . $this->convertSemanticToCharacterQuotes( $tail, ! $internal );
			} else {
				# Next quote is an open quote.
				$head = mb_substr( $text, 0, $openPos );
				$tail = mb_substr( $text, $openPos + 3 );
				$quote = $internal ? $this->iInQuote : $this->iExQuote;
				return $head . $quote . $this->convertSemanticToCharacterQuotes( $tail, ! $internal );
			}
		} elseif ( is_int( $closePos ) ) {
			# Next quote is a close quote.
			$head = mb_substr( $text, 0, $closePos );
			$tail = mb_substr( $text, $closePos + 4 );
				$quote = $internal ? $this->fExQuote : $this->fInQuote;
			return $head . $quote . $this->convertSemanticToCharacterQuotes( $tail, ! $internal );
		} else {
			# No more quotes.
			return $text;
		}
	}


	public function capitalize( $text, WCTextCaseEnum $case ) {
		switch ( $case->key ) {
			case WCTextCaseEnum::normal:
				return $text;

			case WCTextCaseEnum::lowercase:
				return mb_strtolower( $text );

			case WCTextCaseEnum::uppercase:
				return mb_strtoupper( $text );

			case WCTextCaseEnum::capitalizeFirst:
				return mb_strtoupper( mb_substr( $text, 0, 1 ) ) . mb_substr( $text, 1 );

			case WCTextCaseEnum::capitalizeAll: # capitalize every first letter
			    $arr = preg_split('/u', $text, -1, PREG_SPLIT_NO_EMPTY);
				$result = '';
				$mode = false;
				foreach ($arr as $char) {
					$res = preg_match( '/\p{Mn}|\p{Me}|\p{Cf}|\p{Lm}|\p{Sk}|\p{Lu}|\p{Ll}|\p{Lt}|\p{Sk}|\p{Cs}/uS', $char ) == 1;
					if ($mode) {
						if (!$res)
							$mode = false;
					} elseif ($res) {
						$mode = true;
						$char = mb_strtoupper( $char );
					}
					$result .= $char;
				}
				return $result;

			case WCTextCaseEnum::title:
				# This is not implemented yet.
				return mb_strtoupper( mb_substr( $text, 0, 1 ) ) . mb_substr( $text, 1 );
		}
	}

}