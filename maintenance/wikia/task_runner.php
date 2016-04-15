<?php
set_time_limit( 3600 ); // PLATFORM-2039
$wgCommandLineSilentMode = true; // suppress output from Wikia::log calls

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class TaskRunnerMaintenance extends Maintenance {
	public function __construct() {
		parent::__construct();

		$this->addOption('task_id', '', true, true);
		$this->addOption('call_order', '', true, true);
		$this->addOption('task_list', '', true, true);
		$this->addOption('created_at', '', true, true);
		$this->addOption('created_by', '', true, true);
		$this->addOption('wiki_id', '', false, true);
	}

	/**
	 * Use a dedicated mysql user / pass for running tasks
	 *
	 * Wikia change
	 *
	 * @author macbre
	 * @see PLATFORM-2025
	 * @return array consisting of mysql user and pass
	 */
	protected function getDatabaseCredentials() {
		global $wgDBtasksuser, $wgDBtaskspass;
		return [ $wgDBtasksuser, $wgDBtaskspass ];
	}

	public function loadParamsAndArgs( $self = null, $opts = null, $args = null ) {
		parent::loadParamsAndArgs($self, $opts, $args);

		if (!empty($this->mOptions['wiki_id'])) {
			putenv("SERVER_ID={$this->mOptions['wiki_id']}");
		}
	}

	public function execute() {
		global $wgFlowerUrl;

		\Wikia\Logger\WikiaLogger::instance()->pushContext( [
			'task_id' => $this->mOptions['task_id']
		] );

		// an ugly c&p from Wikia::onWebRequestInitialized
		// I'm going to burn in hell
		Wikia\Logger\WikiaLogger::instance()->info( 'Wikia internal request', [
			'source' => 'celery'
		] );

		$runner = new TaskRunner(
			$this->mOptions['wiki_id'],
			$this->mOptions['task_id'],
			$this->mOptions['task_list'],
			$this->mOptions['call_order'],
			$this->mOptions['created_by']
		);

		ob_start();
		$runner->run();
		$result = $runner->format();

		if ($runner->runTime() > TaskRunner::TASK_NOTIFY_TIMEOUT) {
			Http::post( "{$wgFlowerUrl}/api/task/status/{$this->mOptions['task_id']}", [
				'noProxy' => true,
				'postData' => json_encode( [
					'kwargs' => [
						'completed' => time(),
						'state' => $result->status,
						'result' => ( $result->status == 'success' ? $result->retval : $result->reason ),
					],
				] ),
			] );
		}

		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'took' => $runner->runTime(),
			'delay' => microtime( true ) - (float) $this->mOptions['created_at'],
			'state' => $result->status,
		] );

		ob_end_clean();
		echo json_encode( $result );
	}
}

$maintClass = TaskRunnerMaintenance::class;
require( RUN_MAINTENANCE_IF_MAIN );
