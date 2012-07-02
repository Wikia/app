<?php
/**
 * @author ning
 */

if ( !defined( 'MEDIAWIKI' ) ) {
  die( "This file is part of the Semantic NotifyMe Extension. It is not a valid entry point.\n" );
}

class SMWNMRefreshJob extends Job {

	function __construct( Title $title ) {
		parent::__construct( 'SMWNMRefreshJob', $title );
	}

	/**
	 * Run job
	 * @return boolean success
	 */
	function run() {
		wfProfileIn( 'SMWNMRefreshJob::run (SMW)' );
		SMWNotifyProcessor::refreshNotifyMe();
		wfProfileOut( 'SMWNMRefreshJob::run (SMW)' );
		return true;
	}

	/**
	 * This actually files the job. This is prevented if the configuration of SMW
	 * disables jobs.
	 * NOTE: Any method that inserts jobs with Job::batchInsert or otherwise must
	 * implement this check individually. The below is not called in these cases.
	 */
	function insert() {
		global $smwgEnableUpdateJobs;
		if ( $smwgEnableUpdateJobs ) {
			parent::insert();
		}
	}
}
