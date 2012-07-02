<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Data structure WCTypeData.
 * Stores and renders the work type (e.g., book, article, etc.).
 */
class WCTypeData extends WCData {

	/**
	 * The enumerated attribute.
	 * @var WCParameterEnum
	 */
	public $parameter;


	/**
	 * Constructor.
	 *
	 * Tests to see whether $value is a valid parameter. If not, it throws a
	 *		exception if $wikiCitationValidateArguments is set.
	 * @global $wikiCitationValidateArguments
	 * @param string|WCParameterEnum $value = the text, which may or may not be a
	 *		valid parameter, or the WCParameterEnum object.
	 */
	public function __construct( $value = Null ) {

		if ( $value instanceOf WCSourceTypeEnum ) {
			$parameterType = $value;
		} else {
			global $wikiCitationValidateArguments;
			$parameterType = WCSourceTypeEnum::match( $value, WCSourceTypeEnum::$magicWordArray,
					WCSourceTypeEnum::$flipMagicWordKeys, 'WCTypeEnum' );
			if ( !$parameterType && $wikiCitationValidateArguments ) {
				throw new WCException( 'wc-type-parameter-unknown', $parameterType );
			}
		}
		$this->parameter = $parameterType;
	}


	public function __toString() {
		return (string) $this->parameter;
	}


	/**
	 * Determine if $this can be considered a short form of the argument.
	 * If so, then determine the number of matches.
	 *
	 * @param WCTypeData $typeData
	 * @return integer|boolean
	 */
	public function shortFormMatches( WCData $typeData ) {
		return $this->parameter === $typeData->parameter ? 1 : False;
	}

}

