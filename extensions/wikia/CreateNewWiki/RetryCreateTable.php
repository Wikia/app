<?php
use Wikia\Tasks\Tasks\BaseTask;

class RetryCreateTable extends BaseTask {
	/**
	 * Executes sourceFile method on provided database and queues itself again if failed.
	 * Breaks at 3rd attempt.
	 *
	 * @param string $dbName name of database where tables should be created
	 * @param string $filename
	 * @param callback $lineCallback function passed to sourceFile
	 * @param callback $resultCallback function passed to sourceFile
	 * @param string|bool $callerName
	 * @param int $attempt
	 * @return string
	 * @throws Exception
	 */
	public function retry( $dbName, $filename, $lineCallback = false, $resultCallback = false, $callerName = false, $attempt = 0 ) {
		$dbw = wfGetDB( DB_MASTER, [], $dbName );
		$result = $dbw->sourceFile( $filename, $lineCallback, $resultCallback, $callerName );
		if ( $result !== true ) {
			if ( $attempt >= 3 ) {
				throw new Exception('Too many failed attempts (' . $attempt . '). Braking retry loop.');
			}
			$this->error('Failed source file execution. Queue new retry task.');
			$task = new RetryCreateTable();
			$task->call( 'retry', $dbName, $filename, $lineCallback, $resultCallback, $callerName, $attempt++ );
			$task->queue();
		}
		$this->info($filename);
		return 'Retry attempt number ' . $attempt . ' succeded';
	}
}
