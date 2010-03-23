<?php
/**
 * Adds and handles the 'sfautocomplete' action to the MediaWiki API.
 *
 * @author Sergey Chernyshev
 * @author Yaron Koren
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * @addtogroup API
 */
class SFAutocompleteAPI extends ApiBase {

	public function __construct( $query, $moduleName ) {
		parent :: __construct( $query, $moduleName );
	}

	public function execute() {
		global $wgContLang;

		$params = $this->extractRequestParams();
		$substr = $params['substr'];
		$namespace = $params['namespace'];
		$attribute = $params['attribute'];
		$relation = $params['relation'];
		$category = $params['category'];
		$concept = $params['concept'];
		$external_url = $params['external_url'];
		$limit = $params['limit'];

		if ( strlen( $substr ) == 0 )
		{
			$this->dieUsage( "The substring must be specified", 'param_substr' );
		}
		if ( $attribute != '' ) {
			$data = self::getAllValuesForProperty( false, $attribute, $substr );
		} elseif ( $relation != '' ) {
			$data = self::getAllValuesForProperty( true, $relation, $substr );
		} elseif ( $category != '' ) {
			$data = SFUtils::getAllPagesForCategory( $category, 3, $substr );
		} elseif ( $concept != '' ) {
			$data = SFUtils::getAllPagesForConcept( $concept, $substr );
		} elseif ( $namespace != '' ) {
			// special handling for main (blank) namespace
			if ( $namespace == 'main' )
				$namespace = '';
			$data = SFUtils::getAllPagesForNamespace( $namespace, $substr );
		} elseif ( $external_url != '' ) {
			$data = SFUtils::getValuesFromExternalURL( $external_url, $substr );
		} else {
			$data = array();
		}
		if ( count( $data ) <= 0 ) {
			return;
		}

		// Set top-level elements
		$result = $this->getResult();
		$result->setIndexedTagName( $data, 'p' );
		$result->addValue( null, $this->getModuleName(), $data );
	}

	protected function getAllowedParams() {
		return array (
			'limit' => array (
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
			'substr' => null,
			'attribute' => null,
			'relation' => null,
			'category' => null,
			'concept' => null,
			'namespace' => null,
			'external_url' => null,
		);
	}

	protected function getParamDescription() {
		return array (
			'substr' => 'Search substring',
			'attribute' => 'Attribute (non-page property) for which to search values',
			'relation' => 'Relation (page property) for which to search values',
			'category' => 'Category for which to search values',
			'concept' => 'Concept for which to search values',
			'namespace' => 'Namespace for which to search values',
			'external_url' => 'Alias for external URL from which to get values',
			'limit' => 'Limit how many entries to return',
		);
	}

	protected function getDescription() {
		return 'Autocompletion call used by the Semantic Forms extension (http://www.mediawiki.org/Extension:Semantic_Forms)';
	}

	protected function getExamples() {
		return array (
			'api.php?action=sfautocomplete&substr=te',
			'api.php?action=sfautocomplete&substr=te&relation=Has_author',
			'api.php?action=sfautocomplete&substr=te&category=Authors',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

	public static function getAllValuesForProperty( $is_relation, $property_name, $substring = null ) {
		global $sfgMaxAutocompleteValues;

		$values = array();
		$db = wfGetDB( DB_SLAVE );
		$sql_options = array();
		$sql_options['LIMIT'] = $sfgMaxAutocompleteValues;
		if ( $is_relation ) {
			$value_field = 'o_ids.smw_title';
			$from_clause = $db->tableName( 'smw_rels2' ) . " r JOIN " . $db->tableName( 'smw_ids' ) . " p_ids ON r.p_id = p_ids.smw_id JOIN " . $db->tableName( 'smw_ids' ) . " o_ids ON r.o_id = o_ids.smw_id";
		} else {
			$value_field = 'a.value_xsd';
			$from_clause = $db->tableName( 'smw_atts2' ) . " a JOIN " . $db->tableName( 'smw_ids' ) . " p_ids ON a.p_id = p_ids.smw_id";
		}
		$property_name = str_replace( ' ', '_', $property_name );
		$conditions = "p_ids.smw_title = '$property_name'";
		if ( $substring != null ) {
			$substring = str_replace( "'", "\'", strtolower( $substring ) );
			// utf8 conversion is needed in case MediaWiki is using
			// binary data storage
			$conditions .= " AND (REPLACE(LOWER(CONVERT($value_field USING utf8)),'_',' ') LIKE '" . $substring . "%' OR REPLACE(LOWER(CONVERT($value_field USING utf8)),'_',' ') LIKE '% " . $substring . "%')";
		}
		$sql_options['ORDER BY'] = $value_field;
		$res = $db->select( $from_clause, "DISTINCT $value_field",
			$conditions, __METHOD__, $sql_options );
		while ( $row = $db->fetchRow( $res ) ) {
			if ( $substring != null ) {
				$values[] = array( 'title' => str_replace( '_', ' ', $row[0] ) );
			} else {
				$cur_value = str_replace( "'", "\'", $row[0] );
				$values[] = str_replace( '_', ' ', $cur_value );
			}
		}
		$db->freeResult( $res );
		return $values;
	}
}

