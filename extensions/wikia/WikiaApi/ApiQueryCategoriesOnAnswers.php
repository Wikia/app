<?php

/**
 * A query module to list all pages in given category AND with given un/answered status.
 *
 * @author Przemek Piotrowski <nef@wikia-inc.com>
 */
class ApiQueryCategoriesOnAnswers extends ApiQueryBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'coa');
	}

	public function execute() {
		$params = $this->extractRequestParams();

		if ( !isset($params['title']) || is_null($params['title']) )
			$this->dieUsage("The coatitle parameter is required", 'notitle');
		$categoryTitle = Title::newFromText($params['title'], NS_CATEGORY);

		if ( is_null( $categoryTitle ) || $categoryTitle->getNamespace() != NS_CATEGORY )
			$this->dieUsage("The category name you entered is not valid", 'invalidcategory');

		$answeredTitle = Title::newFromText( ( 'no' == $params['answered'] ? 'Un-answered questions' : 'Answered questions' ), NS_CATEGORY );

		if ( is_null( $answeredTitle ) || $answeredTitle->getNamespace() != NS_CATEGORY )
			$this->dieUsage("The name of un/answered category is not valid", 'invalidcategory');

		$this->addFields(array('c1.cl_sortkey', 'c1.cl_timestamp'));
		$this->addTables(array('categorylinks AS c1', 'categorylinks AS c2'));
		$this->addWhere('c1.cl_from = c2.cl_from');
		$this->addWhereFld('c1.cl_to', $categoryTitle->getDBkey());
		$this->addWhereFld('c2.cl_to', $answeredTitle->getDBkey());
		$this->addOption('ORDER BY', 'c1.cl_timestamp DESC');
		$this->addOption('LIMIT', $params['limit']);

		$db = $this->getDB();

		$res = $this->select(__METHOD__);
		$data = array();
		while ($row = $db->fetchObject($res)) {
			$title = Title::newFromText($row->cl_sortkey);
			$vals['ns'] = intval($title->getNamespace());
			$vals['title'] = $title->getPrefixedText();
			$data[] = $vals;
		}
		$db->freeResult($res);

		$this->getResult()->setIndexedTagName($data, 'coa');
		$this->getResult()->addValue('query', $this->getModuleName(), $data);
	}

	public function getAllowedParams() {
		return array(
			'title' => null,
			'answered' => array(
				ApiBase :: PARAM_DFLT => 'no',
				ApiBase :: PARAM_TYPE => array(
					'no',
					'yes'
				)
			),
			'limit' => array(
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
		);
	}

	public function getParamDescription () {
		return array(
			'title' => 'Which category to enumerate (required).',
			'answered' => 'What questions are needed - answered or un-answered?',
			'limit' => 'The maximum number of pages to return.',
		);
	}

	public function getDescription() {
		return 'List all pages in a given category AND with given un/answered status';
	}

	protected function getExamples() {
		return array (
				"Get most recent 10 unanswered questions in [[Category:Muppet Wiki]]:",
				"  api.php?action=query&list=categoriesonanswers&coatitle=Muppet%20Wiki",
			);
	}

	public function getVersion() {
		return __CLASS__ . ': v 1.0';
	}
}
