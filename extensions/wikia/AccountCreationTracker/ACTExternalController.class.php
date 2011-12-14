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
	
	public function fetchContributionsDataTables() {
		//error_log( "start" );
		$aColumns = array( 'wiki_id', 'page_id', 'rev_id', 'user_id', 'ip', 'rev_timestamp', 'event_type' );
		
		$dbr = $this->getDb( DB_SLAVE );
		
		$users = explode( ",", $_GET['users'] );
		$users = array_map("intval", $users);
		
		$limitS = 0;
		$limitL = 10;
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$limitS = mysql_real_escape_string( $_GET['iDisplayStart'] );
			$limitL = mysql_real_escape_string( $_GET['iDisplayLength'] );
		}
		//$limitS = 10;

		//error_log( $limitS );
		//error_log( $limitL );
		
		$orderBy = array();
		if ( isset( $_GET['iSortCol_0'] ) )	{
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
					$orderBy[] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] );
				}
			}
		}
		
		$results = array();
		
		$table = array( 'events' );
		$vars = $aColumns;
		$conds = array( 'user_id' => $users );
		if(!empty($orderBy)) {
			$options = array('LIMIT'=>$limitL, 'OFFSET'=>$limitS, 'ORDER BY'=>implode(",",$orderBy));
		} else {
			$options = array('LIMIT'=>$limitL, 'OFFSET'=>$limitS);
		}
		
		$res = $dbr->select( $table, 'COUNT(1) as c', $conds, __METHOD__);
		$row = $dbr->fetchRow( $res );
		
		$iTotal = $row['c'];
		
		//error_log( $iTotal );
		
		$iFilteredTotal = $iTotal;
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options);

		//error_log( print_r($output,1) );
		//error_log( "fetching results" );
		
		while( $row = $dbr->fetchRow($res) ) {
			if ( !empty( $row['user_id'] ) ) {
				$name = User::newFromId( $row['user_id'] )->getName();
			} else {
				$name = long2ip( $row['ip'] );
			}
			$row['user_id'] = '<a href="'.GlobalTitle::newFromText( $name, NS_USER, $row['wiki_id'] )->getFullURL().'">'.$name.'</a>';

			$wiki = WikiFactory::getWikiById( $row['wiki_id'] );	
	
			if(!empty($wiki)) {
				$row['wiki_id'] = '<a href="'.$wiki->city_url.'">'.$wiki->city_title.'</a>';
			}


			switch( $row['event_type'] ) {
				case ScribeEventProducer::EDIT_CATEGORY_INT:
					$row['event_type'] = ScribeEventProducer::EDIT_CATEGORY;
					break;
				case ScribeEventProducer::CREATEPAGE_CATEGORY_INT:
					$row['event_type'] = ScribeEventProducer::CREATEPAGE_CATEGORY;
					break;
			}
			
			$row['ip'] = long2ip($row['ip']);
			
			$output_row = array();
			
			for($i = 0; $i< count($aColumns); $i++) {
				$output_row[] = $row[ $aColumns[$i] ];
			}

			$output['aaData'][] = $output_row;
		}
		
		echo json_encode( $output );
		//error_log( print_r($output,1) );
		$this->skipRendering();
		return false;
	}

}
