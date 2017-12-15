<?php
/**
 * RenameIPTask
 *
 * @author Scott Rabin <srabin@wikia-inc.com>
 */

use Wikia\Tasks\Tasks\BaseTask;

class RenameIPTask extends BaseTask {
	const EMAIL_CONTROLLER = \Email\Controller\UserNameChangeController::class;

	/**
	 * Marshal & execute the RenameIPProcess functions to rename an IP
	 *
	 * @param array $wikiCityIds
	 * @param array $params
	 *		requestor_id => ID of the user requesting this rename action
	 *		requestor_name => Name of the user requesting this rename action
	 *		old_ip => Current IP of the user to rename
	 *		new_ip => New IP for the user to rename
	 *		reason => Reason for requesting username change
	 *		phalanx_block_id => Phalanx login block ID
	 * @return bool
	 */
	public function renameIP( array $wikiCityIds, array $params ) {
		global $IP;

		$loadBalancerFactory = wfGetLBFactory();
		$process = RenameIPProcess::newFromData( $params );
		$process->setLogDestination( \RenameIPProcess::LOG_BATCH_TASK, $this );
		$process->setRequestorUser();

		$noErrors = true;

		// ComSup wants the StaffLogger to keep track of renames...
		$this->staffLog(
			'start',
			$params,
			\RenameIPLogFormatter::start(
				$params['requestor_name'],
				$params['old_ip'],
				$params['new_ip'],
				$params['reason'],
				[ $this->getTaskId() ]
			)
		);

		try {
			foreach ( $wikiCityIds as $cityId ) {
				/**
				 * execute maintenance script
				 */
				$cmd = sprintf( "SERVER_ID=%s php {$IP}/maintenance/wikia/RenameIP_local.php", $cityId );
				$opts = [
					'requestor-id' => $params['requestor_id'],
					'reason' => $params['reason'],
				];

				$opts['old-ip'] = $params['old_ip'];
				$opts['new-ip'] = $params['new_ip'];

				foreach ( $opts as $opt => $val ) {
					$cmd .= sprintf( ' --%s %s', $opt, escapeshellarg( $val ) );
				}
				
				$exitCode = null;
				$output = wfShellExec( $cmd, $exitCode );
				$logMessage = sprintf( "Changes IP address %s to %s on city id %s",
					$params['old_ip'], $params['new_ip'], $cityId );
				$logContext = [
					'command' => $cmd,
					'exitStatus' => $exitCode,
					'output' => $output,
				];
				if ( $exitCode > 0 ) {
					$this->error( $logMessage, $logContext );
					$noErrors = false;
				} else {
					$this->info( $logMessage, $logContext );
				}
				$this->staffLog(
					'log',
					$params,
					\RenameIPLogFormatter::wiki(
						$params['requestor_name'],
						$params['old_ip'],
						$params['new_ip'],
						$cityId,
						$params['reason'],
						$exitCode > 0
					)
				);

				$loadBalancerFactory->forEachLBCallMethod( 'commitMasterChanges' );
				$loadBalancerFactory->forEachLBCallMethod( 'closeAll' );
			}
		} catch ( Exception $e ) {
			$noErrors = false;
			$this->error( "error while renaming user", [
				'message' => $e->getMessage(),
				'stack' => $e->getTraceAsString(),
			] );
		}

		// clean up pre-process setup
		$process->cleanup();

		$this->notifyUser(
			\User::newFromId( $params['requestor_id'] ),
			$params['old_ip'],
			$params['new_ip']
		);

		if ( $noErrors ) {
			$this->staffLog(
				'finish',
				$params,
				\RenameIPLogFormatter::finish(
					$params['requestor_name'],
					$params['old_ip'],
					$params['new_ip'],
					$params['reason'],
					[ $this->getTaskId() ]
				)
			);
		} else {
			$this->staffLog(
				'fail',
				$params,
				\RenameIPLogFormatter::fail(
					$params['requestor_name'],
					$params['old_ip'],
					$params['new_ip'],
					$params['reason'],
					[ $this->getTaskId() ]
				)
			);
		}

		return $noErrors;
	}

	/**
	 * Shim compatibility with RenameIPProcess calling ->log on this object
	 *
	 * @param string $text
	 */
	public function log( $text ) {
		$this->info( $text );
	}

	/**
	 * Curry the StaffLogger function
	 *
	 * @param string $action Which action to log ('start', 'complete', 'fail', 'log')
	 * @param array $params The params given to `#renameUser`
	 * @param string $text The text to log
	 */
	protected function staffLog( $action, array $params, $text ) {
		\StaffLogger::log(
			'coppatool',
			$action,
			$params['requestor_id'],
			$params['requestor_name'],
			0,
			$params['new_ip'],
			$text
		);
	}

	/**
	 * Send an email to a user notifying them that a rename action completed
	 *
	 * @param User $user
	 * @param string $oldIP
	 * @param string $newIP
	 */
	protected function notifyUser( $user, $oldIP, $newIP ) {
		if ( $user->getEmail() != null ) {
			F::app()->sendRequest( self::EMAIL_CONTROLLER, 'handle', [
				'targetUser' => $user,
				'oldIP' => $oldIP,
				'newIP' => $newIP
			] );
			$this->info( 'rename user with email notification', [
				'old_name' => $oldIP,
				'new_name' => $newIP,
				'email' => $user->getEmail(),
			] );
		} else {
			$this->warning( 'no email address set for user', [
				'old_name' => $oldUsername,
				'new_name' => $newUsername,
			] );
		}
	}
}
