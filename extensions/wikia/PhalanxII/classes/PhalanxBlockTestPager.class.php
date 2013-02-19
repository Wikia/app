<?php

class PhalanxBlockTestPager extends PhalanxPager {

	private $blockType;
	private $rows = array();

	public function __construct( $blockType ) {
		parent::__construct();
		$this->blockType = $blockType;
	}

	public function setRows(Array $rows) {
		$this->rows = $rows;
	}

	public function getHeader() {
		return Html::element('h2', array(), sprintf('%s (%d)', $this->blockType, count($this->rows)));
	}

	public function getBody() {
		$ret = '';

		foreach($this->rows as $row) {
			$ret .= $this->formatRow($row);
		}

		return $ret;
	}

	public function formatRow($row) {
		$newRow = array();

		foreach($row as $name => $value) {
			$newRow['p_' . $name] = $value;
		}

		return parent::formatRow((object) $newRow);
	}
}
