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
if (!defined('MEDIAWIKI')) die();

/**
 * @addtogroup API
 */
class SFAutocompleteAPI extends ApiBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName);
	}

	public function execute() {
		global $wgContLang;

		$params = $this->extractRequestParams();
		$substr = $params['substr'];
		$namespace = str_replace(' ', '_', $params['namespace']);
		$property = str_replace(' ', '_', $params['property']);
		$relation = str_replace(' ', '_', $params['relation']);
		$attribute = str_replace(' ', '_', $params['attribute']);
		$category = str_replace(' ', '_', $params['category']);
		$limit = $params['limit'];

		if (strlen($substr) == 0)
		{
			$this->dieUsage("The substring must be specified", 'param_substr');
		}
		if ($property != '') {
			$data = sffGetAllPagesForProperty_1_2($property, $substr);
		} elseif ($relation != '') {
			$data = sffGetAllPagesForProperty_orig(true, $relation, $substr);
		} elseif ($attribute != '') {
			$data = sffGetAllPagesForProperty_orig(false, $attribute, $substr);
		} elseif ($category != '') {
			$data = sffGetAllPagesForCategory($category, 3, $substr);
		} elseif ($namespace != '') {
			// special handling for main (blank) namespace
			if ($namespace == 'main')
				$namespace = '';
			$data = sffGetAllPagesForNamespace($namespace, $substr);
		} else {
			$date = array();
		}
		if (count($data)<=0) {
			return;
		}

		// Set top-level elements
		$result = $this->getResult();
		$result->setIndexedTagName($data, 'p');
		$result->addValue(null, $this->getModuleName(), $data);
	}

	protected function getAllowedParams() {
		return array (
			'namespace' => null,
			'limit' => array (
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
			'substr' => null,
			'property' => null,
			'relation' => null,
			'attribute' => null,
			'category' => null,
		);
	}

	protected function getParamDescription() {
		return array (
			'substr' => 'Search substring',
			'property' => 'Property for which to search values',
			'relation' => 'Relation for which to search values',
			'attribute' => 'Attribute for which to search values',
			'category' => 'Category for which to search values',
			'namespace' => 'Namespace for which to search values',
			'limit' => 'Limit how many entries to return',
		);
	}

	protected function getDescription() {
		return 'Autocompletion call used by the Semantic Forms extension (http://www.mediawiki.org/Extension:Semantic_Forms)';
	}

	protected function getExamples() {
		return array (
			'api.php?action=sfautocomplete&substr=te',
			'api.php?action=sfautocomplete&substr=te&property=Has_author',
			'api.php?action=sfautocomplete&substr=te&attribute=Has_color',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}

