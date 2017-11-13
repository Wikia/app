<?php

class PhalanxBlockTestPager extends PhalanxPager {

	private $blockType;
	private $rows = array();

	public function __construct( $blockType ) {
		parent::__construct();
		$this->blockType = $blockType;
	}

	public function setRows( Array $rows ) {
		$this->rows = $rows;
	}

	public function getHeader() {
		return Html::element( 'h2', array(), sprintf( '%s (%d)', $this->blockType, count( $this->rows ) ) );
	}

	public function getBody() {
		$ret = '<ul>';

		foreach ( $this->rows as $row ) {
			$ret .= $this->formatRow( $row );
		}

		$ret .= '</ul>';

		return $ret;
	}

	/**
	 * Formats a single search result (block data) for output
	 * Input data is from Phalanx service, and needs to be converted to use the same keys as Phalanx table
	 * @param PhalanxBlockInfo $row Block data as returned by Phalanx service
	 * @return string Formatted HTML output
	 */
	public function formatRow( $row ) {
		$newRow = [
			'p_regex' => $row->isRegex(),
			'p_expires' => $row->getExpires(),
			'p_timestamp' => $row->getTimestamp(),
			'p_text' => $row->getText(),
			'p_reason' => $row->getReason(),
			'p_exact' => $row->isExact(),
			'p_case' => $row->isCaseSensitive(),
			'p_id' => $row->getId(),
			'p_author_id' => $row->getAuthorId(),
			'p_type' => $row->getType()
		];

		return parent::formatRow( (object) $newRow );
	}
}
