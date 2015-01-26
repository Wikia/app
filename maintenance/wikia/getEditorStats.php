<?php

/**
 * Maintenance script used for getting revisions with tags (for example Editor type used for generating revision)
 *
 * Env vars:
 * [int] SERVER_ID - wiki id | example 12345
 * [string] START_DATE - format D-M-Y example "01-01-2015"
 * [string] END_DATE - format D-M-Y example "01-01-2015"
 */

require_once( dirname( __FILE__ ) . '../../Maintenance.php' );

class GetRevisionWithTags extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Get Editor Stats';
	}

	public function execute() {
		$timeStampStart = date('YMDHIs', strtotime($_SERVER['START_DATE']));
		$timeStampEnd = date('YMDHIs', strtotime($_SERVER['END_DATE']));
		$query = (new WikiaSQL())
			->SELECT()
			->FIELD('rev_id')
			->FROM('revision')
			->LEFT_JOIN('tag_summary')
			->ON('ts_rev_id', 'rev_id')
			->FIELD('ts_tags')
			->WHERE('rev_timestamp')
			->BETWEEN($timeStampStart, $timeStampEnd)
			->LIMIT(100);

		$query->run(wfGetDB(DB_SLAVE), function (ResultWrapper $result) {
			while ($row = $result->fetchObject()) {
				foreach ($row as $column) {
					print ($column . ' ');
				}
				print(PHP_EOL);
			}
		});
	}
}

$maintClass = 'GetRevisionWithTags';
require_once( RUN_MAINTENANCE_IF_MAIN );
