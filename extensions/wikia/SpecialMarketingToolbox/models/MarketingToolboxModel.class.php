<?php

class MarketingToolboxModel {
	protected $statuses = array();

	public function __construct() {
		$this->statuses = array(
			'DAY_EDITED_NOT_PUBLISHED' => 1,
			'DAY_PUBLISHED' => 2
		);
	}

	public function getData($timestamp) {
		return $this->getMockData($timestamp);
	}

	protected function getMockData($timestamp) {
		return array(
			date('Y-m-d', $timestamp - 13 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $timestamp - 11 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $timestamp - 7 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED'],
			date('Y-m-d', $timestamp - 4 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $timestamp + 4 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $timestamp + 7 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED'],
			date('Y-m-d', $timestamp + 11 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED'],
			date('Y-m-d', $timestamp + 13 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED'],
			date('Y-m-d', $timestamp + 19 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $timestamp + 23 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED']
		);
	}

	public function getAvailableStatuses() {
		return $this->statuses;
	}
}

