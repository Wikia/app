<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCCitationPosition extends WCEnum {
	const first           = 0;
	const subsequent      = 1;
#	const ibid            = 2;
#	const ibidWithLocator = 3;
#	const nearNote        = 4;
	const __default       = self::first;
}

/**
 * Class representing the finalized citation.
 *
 * This class reads and processes the data from a WCArgumentReader object,
 * and constructs the appropriate WCStyle child based on the referencing style
 * and citation type. Ultimately, a call to WCCitation::composeCitation()
 * will output the fully-formatted citation.
 */
class WCCitation {

	/**
	 * Associated WCReference object, representing the unique reference source.
	 * For each WCReference instance, there may be many WCCitation instances.
	 * @var WCReference
	 */
	public $reference;


	/**
	 * Position of the citation
	 * (E.g., first, subsequent, etc.)
	 * @var WCCitationPosition
	 */
	public $citationPostion;


	/**
	 * The citation system: notes and bibliography or author-date.
	 * @var WCCitationSystem
	 */
	public $citationSystem;

	/**
	 * Marker for this citation, left behind temporarily in text, and later replaced.
	 * @var unknown_type
	 */
	public $marker;

	/**
	 * The citation style.
	 * @var WCStyle
	 */
	public $style;


	/**
	 * The citation type.
	 * @var WCCitationType
	 */
	public $citationType;

	/**
	 * The citation length.
	 * @var WCCitationLength
	 */
	public $citationLength;

	/**
	 * Distance in number of citations from last citation to this reference
	 * @var integer
	 */
	public $distance;

	/**
	 * Locators for this citation.
	 * @var array of WCLocator objects
	 */
	protected $locators = array();


	# output of the parser
	protected $citationText;


	/**
	 * Constructor.
	 */
	public function __construct( WCReference $reference ) {

		$this->reference = $reference;
		$this->citationPosition = new WCCitationPosition();

		# Construct a random marker for storage and later replacement by the citation:
		$this->marker = 'wC-' . mt_rand();

	}


	/**
	 * Read and parse arguments from a WCArgumentReader object.
	 * @param WCArgumentReader $wcArgumentReader = the argument reader
	 * @global $wikiCitationValidateArguments
	 */
	public function readArguments( WCArgumentReader $argumentReader ) {

		$this->citationType = $argumentReader->getCitationType();
		$this->citationLength = $argumentReader->getCitationLength();

		/**
		 * Recognize and process the parameters and names.
		 */
		foreach( $argumentReader->parameters as $var => $value ) {

			# See if scope name only is present, in which case the parameter is assumed to be the title.
			# This allows the user to enter "journal=Nature" or "work=Origin of Species", etc.
			$scope = WCScopeEnum::match( $var, WCScopeEnum::$magicWordArray,
					WCScopeEnum::$flipMagicWordKeys, 'WCScopeEnum' );
			if ( $scope ) {
				$property = WCPropertyEnum::$title;
				$this->reference->setProperty( $scope, $property, new WCTitle( $value ) );
				continue;
			}

			# Match the parameter scope.
			list( $scope, $parameterText ) = WCScopeEnum::matchPrefix( $var, WCScopeEnum::$magicWordArray,
					WCScopeEnum::$flipMagicWordKeys, 'WCScopeEnum' );
			if ( !$scope ) {
				$scope = WCScopeEnum::$work; # Set the default
			}

			# See if a type name is present, in which case the parameter is assumed to be the title.
			# This allows the wiki editor to enter "book=Origin of Species", "pamphlet=Common Sense," etc., or even "container-encyclopedia=Encyclopedia Brittanica."
			# If either the title or type have already been set, then neither will be set again.
			# Thus, it will be possible to use "book" as a locator.
			$type = WCSourceTypeEnum::match( $parameterText, WCSourceTypeEnum::$magicWordArray,
				WCSourceTypeEnum::$flipMagicWordKeys, 'WCTypeEnum' );
			if ( $type ) {
				$propertyEnumTitle = WCPropertyEnum::$title;
				$propertyEnumType = WCPropertyEnum::$type;
				$title = $this->reference->getProperty( $scope, $propertyEnumTitle );
				$type = $this->reference->getProperty( $scope, $propertyEnumType );
				if ( is_null( $this->reference->getProperty( $scope, $propertyEnumTitle ) ) && is_null( $this->getProperty( $scope, $propertyEnumType ) ) ) {
					$this->reference->setProperty( $scope, $propertyEnumTitle, new WCTitle( $value ) );
					$this->reference->setProperty( $scope, $propertyEnumType, new WCTypeData( $type ) );
				}
				continue;
			}

			global $wikiCitationValidateArguments;

			# Match properties.
			$property = WCPropertyEnum::match( $parameterText, WCPropertyEnum::$magicWordArray,
				WCPropertyEnum::$flipMagicWordKeys, 'WCPropertyEnum' );
			if ( $property ) {
				$attributeKey = $property->getAttribute()->key;
				$attributeClass = WCAttributeEnum::$attribute[ $attributeKey ];
				if ( $attributeKey == WCAttributeEnum::locator ) {
					# Locators disregard the scope.
					$locator = $this->getLocator( $property );
					if ( $wikiCitationValidateArguments && isset( $locator ) ) {
						throw new WCException( 'wc-parameter_defined_twice', $property );
					} else {
						$this->setLocator( $property, new WCLocator( $value ) );
					}
				} else {
					$prop = $this->reference->getProperty( $scope, $property );
					if ( $wikiCitationValidateArguments && isset( $prop ) ) {
						throw new WCException( 'wc-parameter_defined_twice', $property );
					} else {
						$this->reference->setProperty( $scope, $property, new $attributeClass( $value ) );
					}
				}
				# Set attribute
				continue;
			}

			# Match names.
			$match = False;
			list( $nameEnum, $namePartText ) = WCNameTypeEnum::matchPrefix( $parameterText,
				WCNameTypeEnum::$magicWordArray, WCNameTypeEnum::$flipMagicWordKeys, 'WCNameTypeEnum' );
			if ( $namePartText ) {
				list( $namePartEnum, $nameNum ) = WCNamePartEnum::matchPartAndNumber(
						$namePartText, WCNamePartEnum::$magicWordArray, WCNamePartEnum::$flipMagicWordKeys, 'WCNamePartEnum' );
				if ( $namePartEnum ) {
					if ( !$nameEnum ) {
						$nameEnum = new WCNameTypeEnum();
					}
					$match = True;
				} elseif ( $nameEnum ) {
					$namePartEnum = new WCNamePartEnum();
					$match = True;
				}
			} elseif ( $nameEnum ) {
				$namePartEnum = new WCNamePartEnum();
				$nameNum = 1;
				$match = True;
			}
			if ( $match ) {
				if ( is_null( $this->reference->getNames( $scope, $nameEnum ) ) ) {
					$this->reference->setNames( $scope, $nameEnum, new WCNames() );
				}
				$theNames = $this->reference->getNames( $scope, $nameEnum );
				$part = $theNames->getNamePart( $nameNum, $namePartEnum );
				if ( $wikiCitationValidateArguments && isset( $part ) ) {
					throw new WCException( 'wc-parameter_defined_twice', $nameEnum . $nameNum. '-' . $namePartEnum );
				} else {
					$theNames->setNamePart( $nameNum, $namePartEnum, $value );
				}
				continue;
			}

			# Argument has no matches.
			if ( $wikiCitationValidateArguments ) {
				throw new WCException( 'wc-parameter-unknown', $parameterText );
			}
		}

	}


