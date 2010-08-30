<?php

/* This module encapsulates the right rail.  BodyModule handles the business logic for turning modules on or off */

class RailModule extends Module {

	var $railModuleList;  // array of rail modules

	public function executeIndex($params) {
		wfProfileIn(__METHOD__);

		$this->railModuleList = isset($params['railModuleList']) ? $params['railModuleList'] : null;

		wfProfileOut(__METHOD__);
	}
}
