<?php

/* This module encapsulates the right rail.  BodyModule handles the business logic for turning modules on or off */

class RailController extends WikiaController {

	public function executeIndex($params) {
		wfProfileIn(__METHOD__);

		$this->railModuleList = isset($params['railModuleList']) ? $params['railModuleList'] : null;
		$this->isGridLayoutEnabled = BodyController::isGridLayoutEnabled();

		wfProfileOut(__METHOD__);
	}
}
