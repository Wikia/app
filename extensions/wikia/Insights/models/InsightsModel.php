<?php

/**
 * Top abstract class defining necessary set of methods for Insights models
 */
abstract class InsightsModel {
	const INSIGHTS_FLOW_URL_PARAM = 'insights';

	public $subpage;

	abstract public function getContent( $params );
	abstract public function initModel( $params );
	abstract public function getInsightType();
	abstract public function getInsightCacheParams();
	abstract public function getViewData();
	abstract public function getTemplate();

	abstract function prepareData( $res );

	public function getInsightParam() {
		$type = $this->getInsightType();

		return [
			self::INSIGHTS_FLOW_URL_PARAM => $type
		];
	}
} 
