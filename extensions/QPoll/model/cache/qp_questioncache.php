<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Muitl-row cache for question descriptions.
 * Also it's a base class for proposal / category multi-row caches.
 */
class qp_QuestionCache extends qp_PollCache {

	# memory cache key prefix
	protected $keyPrefix = 'qc';
	# DB table name
	protected $tableName = 'qp_question_desc';
	# DB index for replace
	protected $replaceIndex = 'question';
	# DB table fields to select / replace
	protected $fields = array( 'question_id', 'type', 'common_question', 'name' );

	protected function numRowsToAssocRows() {
		# build DBMS-like object rows from array rows
		foreach ( $this->rows as &$row ) {
			$row = (object) array_combine( $this->fields, $row );
		}
	}

	protected function getMemcKey() {
		return wfMemcKey( 'qpoll', $this->keyPrefix, self::$store->pid );
	}

	protected function loadFromDB() {
		$this->dbres = self::$db->select( $this->tableName,
			$this->fields,
			array( 'pid' => self::$store->pid ),
			__METHOD__
		);
	}

	protected function convertFromString( $row ) {
		$row->question_id = intval( $row->question_id );
	}

	protected function updateFromDBres() {
		# Populate $this->rows and $this->memc_rows with DB data
		# from $this->dbres.
		# we cannot use Database::fetchRow() because it will set both
		# numeric and associative keys (x2 fields)
		while ( ( $row = self::$db->fetchObject( $this->dbres ) ) !== false ) {
			$this->convertFromString( $row );
			$this->memc_rows[] = array_values( (array)$row );
			$this->rows[] = (object) $row;
		}
	}

	/**
	 * Unimplemented, because:
	 * 1. self::store( null, ... ) is never called on this or ancestors
	 * 2. $this->insertRows() is unimplemented
	 * 3. $this->buildReplaceRows() populates $this->memc_rows directly
	 *    (speed optimization).
	 * If anything from the list above will change,
	 * this method has to be implemented here and in ancestors as well.
	 */
	protected function updateFromPollStore() {
		/* noop */
	}

	/**
	 * Insert operation currently is unneeded for question cache and it's ancestors.
	 */
	protected function insertRows() {
		throw new Exception( __METHOD__ . ' is unimplemented (currently is unneeded) ' );
	}

	protected function buildReplaceRows() {
		global $wgContLang;
		$pid = self::$store->pid;
		foreach ( self::$store->Questions as $qkey => $qdata ) {
			$common_question = $wgContLang->truncate( $qdata->CommonQuestion, qp_Setup::$field_max_len['common_question'] , '' );
			$this->replace[] = array(
				'pid' => $pid,
				'question_id' => $qkey,
				'type' => $qdata->type,
				'common_question' => $common_question,
				'name' => $qdata->name
			);
			$qdata->question_id = $qkey;
			# instead of calling $this->updateFromPollStore(),
			# we build $this->memc_rows[] right here,
			# to avoid double loop against self::$store->Questions
			$this->memc_rows[] = array(
				$qkey,
				$qdata->type,
				$common_question,
				$qdata->name
			);
		}
	}

} /* end of qp_QuestionCache class */
