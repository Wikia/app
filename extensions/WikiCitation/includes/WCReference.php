<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Class representing a unique reference source.
 *
 * There should be only one instance of this object per unique reference.
 * However, there may be multiple instances per WCCitation object, if the same
 * reference is cited multiple times in an article.
 * Instances of this class are created by the WCCitation object.
 */
class WCReference {

	/**
	 * Unique random ID for this reference, for cross-referencing bibliographies.
	 * @var string
	 */
	public $id;

	/**
	 * Keys of all citations in an article that cite this reference.
	 * This is set by the WCReferenceStore object.
	 * @var unknown_type
	 */
	public $keys = array();

	/**
	 * A multidimensional array of WCNames objects.
	 * Index 1 (:: WCScopeEnum->key) is the scope of the WCNames object (e.g., work).
	 * Index 2 (:: WCNameTypeEnum->key) is the name type of the WCNames object (e.g., author).
	 * @var array [ int ] [ int ] => WCNames
	 */
	protected $names = array();

	/**
	 * A multidimensional array of WCData objects.
	 * Index 1 (:: WCScopeEnum->key) is the scope of the WCData object (e.g., work).
	 * Index 2 (:: WCPropertyEnum->key) is the property type of the WCData object (e.g., title).
	 * @var array [ int ] [ int ] => WCData
	 */
	protected $properties = array();


	/**
	 * Constructor.
	 */
	public function __construct() {
		# Construct a random marker for cross-referencing bibliographies:
		$this->id = 'RwC-' . mt_rand();
	}


	/**
	 * Setter for reference properties.
	 * @param WCScopeEnum $scope
	 * @param WCPropertyEnum $type
	 * @param WCData $data
	 */
	public function setProperty( WCScopeEnum $scope, WCPropertyEnum $type, WCData $data ) {
		$this->properties[ $scope->key ][ $type->key ] = $data;
	}


	/**
	 * Getter for reference properties.
	 * @param WCScopeEnum $scope
	 * @param WCPropertyEnum $type
	 * @return WCData
	 */
	public function getProperty( WCScopeEnum $scope, WCPropertyEnum $type ) {
		if ( isset( $this->properties[ $scope->key ][ $type->key ] ) ) {
			return $this->properties[ $scope->key ][ $type->key ];
		} else {
			return Null;
		}
	}


	/**
	 * Setter for reference names.
	 * @param WCScopeEnum $scope
	 * @param WCNameTypeEnum $type
	 * @param WCNames $names
	 */
	public function setNames( WCScopeEnum $scope, WCNameTypeEnum $type, WCNames $names ) {
		$this->names[ $scope->key ][ $type->key ] = $names;
	}


	/**
	 * Getter for reference names.
	 * @param WCScopeEnum $scope
	 * @param WCNameTypeEnum $names
	 * @return WCNames
	 */
	public function getNames( WCScopeEnum $scope, WCNameTypeEnum $names ) {
		if ( isset( $this->names[ $scope->key ][ $names->key ] ) ) {
			return $this->names[ $scope->key ][ $names->key ];
		} else {
			return Null;
		}
	}


	/**
	 * Finalize the reference after all data has been added.
	 * No data about the reference should be added after this function is called.
	 * The function makes inferences about possible missing data.
	 */
	public function finalize() {

		# If the reference type values are not set, try to infer them.
		$this->setInferredTypes();

		# Make other property inferences
		$this->setInferredProperties();

		# Sort the names on the basis of name key order, maintaining keys.
		foreach( $this->names as $nameTypes ) {
			foreach( $nameTypes as $names ) {
				if ( $names ) {
					$names->sort();
				}
			}
		}

	}


	/**
	 * Infer the intended WCNames object based on potentially incomplete info.
	 * The arguments will be revised to reflect the new types.
	 * @param WCScopeEnum $scope
	 * @param WCNameTypeEnum $nameType
	 * @return WCNames
	 */
	public function inferNames( WCScopeEnum &$scope, WCNameTypeEnum &$nameType ) {
		foreach( $scope as $testScopeKey ) {
			foreach( $nameType as $testNameTypeKey ) {
				if ( isset( $this->names[ $testScopeKey ][ $testNameTypeKey ] ) ) {
					$scope->key = $testScopeKey;
					$nameType->key = $testNameTypeKey;
					return $this->names[ $testScopeKey ][ $testNameTypeKey ];
				}
			}
		}
		return Null;
	}


	/**
	 * Infer the intended property value string based on potentially incomplete
	 * info. The arguments will be revised to reflect the new types.
	 * This method should not be used with locator propreties.
	 * @param WCScopeEnum $scope
	 * @param WCPropertyEnum $propertyType
	 * @return WCData
	 */
	public function inferProperty( WCScopeEnum &$scope, WCPropertyEnum &$propertyType ) {
		foreach( $scope as $testScopeKey ) {
			foreach( $propertyType as $testPropertyTypeKey ) {
				if ( isset( $this->properties[ $testScopeKey ][ $testPropertyTypeKey ] ) ) {
					$scope->key = $testScopeKey;
					$propertyType->key = $testPropertyTypeKey;
					return $this->properties[ $testScopeKey ][ $testPropertyTypeKey ];
				}
			}
		}
		return Null;

	}


