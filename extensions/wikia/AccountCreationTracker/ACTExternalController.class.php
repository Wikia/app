<?php

class AccountCreationTrackerExternalController extends WikiaSpecialPageController {
	public function __construct() {
	}

	protected function getDb( $type = DB_SLAVE ) {
		return $this->wf->getDb( $type, "stats", $this->wg->StatsDB );
	}
	
	private function returnError( $error ) {
		$output = array( 'status' => 'ERROR', 'msg'=>$error );
		echo json_encode( $output );
		$this->skipRendering();
		return false;
	}

	public function nukeContribs() {
		wfProfileIn( __METHOD__ );
		global $wgSharedDB;

		$user_id = intval($_GET['user_id']);
		$wiki_id = intval($_GET['wiki_id']);
		$page_id = intval($_GET['page_id']);
		

		if( empty($wgSharedDB) ) {
			wfProfileOut( __METHOD__ );
			return $this->returnError( 'Non-shared Users DB, cannot continue' );
		}

		if(!$user_id || !$wiki_id || !$page_id) {
			wfProfileOut( __METHOD__ );
			return $this->returnError( 'Wrong parameters' );
		}
		
		if($wiki_id != $this->wg->CityId) {
			// can only process local requests
			wfProfileOut( __METHOD__ );
			return $this->returnError( 'Wrong wiki id' );
		}
		
		if(!$this->wg->User->isAllowed('rollbacknuke')) {
			// doesn't have permissions
			wfProfileOut( __METHOD__ );
			return $this->returnError( 'No permissions to execute action' );
		}
		
		$user = User::newFromId( $user_id );
		if( !($user instanceof User) ) {
			wfProfileOut( __METHOD__ );
			return $this->returnError ( 'Unable to create User obj with ID specified' );
		} 
		
		$article = Article::newFromID( $page_id );
		if( !($article instanceof Article) ) {
			wfProfileOut( __METHOD__ );
			return $this->returnError ( 'Article does not exist' );
		}
		
		$msg = '';
		$act = new AccountCreationTracker();
		$ret = $act->rollbackPage( $article, $user->getName(), 'mass rollback', $msg);
		
		$status = $ret ? 'OK' : 'ERROR';
		$output = array( 'status' => $status, 'msg'=>$msg );
		echo json_encode( $output );
		$this->skipRendering();

		wfProfileOut( __METHOD__ );
		return false;		
	}

		
	public function fetchContributionsDataTables() {
		wfProfileIn( __METHOD__ );

		//error_log( "start" );
		$aColumns = array( 'rev_timestamp', 'user_id', 'event_type', 'wiki_id', 'page_id', 'page_ns', 'rev_size', 'rev_id', 'ip' );
		
		$dbr = $this->getDb( DB_SLAVE );
		
		$users = explode( ",", $_GET['users'] );
		$users = array_map("intval", $users);
		
		$limitS = 0;
		$limitL = 10;
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$limitS = mysql_real_escape_string( $_GET['iDisplayStart'] );
			$limitL = mysql_real_escape_string( $_GET['iDisplayLength'] );
		}
		
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

		while( $row = $dbr->fetchRow($res) ) {
			$wiki = WikiFactory::getWikiById( $row['wiki_id'] );

			if ( is_object( $wiki ) && $wiki->city_public != 0 ) {
				$wikiSitename = WikiFactory::getVarValueByName( 'wgSitename', $row['wiki_id'] );
				$url = WikiFactory::getLocalEnvURL( $wiki->city_url );
				$wikiLink = Xml::element( 'a', array( 'class'=>'wiki_name', 'href' => $url ), $wikiSitename );
				$row['wiki_id'] = $wikiLink . Xml::element( 'span', array( 'class'=>'wiki_id' ), $row['wiki_id'] );

				if ( !empty( $row['user_id'] ) ) {
					$name = User::newFromId( $row['user_id'] )->getName();
				} else {
					$name = long2ip( $row['ip'] );
				}
				$nameLink = Xml::element( 'a', array( 'class'=>'user_name', 'href' => GlobalTitle::newFromText( $name, NS_USER, $wiki->city_id )->getFullURL() ), $name );
				$row['user_id'] = $nameLink . Xml::element( 'span', array( 'class'=>'user_id' ), $row['user_id'] );

				global $wgDevelEnvironment;
				$pageId = $row['page_id'];
				$row['page_id'] = 'db not found' . Xml::element( 'span', array( 'class'=>'page_id' ), $row['page_id'] );
				if ( !$wgDevelEnvironment ) {
					$title = GlobalTitle::newFromId( $row['page_id'], $wiki->city_id );
					if ( is_object( $title ) ) {
						$pageLink = Xml::element( 'a', array( 'class'=>'page_name', 'href' => $title->getFullURL() ), $title->getPrefixedText() );
						$row['page_id'] = $pageLink . Xml::element( 'span', array( 'class'=>'page_id' ), $row['page_id'] );  
					}
				}
			}



			$row['ip'] = long2ip($row['ip']);
			
			$rawtimestamp = wfTimestamp( TS_ISO_8601, $row['rev_timestamp'] );
			$reltimestamp = Xml::element('div', array( 'class'=>"timeago", 'title'=>$rawtimestamp), '.');
			
			$row['rev_timestamp'] .= " ". $reltimestamp; 

			$namespaceName = MWNamespace::getCanonicalName( $row['page_ns'] );
			if ( $namespaceName  ) {
				$row['page_ns'] = $namespaceName;
			} elseif( $row['page_ns'] == NS_MAIN ) {
				$row['page_ns'] = 'main';
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
		
		wfProfileOut( __METHOD__ );
		return false;
	}

}
