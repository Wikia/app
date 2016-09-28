<?php
/**
 * @file
 * @ingroup SF
 */

/**
 * Adds and handles the 'sfautocomplete' action to the MediaWiki API.
 *
 * @ingroup SF
 *
 * @author Sergey Chernyshev
 * @author Yaron Koren
 */
class SFAutocompleteAPI extends ApiBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$substr = $params['substr'];
		$namespace = $params['namespace'];
		$property = $params['property'];
		$category = $params['category'];
		$concept = $params['concept'];
		$cargo_table = $params['cargo_table'];
		$cargo_field = $params['cargo_field'];
		$field_is_array = $params['field_is_array'];
		$external_url = $params['external_url'];
		$baseprop = $params['baseprop'];
		$base_cargo_table = $params['base_cargo_table'];
		$base_cargo_field = $params['base_cargo_field'];
		$basevalue = $params['basevalue'];
		//$limit = $params['limit'];

		if ( is_null( $baseprop ) && is_null( $base_cargo_table ) && strlen( $substr ) == 0 ) {
			$this->dieUsage( 'The substring must be specified', 'param_substr' );
		}

		if ( !is_null( $baseprop ) ) {
			if ( !is_null( $property ) ) {
				$data = self::getAllValuesForProperty( $property, null, $baseprop, $basevalue );
			}
		} elseif ( !is_null( $property ) ) {
			$data = self::getAllValuesForProperty( $property, $substr );
		} elseif ( !is_null( $category ) ) {
			$data = SFValuesUtils::getAllPagesForCategory( $category, 3, $substr );
		} elseif ( !is_null( $concept ) ) {
			$data = SFValuesUtils::getAllPagesForConcept( $concept, $substr );
		} elseif ( !is_null( $cargo_table ) && !is_null( $cargo_field ) ) {
			$data = self::getAllValuesForCargoField( $cargo_table, $cargo_field, $field_is_array, $substr, $base_cargo_table, $base_cargo_field, $basevalue );
		} elseif ( !is_null( $namespace ) ) {
			$data = SFValuesUtils::getAllPagesForNamespace( $namespace, $substr );
		} elseif ( !is_null( $external_url ) ) {
			$data = SFValuesUtils::getValuesFromExternalURL( $external_url, $substr );
		} else {
			$data = array();
		}

		// If we got back an error message, exit with that message.
		if ( !is_array( $data ) ) {
			$this->dieUsage( $data );
		}

		// to prevent JS parsing problems, display should be the same
		// even if there are no results
		/*
		if ( count( $data ) <= 0 ) {
			return;
		}
		 */

		// Format data as the API requires it - this is not needed
		// for "values from url", where the data is already formatted
		// correctly.
		if ( is_null( $external_url ) ) {
			$formattedData = array();
			foreach ( $data as $value ) {
				$formattedData[] = array( 'title' => $value );
			}
		} else {
			$formattedData = $data;
		}

		// Set top-level elements.
		$result = $this->getResult();
		$result->setIndexedTagName( $formattedData, 'p' );
		$result->addValue( null, $this->getModuleName(), $formattedData );
	}

	protected function getAllowedParams() {
		return array (
			'limit' => array (
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'substr' => null,
			'property' => null,
			'category' => null,
			'concept' => null,
			'cargo_table' => null,
			'cargo_field' => null,
			'field_is_array' => null,
			'namespace' => null,
			'external_url' => null,
			'baseprop' => null,
			'base_cargo_table' => null,
			'base_cargo_field' => null,
			'basevalue' => null,
		);
	}

	protected function getParamDescription() {
		return array (
			'substr' => 'Search substring',
			'property' => 'Semantic property for which to search values',
			'category' => 'Category for which to search values',
			'concept' => 'Concept for which to search values',
			'namespace' => 'Namespace for which to search values',
			'external_url' => 'Alias for external URL from which to get values',
			'baseprop' => 'A previous property in the form to check against',
			'basevalue' => 'The value to check for the previous property',
			//'limit' => 'Limit how many entries to return',
		);
	}

	protected function getDescription() {
		return 'Autocompletion call used by the Semantic Forms extension (http://www.mediawiki.org/Extension:Semantic_Forms)';
	}

	protected function getExamples() {
		return array (
			'api.php?action=sfautocomplete&substr=te',
			'api.php?action=sfautocomplete&substr=te&property=Has_author',
			'api.php?action=sfautocomplete&substr=te&category=Authors',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

	private static function getAllValuesForProperty( $property_name, $substring, $basePropertyName = null, $baseValue = null ) {
		global $sfgMaxAutocompleteValues, $sfgCacheAutocompleteValues, $sfgAutocompleteCacheTimeout;
		global $smwgDefaultStore;

		$values = array();
		$db = wfGetDB( DB_SLAVE );
		$sqlOptions = array();
		$sqlOptions['LIMIT'] = $sfgMaxAutocompleteValues;

		$property = SMWPropertyValue::makeUserProperty( $property_name );
		$propertyHasTypePage = ( $property->getPropertyTypeID() == '_wpg' );
		$property_name = str_replace( ' ', '_', $property_name );
		$conditions = array( 'p_ids.smw_title' => $property_name );

		// Use cache if allowed
		if ( $sfgCacheAutocompleteValues ) {
			$cache = SFFormUtils::getFormCache();
			// Remove trailing whitespace to avoid unnecessary database selects
			$cacheKeyString = $property_name . '::' . rtrim( $substring );
			if ( !is_null( $basePropertyName ) ) {
				$cacheKeyString .= ',' . $basePropertyName . ',' . $baseValue;
			}
			$cacheKey = wfMemcKey( 'sf-autocomplete' , md5( $cacheKeyString ) ); 		
			$values = $cache->get( $cacheKey );

			if ( !empty( $values ) ){
				// Return with results immediately
				return $values;
			}
		}

		if ( $propertyHasTypePage ) {
			$valueField = 'o_ids.smw_title';
			if ( $smwgDefaultStore === 'SMWSQLStore3' ) {
				$idsTable = $db->tableName( 'smw_object_ids' );
				$propsTable = $db->tableName( 'smw_di_wikipage' );
			} else {
				$idsTable = $db->tableName( 'smw_ids' );
				$propsTable = $db->tableName( 'smw_rels2' );
			}
			$fromClause = "$propsTable p JOIN $idsTable p_ids ON p.p_id = p_ids.smw_id JOIN $idsTable o_ids ON p.o_id = o_ids.smw_id";
		} else {
			if ( $smwgDefaultStore === 'SMWSQLStore3' ) {
				$valueField = 'p.o_hash';
				$idsTable = $db->tableName( 'smw_object_ids' );
				$propsTable = $db->tableName( 'smw_di_blob' );
			} else {
				$valueField = 'p.value_xsd';
				$idsTable = $db->tableName( 'smw_ids' );
				$propsTable = $db->tableName( 'smw_atts2' );
			}
			$fromClause = "$propsTable p JOIN $idsTable p_ids ON p.p_id = p_ids.smw_id";
		}

		if ( !is_null( $basePropertyName ) ) {
			$baseProperty = SMWPropertyValue::makeUserProperty( $basePropertyName );
			$basePropertyHasTypePage = ( $baseProperty->getPropertyTypeID() == '_wpg' );

			$basePropertyName = str_replace( ' ', '_', $basePropertyName );
			$conditions['base_p_ids.smw_title'] = $basePropertyName;
			if ( $basePropertyHasTypePage ) {
				if ( $smwgDefaultStore === 'SMWSQLStore3' ) {
					$idsTable = $db->tableName( 'smw_object_ids' );
					$propsTable = $db->tableName( 'smw_di_wikipage' );
				} else {
					$idsTable = $db->tableName( 'smw_ids' );
					$propsTable = $db->tableName( 'smw_rels2' );
				}
				$fromClause .= " JOIN $propsTable p_base ON p.s_id = p_base.s_id";
				$fromClause .= " JOIN $idsTable base_p_ids ON p_base.p_id = base_p_ids.smw_id JOIN $idsTable base_o_ids ON p_base.o_id = base_o_ids.smw_id";
				$baseValue = str_replace( ' ', '_', $baseValue );
				$conditions['base_o_ids.smw_title'] = $baseValue;
			} else {
				if ( $smwgDefaultStore === 'SMWSQLStore3' ) {
					$baseValueField = 'p_base.o_hash';
					$idsTable = $db->tableName( 'smw_object_ids' );
					$propsTable = $db->tableName( 'smw_di_blob' );
				} else {
					$baseValueField = 'p_base.value_xsd';
					$idsTable = $db->tableName( 'smw_ids' );
					$propsTable = $db->tableName( 'smw_atts2' );
				}
				$fromClause .= " JOIN $propsTable p_base ON p.s_id = p_base.s_id";
				$fromClause .= " JOIN $idsTable base_p_ids ON p_base.p_id = base_p_ids.smw_id";
				$conditions[$baseValueField] = $baseValue;
			}
		}

		if ( !is_null( $substring ) ) {
			// "Page" type property valeus are stored differently
			// in the DB, i.e. underlines instead of spaces.
			$conditions[] = SFValuesUtils::getSQLConditionForAutocompleteInColumn( $valueField, $substring, $propertyHasTypePage );
		}

		$sqlOptions['ORDER BY'] = $valueField;
		$res = $db->select( $fromClause, "DISTINCT $valueField",
			$conditions, __METHOD__, $sqlOptions );

		while ( $row = $db->fetchRow( $res ) ) {
			$values[] = str_replace( '_', ' ', $row[0] );
		}
		$db->freeResult( $res );

		if ( $sfgCacheAutocompleteValues ) {
			// Save to cache.
			$cache->set( $cacheKey, $values, $sfgAutocompleteCacheTimeout );
		}

		return $values;
	}

	private static function getAllValuesForCargoField( $cargoTable, $cargoField, $fieldIsArray, $substring, $baseCargoTable = null, $baseCargoField = null, $baseValue = null ) {
		global $sfgMaxAutocompleteValues, $sfgCacheAutocompleteValues, $sfgAutocompleteCacheTimeout;
		global $sfgAutocompleteOnAllChars;

		$values = array();
		$tablesStr = $cargoTable;
		$fieldsStr = $cargoField;
		$joinOnStr = '';
		$whereStr = '';

		// Use cache if allowed
		if ( $sfgCacheAutocompleteValues ) {
			$cache = SFFormUtils::getFormCache();
			// Remove trailing whitespace to avoid unnecessary database selects
			$cacheKeyString = $cargoTable . '|' . $cargoField . '|' . rtrim( $substring );
			if ( !is_null( $baseCargoTable ) ) {
				$cacheKeyString .= '|' . $baseCargoTable . '|' . $baseCargoField . '|' . $baseValue;
			}
			$cacheKey = wfMemcKey( 'sf-autocomplete' , md5( $cacheKeyString ) ); 		
			$values = $cache->get( $cacheKey );

			if ( !empty( $values ) ){
				// Return with results immediately
				return $values;
			}
		}

		if ( !is_null( $baseCargoTable ) && !is_null( $baseCargoField ) ) {
			if ( $baseCargoTable != $cargoTable ) {
				$tablesStr .= ", $baseCargoTable";
				$joinOnStr = "$cargoTable._pageName = $baseCargoTable._pageName";
			}
			$whereStr = "$baseCargoTable.$baseCargoField = \"$baseValue\"";
		}

		if ( !is_null( $substring ) ) {
			if ( $whereStr != '' ) {
				$whereStr .= " AND ";
			}
			$operator = ( $fieldIsArray ) ? "HOLDS LIKE" : "LIKE";
			if ( $sfgAutocompleteOnAllChars ) {
				$whereStr .= "($cargoField $operator \"%$substring%\")";
			} else {
				$whereStr .= "($cargoField $operator \"$substring%\" OR $cargoField $operator \"% $substring%\")";
			}
		}

		$sqlQuery = CargoSQLQuery::newFromValues( $tablesStr, $fieldsStr, $whereStr, $joinOnStr, $cargoField, $havingStr = null, $cargoField, $sfgMaxAutocompleteValues );
		$cargoFieldAlias = str_replace( '_', ' ', $cargoField );
		$queryResults = $sqlQuery->run();

		foreach ( $queryResults as $row ) {
			// @TODO - this check should not be neceaary.
			if ( ( $value = $row[$cargoFieldAlias] ) != '' ) {
				$values[] = $value;
			}
		}

		if ( $sfgCacheAutocompleteValues ) {
			// Save to cache.
			$cache->set( $cacheKey, $values, $sfgAutocompleteCacheTimeout );
		}

		return $values;
	}

}
