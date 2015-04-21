<?php

abstract class InsightsModel {
	const INSIGHTS_FLOW_URL_PARAM = 'insights';

	public $subpage;

	abstract public function getContent();
	abstract public function getData();
	abstract public function getTemplate();

	abstract function prepareData( $res );

	public function getInsightParam() {
		$type = $this->getInsightType();

		return [
			self::INSIGHTS_FLOW_URL_PARAM => $type
		];
	}
} 
