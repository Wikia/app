<?php

/**
 * Top abstract class defining necessary set of methods for Insights models
 */
abstract class InsightsModel {
	const INSIGHTS_FLOW_URL_PARAM = 'insights';

	abstract public function getContent( $params, $offset, $limit );
	abstract public function getViewData();
	abstract public function getTemplate();

	abstract function prepareData( $res );
} 