	/**
	 * Renders the citation and stores the result in $this->citation.
	 * @param WCStyle $style
	 * @return array = the rendered citation and sorting parts.
	 */
	public function render() {

		# Build the citation
		if ( $this->citationLength->key == WCCitationLengthEnum::short ) {
			switch ( $this->citationType->key ) {
				case WCCitationTypeEnum::note:
					list( $citation, $sortingParts ) = $this->style->renderShortNoteCitation( $this );
					break;
				case WCCitationTypeEnum::inline:
					list( $citation, $sortingParts ) = $this->style->renderShortInlineCitation( $this );
					break;
				case WCCitationTypeEnum::authorDate:
					list( $citation, $sortingParts ) = $this->style->renderShortAuthorDateCitation( $this );
			}
		} else {
			switch ( $this->citationType->key ) {
				case WCCitationTypeEnum::note:
					list( $citation, $sortingParts ) = $this->style->renderLongNoteCitation( $this );
					break;
				case WCCitationTypeEnum::biblio:
					list( $citation, $sortingParts ) = $this->style->renderLongBiblioCitation( $this );
					break;
				case WCCitationTypeEnum::authorDate:
					list( $citation, $sortingParts ) = $this->style->renderLongAuthorDateCitation( $this );
					break;
				default: # case WCCitationTypeEnum::inline:
					list( $citation, $sortingParts ) = $this->style->renderLongInlineCitation( $this );
			}
		}

		# Wrap the entire citation in an HTML span element with classes.
		$classHTML = WCStyle::citationHTML . ' ' .
			$this->style->styleHTML . ' ' .
			$this->reference->getWorkType() . ' ' .
			$this->citationType . ' ' .
			$this->citationLength;

		return array( WCStyle::wrapHTMLSpan( $citation, $classHTML ), $sortingParts );

	}


	/**
	 * The string representation of this object.
	 * @return string citation as wikitext.
	 */
	final public function __toString() {
		return (string) $this->citationText;
    }


	/**
	 * Infer the intended locator value string based on potentially incomplete
	 * info. The arguments will be revised to reflect the new types.
	 * @param WCPropertyEnum $propertyType
	 * @return WCLocator
	 */
	public function inferLocator( WCPropertyEnum &$locatorType ) {
		foreach( $locatorType as $testLocatorTypeKey ) {
			if ( isset( $this->locators[ $testLocatorTypeKey ] ) ) {
				$locatorType->key = $testLocatorTypeKey;
				return $this->locators[ $testLocatorTypeKey ];
			}
		}
		return Null;

	}


	/**
	 * Getter for a locator.
	 * @param WCPropertyEnum $type
	 * @return WCLocator
	 */
	public function getLocator( WCPropertyEnum $type ) {
		if ( isset( $this->locators[ $type->key ] ) ) {
			return $this->locators[ $type->key ];
		} else {
			return Null;
		}
	}


	/**
	 * Setter for a locator.
	 * @param WCPropertyEnum $type
	 * @param WCLocator $locator
	 */
	public function setLocator( WCPropertyEnum $type, WCLocator $locator ) {
		$this->locators[ $type->key ] = $locator;
	}

}