	/**
	 * Gets the work type (i.e., book, article, etc.)
	 * @return WCSourceTypeEnum
	 */
	public function getWorkType() {
		if ( isset( $this->properties[ WCScopeEnum::work ][ WCPropertyEnum::type ] ) ) {
			return $this->properties[ WCScopeEnum::work ][ WCPropertyEnum::type ]->parameter;
		} else {
			return WCSourceTypeEnum::$general;
		}
	}


	/**
	 * Gets the container type (i.e., book, periodical, etc.)
	 * @return WCSourceTypeEnum
	 */
	public function getContainerType() {
		if ( isset( $this->properties[ WCScopeEnum::container ][ WCPropertyEnum::type ] ) ) {
			return $this->properties[ WCScopeEnum::container ][ WCPropertyEnum::type ]->parameter;
		} else {
			return WCSourceTypeEnum::$general;
		}
	}


	/**
	 * Gets the series type (i.e., journal, newspaper, etc.)
	 * @return WCSourceTypeEnum
	 */
	public function getSeriesType() {
		if ( isset( $this->properties[ WCScopeEnum::series ][ WCPropertyEnum::type ] ) ) {
			return $this->properties[ WCScopeEnum::series ][ WCPropertyEnum::type ]->parameter;
		} else {
			return WCSourceTypeEnum::$general;
		}
	}


	/**
	 * Determine if $this can be considered a short form of the argument.
	 * If so, then determine the number of matches.
	 *
	 * @param WCNames $names
	 * @return integer|boolean
	 */
	public function shortFormMatches( WCReference $reference ) {
		$matches = 0;
		# Compare names.
		foreach( $this->names as $scopeKey => $nameTypes ) {
			foreach( $nameTypes as $nameTypeKey => $thisNames ) {
				$otherNames = $reference->getNames( new WCScopeEnum( $scopeKey ), new WCNameTypeEnum( $nameTypeKey ) );
				if ( isset( $otherNames ) ) {
					$subMatches = $thisNames->shortFormMatches( $otherNames );
					if ( $subMatches === False ) {
						return False;
					} else {
						$matches += $subMatches;
					}
				}
			}
		}
		# Compare properties.
		foreach( $this->properties as $scopeKey => $propertyTypes ) {
			foreach( $propertyTypes as $propertyTypeKey => $thisProperty ) {
				$otherProperty = $reference->getProperty( new WCScopeEnum( $scopeKey ), new WCPropertyEnum( $propertyTypeKey ) );
				if ( isset( $otherProperty ) ) {
					$subMatches = $thisProperty->shortFormMatches( $otherProperty );
					if ( $subMatches === False ) {
						return False;
					} else {
						$matches += $subMatches;
					}
				}
			}
		}
		return $matches;

	}


	/**
	 * Get a hash value which is roughly (though not always) unique to the citation.
	 * The hash value is author surname concatenated with year.
	 * If no author surname or year are given, the hash is an empty string.
	 * @return string The hash value
	 */
	public function getHash() {
		if ( isset( $this->names[ WCScopeEnum::work ][ WCNameTypeEnum::author ] ) ) {
			$surname = $this->names[ WCScopeEnum::work ][ WCNameTypeEnum::author ]->getNamePart( 1, WCNamePartEnum::$surname );
			if ( $surname ) {
				$hash = $surname;
			} else {
				return '';
			}
		} else {
			return '';
		}
		if ( isset( $this->properties[ WCScopeEnum::work ][ WCPropertyEnum::date ] ) ) {
			$hash .= $this->properties[ WCScopeEnum::work ][ WCPropertyEnum::date ]->year;
			return $hash;
		} else {
			return '';
		}

	}


