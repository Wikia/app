<?php

/**
 * @ingroup JobQueue
 */
class HAWelcome extends Job {

	/**
	 * Construct a job
	 * @param Title $title The title linked to
	 * @param array $params Job parameters (table, start and end page_ids)
	 * @param integer $id job_id
	 */
	public function __construct( $title, $params, $id = 0 ) {
		parent::__construct( 'HAWelcome', $title, $params, $id );
	}

	public function run() {
		return true;
	}
}
