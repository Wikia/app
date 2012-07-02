<?php

/**
 * A query module to list all pages in given category AND with given un/answered status.
 *
 * @author Przemek Piotrowski <nef@wikia-inc.com>
 */
class ApiQueryCategoriesOnAnswers extends ApiQueryBase {
	var $unanswered_category, $answered_category;

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'coa');

		$this->unanswered_category = wfMsgForContent('unanswered_category');
		$this->answered_category   = wfMsgForContent('answered_category');
	}

	// rt#24487: We need this code altered for a specific case. When the category = "foo",
	// we would like this list to show only questions from a predefined list of categories.
	function rt_24487_special_case(&$categoryTitle) {
		global $wgRT24487SpecialCase;

		if (!empty($wgRT24487SpecialCase) && is_array($wgRT24487SpecialCase)) {
			$category = $categoryTitle->getDBkey();
			foreach ($wgRT24487SpecialCase as $from => $to) {
				$from = Title::newFromText($from, NS_CATEGORY)->getDBkey();
				if ($category == $from) {
					if (is_array($to)) $to = $to[array_rand($to)];
					$categoryTitle = Title::newFromText($to, NS_CATEGORY);

		if ( is_null( $categoryTitle ) || $categoryTitle->getNamespace() != NS_CATEGORY )
			$this->dieUsage("The category name you entered is not valid", 'invalidcategory');

				}
			}
		}
	}

	private function prepareCategories($params_title) {
		$categories = array();

		foreach (explode("|", $params_title) as $title) {
			$categoryTitle = Title::newFromText($title, NS_CATEGORY);

			if ( is_null( $categoryTitle ) || $categoryTitle->getNamespace() != NS_CATEGORY )
				$this->dieUsage("The category name you entered is not valid", 'invalidcategory');

			// rt#24487: We need this code altered for a specific case. When the category = "foo",
			// we would like this list to show only questions from a predefined list of categories.
			$this->rt_24487_special_case($categoryTitle);

			$categories[] = $categoryTitle->getDBkey();
		}
		
		return $categories;
	}

	public function execute() {
		$params = $this->extractRequestParams();

		if ( !isset($params['title']) || is_null($params['title']) )
			$this->dieUsage("The coatitle parameter is required", 'notitle');

		$categoryDBkeys = $this->prepareCategories($params['title']);

		$answeredTitle = Title::newFromText( ( 'no' == $params['answered'] ? $this->unanswered_category : $this->answered_category ), NS_CATEGORY );

		if ( is_null( $answeredTitle ) || $answeredTitle->getNamespace() != NS_CATEGORY )
			$this->dieUsage("The name of un/answered category is not valid", 'invalidcategory');

		$this->addFields(array('c1.cl_from', 'c1.cl_timestamp'));
		$this->addTables(array('categorylinks AS c1', 'categorylinks AS c2'));
		$this->addWhere('c1.cl_from = c2.cl_from');
		$this->addWhere('c1.cl_to IN (' . $this->getDB()->makeList($categoryDBkeys) . ')');
		$this->addWhereFld('c2.cl_to', $answeredTitle->getDBkey());
		$this->addOption('ORDER BY', 'c1.cl_timestamp DESC');
		$this->addOption('LIMIT', $params['limit']);
		$this->addOption('DISTINCT');

		$db = $this->getDB();

		$res = $this->select(__METHOD__);
		$data = array();
		while ($row = $db->fetchObject($res)) {
			$title = Title::newFromID($row->cl_from);
			if ($title instanceof Title && $title->isContentPage()) {
				$vals['ns'] = intval($title->getNamespace());
				$vals['title'] = $title->getPrefixedText();
				$data[] = $vals;
			}
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

	public function getExamples() {
		return array (
				"Get most recent 10 unanswered questions in [[Category:Muppet Wiki]]:",
				"  api.php?action=query&list=categoriesonanswers&coatitle=Muppet%20Wiki",
			);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
