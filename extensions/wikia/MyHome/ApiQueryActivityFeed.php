<?php

/**
 * Activity feed repackaged as MW api (FIXME It should be the other way around...)
 *
 * @author Przemek Piotrowski <nef@wikia-inc.com>
 */
class ApiQueryActivityFeed extends ApiQueryBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, "af");
	}

	public function execute() {
		$params = $this->extractRequestParams();

$parameters = ActivityFeedHelper::parseParameters($attributes);

$removeDuplicatesType = in_array('shortlist', $parameters['flags']) ? 1 : 0; //remove duplicates using only title for shortlist

$feedProxy = new ActivityFeedAPIProxy($parameters['includeNamespaces']);
$feedRenderer = new ActivityFeedRenderer();

$feedProvider = new DataFeedProvider($feedProxy, $removeDuplicatesType, $parameters);
$feedData = $feedProvider->get($parameters['maxElements']);

#echo "<pre>";
#print_r($feedData);
#die;

		$data = array();
		foreach ($feedData["results"] as $id => $row) {
			$data[] = $this->rewriteRow($row);
		}
#print_r($data);
#die;

		$this->getResult()->setIndexedTagName($data, "af");
		$this->getResult()->addValue("query", $this->getModuleName(), $data);
	}

	private function rewriteRow($row) {
		foreach (array("url", "intro", "diff", "viewMode", "autosummaryType") as $key) {
			if (isset($row[$key])) unset($row[$key]);
		}

		if (isset($row["user"])) {
			if (preg_match("/<a href=\"\/wiki\/.*\" rel=\"nofollow\">(.*)<\/a>/", $row["user"], $matches)) {
				$row["user"] = $matches[1];
			}
		}

		if (isset($row["new_categories"])) {
			if (is_array($row["new_categories"])) {
				$row["new_categories"] = join(", ", $row["new_categories"]);
			}

			if (isset($row["comment"])) {
				$row["comment"] = $row["comment"] . ": " . $row["new_categories"];
			} else {
				$row["comment"] = "Adding categories: " . $row["new_categories"];
			}

			unset($row["new_categories"]);
		}

		return $row;
	}

	public function getAllowedParams() {
		return array(
			"limit" => array(
				ApiBase :: PARAM_DFLT =>  10,
				ApiBase :: PARAM_TYPE => "limit",
				ApiBase :: PARAM_MIN  =>  1,
				ApiBase :: PARAM_MAX  =>  ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 =>  ApiBase :: LIMIT_BIG2
			),
			"foo" => null,
		);
	}

	public function getParamDescription() {
		return array(
			"limit" => "...",
			"foo"   => "bar",
		);
	}

	public function getDescription() {
		return "Activity feed repackaged as MW api";
	}

	protected function getExamples() {
		return array(
				"api.php?action=query&list=activityfeed&affoo=Bar",
			);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