	/**
	 * Infer the intended property types for each scope, if not set.
	 */
	protected function setInferredTypes() {

		# If any series name or property has been defined:
		if ( isset( $this->names[ WCScopeEnum::series ] ) || isset( $this->properties[ WCScopeEnum::series ] ) ) {
			$series = &$this->properties[ WCScopeEnum::series ][ WCPropertyEnum::type ];
			if ( is_null( $series ) ) {
				# A series property has been defined, but the type has not been defined, assume it is a periodical:
				$series = new WCTypeData( WCSourceTypeEnum::$periodical );
			}
			if ( isset( $this->properties[ WCScopeEnum::work ][ WCPropertyEnum::type ] ) ) {
				return;
			}
			else {
				switch ( $series->parameter->key ) {
					case WCSourceTypeEnum::periodical:
					case WCSourceTypeEnum::journal:
					case WCSourceTypeEnum::magazine:
					case WCSourceTypeEnum::newspaper:
					# If the series is a periodical, the work is likely an article.
						$type = WCSourceTypeEnum::$article;
						break;
					# If the series is designated as a book, encyclopedia or dictionary, the user probably intended it to be the container.
					case WCSourceTypeEnum::book:
						$type = WCSourceTypeEnum::$chapter;
						$this->properties[ WCScopeEnum::container ][ WCPropertyEnum::type ] = $series;
						unset( $series );
						break;
					case WCSourceTypeEnum::encyclopedia:
					case WCSourceTypeEnum::dictionary:
						$type = new WCSourceTypeEnum( WCSourceTypeEnum::entry );
						$this->properties[ WCScopeEnum::container ][ WCPropertyEnum::type ] = $series;
						unset( $series );
						break;
					default:
						$type = new WCSourceTypeEnum( WCSourceTypeEnum::general );
				}
				$this->properties[ WCScopeEnum::work ][ WCPropertyEnum::type ] =
					new WCTypeData( $type );
				return;
			}
		}

		# If any container name or property has been defined:
		if ( isset( $this->names[ WCScopeEnum::container ] ) || isset( $this->properties[ WCScopeEnum::container ] ) ) {
			$container = &$this->properties[ WCScopeEnum::container ][ WCPropertyEnum::type ];
			if ( ! isset( $container ) ) {
				# A series property has been defined, but the type has not been defined, assume it is a periodical:
				$container = new WCTypeData( WCSourceTypeEnum::$book );
			}
			if ( isset( $this->properties[ WCScopeEnum::work ][ WCPropertyEnum::type ] ) ) {
				return;
			}
			else {
				switch ( $container->parameter->key ) {
					# If the series is an encyclopedia or dictionary, the work is likely a book.
					case WCSourceTypeEnum::encyclopedia:
					case WCSourceTypeEnum::dictionary:
						$type = WCSourceTypeEnum::$book;
						break;
					# If the container is designated as a periodical, the user probably intended it to be the series.
					case WCSourceTypeEnum::periodical:
					case WCSourceTypeEnum::journal:
					case WCSourceTypeEnum::magazine:
					case WCSourceTypeEnum::newspaper:
						$type = WCSourceTypeEnum::$article;
						$this->properties[ WCScopeEnum::series ][ WCPropertyEnum::type ] = $container;
						unset( $container );
					default:
						$type = WCSourceTypeEnum::$general;
				}
				$this->properties[ WCScopeEnum::work ][ WCPropertyEnum::type ] =
					new WCTypeData( $type );
				return;
			}
		}
	}

	/**
	 * Infer certain intended property values, if the user-set values do not
	 * make sense.
	 */
	protected function setInferredProperties() {
		# Unlike works, containers and series should not have "authors".
		if ( isset( $this->names[ WCScopeEnum::container ][ WCNameTypeEnum::author ] ) ) {
			# If there is a work author, then the user probably meant that.
			if ( isset( $this->names[ WCScopeEnum::work ][ WCNameTypeEnum::author ] ) ) {
				$this->names[ WCScopeEnum::work ][ WCNameTypeEnum::author ] = $this->names[ WCScopeEnum::series ][ WCNameTypeEnum::author ];
				unset( $this->names[ WCScopeEnum::container ][ WCNameTypeEnum::author ] );
			} else {
				# If there is a work author also, the user probably meant editor.
				if ( isset( $this->names[ WCScopeEnum::container ][ WCNameTypeEnum::editor ] ) ) {
					$this->names[ WCScopeEnum::container ][ WCNameTypeEnum::editor ] = $this->names[ WCScopeEnum::series ][ WCNameTypeEnum::author ];
					unset( $this->names[ WCScopeEnum::container ][ WCNameTypeEnum::author ] );
				}
			}
		}
		if ( isset( $this->names[ WCScopeEnum::series ][ WCNameTypeEnum::author ] ) ) {
			# If there is on work author, then the user probably meant that.
			if ( !isset( $this->names[ WCScopeEnum::work ][ WCNameTypeEnum::author ] ) ) {
				$this->names[ WCScopeEnum::work ][ WCNameTypeEnum::author ] = $this->names[ WCScopeEnum::series ][ WCNameTypeEnum::author ];
				unset( $this->names[ WCScopeEnum::series ][ WCNameTypeEnum::author ] );
			} else {
				# If there is a work author also, the user probably meant editor.
				if ( !isset( $this->names[ WCScopeEnum::series ][ WCNameTypeEnum::editor ] ) ) {
					$this->names[ WCScopeEnum::series ][ WCNameTypeEnum::editor ] = $this->names[ WCScopeEnum::series ][ WCNameTypeEnum::author ];
					unset( $this->names[ WCScopeEnum::series ][ WCNameTypeEnum::author ] );
				}
			}
		}
	}


}