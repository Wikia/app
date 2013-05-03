<?php

class UserRollbackRequest {
	
	protected $users = '';
	protected $time = '';
	protected $priority = '';
	
	protected $usersData = null;
	
	public function clear() {
		$this->users = '';
		$this->usersData = null;
		$this->time = '';
		$this->priority = '';
	}
	
	public function readRequest( WikiaRequest $request ) {
		$this->users = $request->getVal('users');
		$this->usersData = null;
		$this->time = $request->getVal('time');
		$this->priority = $request->getVal('priority');
	}
	
	public function getUsers() {
		return $this->users;
	}
	
	public function getUserDetails() {
		if ( is_null($this->usersData) ) {
			$users = preg_split("/[\r\n]+/",$this->users);
			foreach ($users as $k => $v)
				if (trim($v) == '')
					unset($users[$k]);
			$users = array_values($users);
			foreach ($users as $k => $name) {
				$userName = User::isIP( $name ) ? $name : User::getCanonicalName( $name );
				$user = null;
				if ($userName !== false) {
					$user = User::newFromName($userName);
					if (empty($user) || $user->getId() == 0) {
						$user = null;
					}
				}
				$users[$k] = array(
					'id' => !empty($user) ? $user->getId() : 0,
					'ip' => User::isIP( $name ) ? $name : '',
					'name' => $name,
					'canonical' => $userName,
				);
			}
			$this->usersData = $users;
		}
		return $this->usersData;
	}
	
	public function getTime() {
		return $this->time;
	}
	
	public function getPriority() {
		return $this->priority;
	}
	
	public function getTaskArguments() {
		$time = wfTimestamp( TS_MW, $this->getTime() );
		return array(
			'users' => $this->getUserDetails(),
			'time' => $time,
			'priority' => $this->getPriority(),
		);
	}
	
}