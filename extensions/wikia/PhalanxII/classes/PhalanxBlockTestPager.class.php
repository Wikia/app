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
	 * @param stdClass $row Block data as returned by Phalanx service
	 * @return string Formatted HTML output
	 */
	public function formatRow( $row ): string {
		$newRow = [
			'p_regex' => $row->regex,
			'p_expires' => $row->expires,
			'p_timestamp' => $row->timestamp,
			'p_text' => $row->text,
			'p_reason' => $row->reason,
			'p_exact' => $row->exact,
			'p_case' => $row->caseSensitive,
			'p_id' => $row->id,
			'p_language' => $row->language,
			'p_author_id' => $row->authorId,
			'p_type' => $row->type
		];

		return parent::formatRow( (object) $newRow );
	}
}
