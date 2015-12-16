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

	abstract public function fetchArticlesData();

	/**
	 * @return string A name of the page's template
	 */
	public function getTemplate() {
		return $this->template;
	}

	public function getAltAction( Title $title ) {
		return [];
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
