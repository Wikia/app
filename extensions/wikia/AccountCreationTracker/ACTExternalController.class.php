<?php

class AccountCreationTrackerExternalController extends WikiaSpecialPageController {
	public function __construct() {
	}

	protected function getDb( $type = DB_SLAVE ) {
		return $this->wf->getDb( $type, "stats", $this->wg->StatsDB );
	}
		
	public function fetchContributionsDataTables() {
		//error_log( "start" );
		$aColumns = array( 'rev_timestamp', 'user_id', 'event_type', 'wiki_id', 'page_id', 'rev_id', 'ip' );
		
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
			$wiki = WikiFactory::getWikiById( $row['wiki_id'] );

			if ( !is_object( $wiki ) || $wiki->city_public == 0 ) {
				// wiki does not exist, skip it
				continue;
			}

			$wikiSitename = WikiFactory::getVarValueByName( 'wgSitename', $row['wiki_id'] );
			$row['wiki_id'] = Xml::element( 'a', array( 'href' => $wiki->city_url ), $wikiSitename );

			if ( !empty( $row['user_id'] ) ) {
				$name = User::newFromId( $row['user_id'] )->getName();
			} else {
				$name = long2ip( $row['ip'] );
			}
			$row['user_id'] = Xml::element( 'a', array( 'href' => GlobalTitle::newFromText( $name, NS_USER, $wiki->city_id )->getFullURL() ), $name );

                        global $wgDevelEnvironment;
                        if ( !$wgDevelEnvironment ) {
                                $page = GlobalTitle::newFromId( $row['page_id'], $row['page_ns'], $wiki->wiki_id );
                                $row['page_id'] = Xml::element( 'a', array( 'href' => $page->getFullURL() ), $page->getPrefixedText() );
                        } else {
                                $row['page_id'] = 'db not found';
                        }
                

			switch( $row['event_type'] ) {
				case ScribeEventProducer::EDIT_CATEGORY_INT:
					$row['event_type'] = 'edit';
					break;
				case ScribeEventProducer::CREATEPAGE_CATEGORY_INT:
					$row['event_type'] = 'create';
					break;
				case ScribeEventProducer::DELETE_CATEGORY_INT:
					$row['event_type'] = 'delete';
                                        break;
				case ScribeEventProducer::UNDELETE_CATEGORY_INT:
					$row['event_type'] = 'undelete';
			}
				
			$output_row = array();
			
			for($i = 0; $i< count($aColumns); $i++) {
				$output_row[] = $row[ $aColumns[$i] ];
			}

			$output['aaData'][] = $output_row;
		}
		
		echo json_encode( $output );
		$this->skipRendering();
		return false;
	}

}
