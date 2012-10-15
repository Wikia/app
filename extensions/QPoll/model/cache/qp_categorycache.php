<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Muitl-row cache for question categories
 */
class qp_CategoryCache extends qp_QuestionCache {

	# memory cache key prefix
	protected $keyPrefix = 'cc';
	# DB table name
	protected $tableName = 'qp_question_categories';
	# DB table index for replace
	protected $replaceIndex = 'category';
	# DB table fields to select / replace
	protected $fields = array( 'question_id', 'cat_id', 'cat_name' );

	protected function convertFromString( $row ) {
		$row->question_id = intval( $row->question_id );
		$row->cat_id = intval( $row->cat_id );
	}

	protected function buildReplaceRows() {
		global $wgContLang;
		$pid = self::$store->pid;
		foreach ( self::$store->Questions as $qkey => $qdata ) {
			$qdata->packSpans();
			foreach ( $qdata->Categories as $catkey => &$Cat ) {
				$cat_name = $Cat['name'];
				$this->replace[] = array( 'pid' => $pid, 'question_id' => $qkey, 'cat_id' => $catkey, 'cat_name' => $cat_name );
				# instead of calling $this->updateFromPollStore(),
				# we build $this->memc_rows[] right here,
				# to avoid double loop against self::$store->Questions
				$this->memc_rows[] = array(
					$qkey,
					$catkey,
					$cat_name
				);
			}
			$qdata->restoreSpans();
		}
	}

} /* end of qp_CategoryCache class */
