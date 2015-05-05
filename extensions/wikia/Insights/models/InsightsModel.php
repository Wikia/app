<?php

abstract class InsightsModel {
	const
		INSIGHTS_FLOW_URL_PARAM = 'insights',
		INSIGHTS_LIST_MAX_LIMIT = 10;

	public $subpage;

	protected
		$offset = 1,
		$limit = 10,
		$total = 0,
		$page = 1;

	abstract public function getContent( $params );
	abstract public function getViewData();
	abstract public function getTemplate();

	abstract function prepareData( $res );

	public function getTotalResultsNum() {
		return $this->total;
	}

	public function getLimitResultsNum() {
		return $this->limit;
	}

	public function getOffset() {
		return $this->offset;
	}

	public function getPage() {
		return $this->page;
	}

	public function getInsightParam() {
		$type = $this->getInsightType();

		return [
			self::INSIGHTS_FLOW_URL_PARAM => $type
		];
	}
} 
