<?php
/**
 * Abstract class that defines necessary set of methods for Insights page models
 */
use Wikia\Logger\Loggable;

abstract class InsightsModel {
	use Loggable;

	const INSIGHTS_FLOW_URL_PARAM = 'insights';

	private $template = 'subpageList';
	protected $config;
	protected $subtype;

	/**
	 * Should return not cached list with basic page data in format:
	 *
	 * [
	 * 		[
	 * 			'pageId' => article id,
	 * 			'title' => Title object
	 * 			== optional ==
	 * 			'value' => number of pages link to this article (if 'whatlinkshere' in model config is set to true)
	 * 		],
	 * 		[
	 * 			...
	 * 		]
	 * ]
	 *
	 * @return array
	 */
	abstract public function fetchArticlesData();

	/**
	 * @return string A name of the page's template
	 */
	public function getTemplate() {
		return $this->template;
	}

	public function purgeCacheAfterUpdateTask() {
		return true;
	}

	public function getInsightParam() {
		$type = $this->getConfig()->getInsightType();

		return [
			self::INSIGHTS_FLOW_URL_PARAM => $type
		];
	}

	/**
	 * Get a type of a subpage and an edit parameter
	 * @return array
	 */
	public function getUrlParams() {
		$params = array_merge(
			InsightsItemData::getEditUrlParams(),
			$this->getInsightParam()
		);

		return $params;
	}

	/**
	 * Insights loop notification shown in view mode
	 * @return string
	 */
	public function getInProgressNotificationParams() {
		return '';
	}

	/**
	 * @return InsightsConfig
	 */
	public function getConfig() {
		return $this->config;
	}
}
