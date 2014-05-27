<?php

/**
 * A job to do crosswiki suppression in batches, rather than
 * in one request. Size of batch is changed by changing
 * $wgCentralAuthWikisPerSuppressJob.
 */
class CentralAuthSuppressUserJob extends Job {
	/**
	 * Constructor
	 *
	 * @param Title $title Associated title
	 * @param array $params Job parameters
	 */
	public function __construct( $title, $params ) {
		parent::__construct( 'crosswikiSuppressUser', $title, $params );
	}

	/**
	 * Execute the job
	 *
	 * @return bool
	 */
	public function run() {
		$username = $this->params['username'];
		$by = $this->params['by'];
		$wikis = $this->params['wikis'];
		$suppress = $this->params['suppress'];
		$reason = $this->params['reason'];
		$user = new CentralAuthUser( $username );
		if ( !$user->exists() ) {
			wfDebugLog( 'suppressjob', "Requested to suppress non-existent user {$username} by {$by}." );
		}

		foreach ( $wikis as $wiki ) {
			$user->doLocalSuppression( $suppress, $wiki, $by, $reason );
			wfDebugLog( 'suppressjob', ( $suppress ? 'S' : 'Uns' ) . "uppressed {$username} at {$wiki} by {$by} via job queue." );
		}
		return true;
	}
}
