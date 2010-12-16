<?php

class CodeTestResult {
	function __construct( CodeTestRun $run, $row ) {
		$this->run = $run;
		$this->id = $row->ctresult_id;
		$this->caseId = $row->ctresult_case_id;
		$this->caseName = $row->ctcase_name;
		$this->success = (bool)$row->ctresult_success;
	}
}
