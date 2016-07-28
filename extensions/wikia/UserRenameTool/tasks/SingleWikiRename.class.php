<?php

namespace UserRenameTool\Tasks;

class SingleWikiRename extends WikiRenameBase {
	const SCRIPT_TEMPLATE = "SERVER_ID=%s php %s/maintenance/wikia/RenameUser_local.php %s";

	private $cityId;
	private $command;
	private $exitCode = null;

	/**
	 * Rename a user on a single wiki
	 *
	 * @param int $cityId
	 * @param array $params See comment in WikiRenameBase::params for more details.
	 * @return bool
	 */
	public function run( $cityId, array $params ) {
		$this->cityId = $cityId;
		$this->params = $params;
		
		$this->setupLogging();
		$this->buildCommand();

		try {
			$this->runCommand();
			$this->logFinish();
			$this->cleanup();
		} catch (\Exception $e) {
			$this->error("error while renaming user", [
				'message' => $e->getMessage(),
				'stack' => $e->getTraceAsString(),
			]);
			return false;
		}

		$this->recordWikiRenamed( $this->cityId );

		return true;
	}

	private function buildCommand() {
		global $IP;
		
		$opts = $this->getShellOptions( $this->params );

		// Run the maintenance script for each wiki
		$this->command = sprintf(self::SCRIPT_TEMPLATE, $this->cityId, $IP, $opts);
	}
	
	private function getShellOptions( $params ) {
		$renameIP = !empty( $params['rename_ip'] );

		$opts = [
			'rename-user-id' => $params['rename_user_id'],
			'requestor-id' => $params['requestor_id'],
			'reason' => $params['reason'],
		];

		if ( $renameIP ) {
			$opts['rename-old-name'] = $params['rename_old_name'];
			$opts['rename-new-name'] = $params['rename_new_name'];
		} else {
			$opts['rename-old-name-enc'] = rawurlencode( $params['rename_old_name'] );
			$opts['rename-new-name-enc'] = rawurlencode( $params['rename_new_name'] );
			$opts['rename-fake-user-id'] = $params['rename_fake_user_id'];
			$opts['phalanx-block-id'] = $params['phalanx_block_id'];
		}

		$optString = '';
		foreach ( $opts as $opt => $val ) {
			$optString .= sprintf( ' --%s %s', $opt, escapeshellarg( $val ) );
		}

		// Include value-less options
		if ( $renameIP ) {
			$optString .= ' --rename-ip-address';
		}

		return $optString;
	}

	private function runCommand() {
		$output = wfShellExec( $this->command, $this->exitCode );

		$logMessage = sprintf("Rename user %s to %s on city id %s",
			$this->params['rename_old_name'], $this->params['rename_new_name'], $this->cityId);
		$logContext = [
			'command' => $this->command,
			'exitStatus' => $this->exitCode,
			'output' => $output,
		];

		if ($this->exitCode > 0) {
			$this->error($logMessage, $logContext);
		} else {
			$this->info($logMessage, $logContext);
		}
	}

	private function logFinish() {
		if ( $this->exitCode > 0 ) {
			$this->process->logFailWikiToStaff( $this->cityId );
		} else {
			$this->process->logFinishWikiToStaff( $this->cityId );
		}
	}

	private function cleanup() {
		$loadBalancerFactory = wfGetLBFactory();
		$loadBalancerFactory->forEachLBCallMethod( 'commitMasterChanges' );
		$loadBalancerFactory->forEachLBCallMethod( 'closeAll' );
	}
}