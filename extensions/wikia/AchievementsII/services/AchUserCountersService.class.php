<?php
define('COUNTERS_COUNTER', 1);
define('COUNTERS_DATE', 2);

class AchUserCountersService {

	var $mCounters;
	var $mUserId;

    public function __construct($user_id) {
		wfProfileIn(__METHOD__);

		global $wgExternalSharedDB;

		$this->mUserId = $user_id;

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$this->mCounters = $dbr->selectField('ach_user_counters', 'data', array('user_id' => $this->mUserId), __METHOD__);

		if($this->mCounters) {
			$this->mCounters = unserialize($this->mCounters);
		} else {
			$this->mCounters = array();
		}

		wfProfileOut(__METHOD__);
    }

    public function getCounters() {
    	global $wgCityId;
    	if(isset($this->mCounters[$wgCityId])) {
    		return $this->mCounters[$wgCityId];
    	} else {
    		return array();
    	}
    }

    public function setCounters($counters) {
    	global $wgCityId;

    	if(empty($counters)) {
    		unset($this->mCounters[$wgCityId]);
    	} else {
    		$this->mCounters[$wgCityId] = $counters;
    	}
    }

	public function save() {
		wfProfileIn(__METHOD__);
		global $wgExternalSharedDB;
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$dbw->replace('ach_user_counters', null, array('user_id' => $this->mUserId, 'data' => serialize($this->mCounters)), __METHOD__);
		wfProfileOut(__METHOD__);
	}

}