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
		$external_url = $params['external_url'];
		$baseprop = $params['baseprop'];
		$basevalue = $params['basevalue'];
		//$limit = $params['limit'];

		if ( is_null( $baseprop ) && strlen( $substr ) == 0 ) {
			$this->dieUsage( 'The substring must be specified', 'param_substr' );
		}

		if ( !is_null( $baseprop ) ) {
			if ( !is_null( $property ) ) {
				$data = self::getAllValuesForProperty( $property, null, $baseprop, $basevalue );
			}
		} elseif ( !is_null( $property ) ) {
			$data = self::getAllValuesForProperty( $property, $substr );
		} elseif ( !is_null( $category ) ) {
			$data = SFUtils::getAllPagesForCategory( $category, 3, $substr );
		} elseif ( !is_null( $concept ) ) {
			$data = SFUtils::getAllPagesForConcept( $concept, $substr );
		} elseif ( !is_null( $namespace ) ) {
			$data = SFUtils::getAllPagesForNamespace( $namespace, $substr );
		} elseif ( !is_null( $external_url ) ) {
			$data = SFUtils::getValuesFromExternalURL( $external_url, $substr );
		} else {
			$data = array();
		}

		// to prevent JS parsing problems, display should be the same
		// even if there are no results
		/*
		if ( count( $data ) <= 0 ) {
			return;
		}
		 */

		// Format data as the API requires it.
		$formattedData = array();
		foreach ( $data as $value ) {
			$formattedData[] = array( 'title' => $value );
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
			'namespace' => null,
			'external_url' => null,
			'baseprop' => null,
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

	public function getExamples() {
		return array (
			'api.php?action=sfautocomplete&substr=te',
			'api.php?action=sfautocomplete&substr=te&property=Has_author',
			'api.php?action=sfautocomplete&substr=te&category=Authors',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: SF_AutocompleteAPI.php 112139 2012-02-22 19:52:49Z yaron $';
	}

	private static function getAllValuesForProperty( $property_name, $substring, $base_property_name = null, $base_value = null ) {
		global $sfgMaxAutocompleteValues;

		$values = array();
		$db = wfGetDB( DB_SLAVE, 'smw' );
		$sql_options = array();
		$sql_options['LIMIT'] = $sfgMaxAutocompleteValues;

		$property = SMWPropertyValue::makeUserProperty( $property_name );
		$is_relation = ( $property->getPropertyTypeID() == '_wpg' );
		$property_name = str_replace( ' ', '_', $property_name );
		$conditions = array( 'p_ids.smw_title' => $property_name );

		if ( $is_relation ) {
			$value_field = 'o_ids.smw_title';
			$from_clause = $db->tableName( 'smw_rels2' ) . " r JOIN " . $db->tableName( 'smw_ids' ) . " p_ids ON r.p_id = p_ids.smw_id JOIN " . $db->tableName( 'smw_ids' ) . " o_ids ON r.o_id = o_ids.smw_id";
		} else {
			$value_field = 'a.value_xsd';
			$from_clause = $db->tableName( 'smw_atts2' ) . " a JOIN " . $db->tableName( 'smw_ids' ) . " p_ids ON a.p_id = p_ids.smw_id";
		}

		if ( !is_null( $base_property_name ) ) {
			$base_property = SMWPropertyValue::makeUserProperty( $base_property_name );
			$base_is_relation = ( $base_property->getPropertyTypeID() == '_wpg' );

			$base_property_name = str_replace( ' ', '_', $base_property_name );
			$conditions['base_p_ids.smw_title'] = $base_property_name;
			$main_prop_alias = ( $is_relation ) ? 'r' : 'a';
			if ( $base_is_relation ) {
				$from_clause .= " JOIN " . $db->tableName( 'smw_rels2' ) . " r_base ON $main_prop_alias.s_id = r_base.s_id";
				$from_clause .= " JOIN " . $db->tableName( 'smw_ids' ) . " base_p_ids ON r_base.p_id = base_p_ids.smw_id JOIN " . $db->tableName( 'smw_ids' ) . " base_o_ids ON r_base.o_id = base_o_ids.smw_id";
				$base_value = str_replace( ' ', '_', $base_value );
				$conditions['base_o_ids.smw_title'] = $base_value;
			} else {
				$from_clause .= " JOIN " . $db->tableName( 'smw_atts2' ) . " a_base ON $main_prop_alias.s_id = a_base.s_id";
				$from_clause .= " JOIN " . $db->tableName( 'smw_ids' ) . " base_p_ids ON a_base.p_id = base_p_ids.smw_id";
				$conditions['a_base.value_xsd'] = $base_value;
			}
		}

		if ( !is_null( $substring ) ) {
			$conditions[] = SFUtils::getSQLConditionForAutocompleteInColumn( $value_field, $substring );
		}

		$sql_options['ORDER BY'] = $value_field;
		$res = $db->select( $from_clause, "DISTINCT $value_field",
			$conditions, __METHOD__, $sql_options );

		while ( $row = $db->fetchRow( $res ) ) {
			$values[] = str_replace( '_', ' ', $row[0] );
		}
		$db->freeResult( $res );

		return $values;
	}

}
