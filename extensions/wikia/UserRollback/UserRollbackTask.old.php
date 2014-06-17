<?php

class OldUserRollbackTask extends BatchTask {
	
	protected $mParams = array();

	public function __construct() {
		$this->mType = "userrollback";
		$this->mVisible = true;
		parent::__construct();
	}
	
	public function execute( $params = null ) {
		global $IP, $wgWikiaLocalSettingsPath;
		
		$this->mParams = unserialize($params->task_arguments);
		$this->users = $this->mParams['users'];
		$this->time = $this->mParams['time'];
		
		$userNames = array();
		foreach ($this->users as $u)
			$userNames[] = $u['canonical'];
		
		// Save initial log line
		$processSummary = "Processing UserRollback request:\n";
		$processSummary .= "  - users: " . implode(', ',$userNames) . "\n";
		$processSummary .= "  - from: " . $this->time;
		$this->log($processSummary);
		
		// ...
		$wikiIds = $this->findWikis( $this->users );
		
		$noErrors = true;
		$allUsers = implode('|',$userNames);
		foreach ($wikiIds as $wikiId) {
			$cmd = "SERVER_ID={$wikiId} php {$IP}/extensions/wikia/UserRollback/maintenance/rollbackEditsMulti.php ".
					"--users " . escapeshellarg($allUsers) . " --time " . escapeshellarg($this->time) .
					" --onlyshared --conf {$wgWikiaLocalSettingsPath}";
			$this->log("Running {$cmd}");
			$exitCode = null;
			$output = wfShellExec($cmd, $exitCode);

			if($exitCode == 1) $noErrors = false;

			$this->log( "--- Command output ---\n{$output}\n--- End of command output ---" );
			$this->log("Finished processing wiki with ID {$wikiId}.");
		}
		$this->log("Finished processing work.");
		
		return $noErrors;
	}
	
	protected function findWikis( $users ) {
		global $wgStatsDB, $wgStatsDBEnabled, $wgDevelEnvironment;
		
		if (!$wgStatsDBEnabled) {
			return false;
		}

		// on devbox we have to fall back to static list
		// because we have no active read-write statsdb there
		if ( !empty( $wgDevelEnvironment ) ) {
			return array(
				165, // firefly
			);
		}
		
		$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
		$wikiIds = array();
		foreach ($users as $user) {
			if ( $user['id'] != 0 ) { // regular user
				$where = array(
					'user_id' => intval($user['id']),
				);
			} else { // ip - anons
				$where = array(
					'user_id' => 0,
					'ip' => IP::toUnsigned($user['ip']),
				);
			}
			$res = $dbr->select('events', 'wiki_id', $where, __METHOD__, array('DISTINCT'));
			$userWikiIds = array();
			while($row = $dbr->fetchObject($res)) {
				$wikiIds[$row->wiki_id] = true;
				$userWikiIds[] = $row->wiki_id;
			}
			$this->log("User \"".$user['canonical']."\": found ".count($userWikiIds)." wikis: ".implode(', ',$userWikiIds));
		}
		$wikiIds = array_keys($wikiIds);
		sort($wikiIds);
		return $wikiIds;
	}
	
	public function getForm( $title, $errors = false ) {
	}
	
	public function submitForm() {
		return array(
			array(
				'x' => 'x',
			),
		);
	}
	
}