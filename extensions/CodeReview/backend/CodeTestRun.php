<?php

class CodeTestRun {
	public function __construct( CodeTestSuite $suite, $row ) {
		if( is_object( $row ) ) {
			$row = wfObjectToArray( $row );
		}
		$this->suite = $suite;
		$this->id = intval( $row['ctrun_id'] );
		$this->revId = intval( $row['ctrun_rev_id'] );
		$this->status = $row['ctrun_status'];
		$this->countTotal = $row['ctrun_count_total'];
		$this->countSuccess = $row['ctrun_count_success'];
		
		$this->mCaseMap = null; // Lazy-initialize...
	}
	
	public function getResults( $success=null ) {
		$dbr = wfGetDB( DB_MASTER );
		$conds = array(
			'ctresult_run_id' => $this->id,
			'ctresult_case_id=ctcase_id',
		);
		if( $success !== null ) {
			$conds['ctresult_success'] = $success ? 1 : 0;
		}
		
		$result = $dbr->select(
			array(
				'code_test_result',
				'code_test_case',
			),
			'*',
			$conds,
			__METHOD__ );
		
		$out = array();
		foreach( $result as $row ) {
			$out[] = new CodeTestResult( $this, $row );
		}
		return $out;
	}
	
	public static function newFromRevId( CodeTestSuite $suite, $revId ) {
		$dbr = wfGetDB( DB_MASTER );
		$row = $dbr->selectRow( 'code_test_run',
			'*',
			array(
				'ctrun_suite_id' => $suite->id,
				'ctrun_rev_id' => $revId,
			),
			__METHOD__ );
		if( $row ) {
			return new CodeTestRun( $suite, $row );
		} else {
			return null;
		}
	}
	
	public function setStatus( $status ) {
		$this->status = $status;
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'code_test_run',
			array(
				'ctrun_status' => $status,
			),
			array(
				'ctrun_id' => $this->id,
			),
			__METHOD__ );
	}
	
	public static function insertRun( CodeTestSuite $suite, $revId, $status, $results=array() ) {
		$dbw = wfGetDB( DB_MASTER );
		$countTotal = count( $results );
		$countSucceeded = count( array_filter( $results ) );
		
		$insertData = array(
			'ctrun_suite_id' => $suite->id,
			'ctrun_rev_id' => $revId,
			'ctrun_status' => $status,
			'ctrun_count_total' => $countTotal,
			'ctrun_count_success' => $countSucceeded,
		);
		$dbw->insert( 'code_test_run',
			$insertData,
			__METHOD__ );

		$insertData['ctrun_id'] = $dbw->insertId();
		$run = new CodeTestRun( $suite, $insertData );
		if( $status == 'complete' && $results ) {
			$run->insertResults( $results );
		}
		return $run;
	}
	
	public function getCaseId( $caseName ) {
		$this->loadCaseMap();
		if( isset( $this->mCaseMap[$caseName] ) ) {
			return $this->mCaseMap[$caseName];
		} else {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->insert( 'code_test_case',
				array(
					'ctcase_suite_id' => $this->id,
					'ctcase_name' => $caseName,
				),
				__METHOD__ );
			$id = intval( $dbw->insertId() );
			$this->mCaseMap[$caseName] = $id;
			return $id;
		}
	}
	
	protected function loadCaseMap() {
		if( is_null( $this->mCaseMap ) ) {
			$this->mCaseMap = array();
			$dbw = wfGetDB( DB_MASTER );
			$result = $dbw->select( 'code_test_case',
				array(
					'ctcase_id',
					'ctcase_name',
				),
				array(
					'ctcase_suite_id' => $this->id,
				),
				__METHOD__
			);
			foreach( $result as $row ) {
				$this->mCaseMap[$row->ctcase_name] = intval( $row->ctcase_id );	
			}
		}
	}
	
	public function saveResults( $results ) {
		$this->insertResults( $results );
		$this->status = "complete";
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'code_test_run',
			array(
				'ctrun_status' => $this->status,
				'ctrun_count_total' => $this->countTotal,
				'ctrun_count_success' => $this->countSuccess,
			),
			array(
				'ctrun_id' => $this->id,
			),
			__METHOD__ );
	}
	
	public function insertResults( $results ) {
		$dbw = wfGetDB( DB_MASTER );
		$this->countTotal = 0;
		$this->countSuccess = 0;
		foreach( $results as $caseName => $result ) {
			$this->countTotal++;
			if( $result ) {
				$this->countSuccess++;
			}
			$insertData[] = array(
				'ctresult_run_id' => $this->id,
				'ctresult_case_id' => $this->getCaseId( $caseName ),
				'ctresult_success' => $result ? 1 : 0,
			);
		}
		$dbw->insert( 'code_test_result', $insertData, __METHOD__ );
	}
}
