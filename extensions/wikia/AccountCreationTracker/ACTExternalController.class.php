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
		$vars = array(
			'wiki_id',
			'page_id',
			'rev_id',
			'user_id',
			'page_ns',
			'ip',
			'rev_timestamp',
			'event_type'
		);
		$conds = array( 'user_id' => $ids );
		$options = array( 'LIMIT' => 10 );
		$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options);
		while( $row = $dbr->fetchRow($res) ) {
	//		$row['page_id'] = GlobalTitle::newFromId( $row['page_id'], $row['page_ns'], $row['wiki_id'] )->getFullURL();

			if ( !empty( $row['user_id'] ) ) {
				$name = User::newFromId( $row['user_id'] )->getName();
			} else {
				$name = long2ip( $row['ip'] );
			}
			$row['user_id'] = GlobalTitle::newFromText( $name, NS_USER, $row['wiki_id'] )->getFullURL();

			$row['wiki_id'] = WikiFactory::getWikiById( $row['wiki_id'] )->city_url;


			switch( $row['event_type'] ) {
				case ScribeEventProducer::EDIT_CATEGORY_INT:
					$row['event_type'] = ScribeEventProducer::EDIT_CATEGORY;
					break;
				case ScribeEventProducer::CREATEPAGE_CATEGORY_INT:
					$row['event_type'] = ScribeEventProducer::CREATEPAGE_CATEGORY;
					break;
			}

			$results[] = $row;
		}
		
		$this->response->setVal( 'num', $res->numRows() );
		
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
