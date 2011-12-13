<?php

class AccountCreationTrackerExternalController extends WikiaSpecialPageController {
	public function __construct() {
	}

	protected function getDb( $type = DB_SLAVE ) {
		return $this->wf->getDb( $type, "stats", $this->wg->StatsDB );
	}
	
	public function fetchContributions() {
		
		$dbr = $this->getDb( DB_SLAVE );
		
		$ids = $this->request->getVal('users');

		$results = array();
		
		$table = array( 'events' );
		$vars = array( '*' );
		$conds = array( 'user_id' => $ids );
		$options = array();
		$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options);
		while( $row = $dbr->fetchRow($res) ) {
			$results[] = $row;
		}
		
		$this->response->setVal(
			'html', 
			$this->app->renderView(
				'AccountCreationTracker',
				'renderContributions',
				array('contributions'=>$results)
			)
		);
		
		return true;
	}

}
