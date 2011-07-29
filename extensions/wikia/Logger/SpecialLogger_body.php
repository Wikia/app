<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ;
}

class LoggerPage extends SpecialPage {
    private $qp = null;

	function  __construct() {
		parent::__construct( "Logger"  /*class*/, 'logger' /*restriction*/);
		wfLoadExtensionMessages("Logger");
	}

	function execute( $subpage, $limit = 0, $offset = "", $show = true ) {
		global $wgUser, $wgOut, $wgRequest;
		wfLoadExtensionMessages("Mostvisitedpages");

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( 'logger' ) ) {
			$this->displayRestrictionError();
			return;
		}

		/**
		 * initial output
		 */
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'Logger' );
		$wgOut->setPageTitle( wfMsg('loggertitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$this->mLog = $wgRequest->getVal ('target', $subpage);
		$this->mShow = $wgRequest->getVal ( 'show', $show );

		if (empty($limit) && empty($offset)) { 
            list( $limit, $offset ) = wfCheckLimits(20);
        }
        
        $this->qp = new LoggerQueryPage( $this->mLog, $limit, $offset, $this->mShow );
        
		if ( !empty( $this->mShow ) ) {
            $this->setHeaders();
			global $wgUser, $wgOut, $wgTitle;
            $sk = $wgUser->getSkin();
        } else {
            // return data as array - not like <LI> list
            $this->qp->setShow(false);
        }
        $this->qp->getPageHeader();
        $this->qp->showResults();
    }
    
    function getResult() { return $this->qp->getResult(); }
}

class LoggerQueryPage {
	private $data = array();
	private $show = false;
	var $mTitle = "";
	var $mLogname = "";
	var $mName = "Logger";
	var $mPercent = 0;

	function __construct($log_name, $limit = 20, $offset = 0, $show = 1) { 
		$this->mShow = $show;
		$this->offset = $offset;
		$this->limit =  $limit;
		$this->mTitle = Title::makeTitle( NS_SPECIAL, $this->mName );
		$this->mLogname = $log_name;
	}

	function linkParameters() { 
		return array('target' => $this->mLogname);	
	}
		
	function setShow( $bool ) { $this->mShow = $bool; }

	function getPageHeader() {
		global $wgOut;
		
		wfProfileIn( __METHOD__ );

		if (empty($this->mShow)) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileIn( __METHOD__ );
		$action = $this->mTitle->escapeLocalURL("");
		$logList = $this->getLogList();

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"action"	=> $action,
			"logList"	=> $logList,
			"mLog"  	=> $this->mLogname,
		));
		$wgOut->addHTML( $oTmpl->execute("main-form") );
		wfProfileOut( __METHOD__ );
	}

	public function getResult() { return $this->data; }

	public function showResults( ) {
		global $wgUser, $wgOut, $wgCityId, $wgLang, $wgContLang, $wgExternalDatawareDB;

		wfProfileIn( __METHOD__ );
		$wgOut->setSyndicated( false );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB ); 

		$where = array( "name" => $this->mLogname );		

		$oLastRow = $dbr->selectRow (
			array( 'withcity_log' ),
			array( "records, pos as value" ),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'pos DESC'
			)
		);

		$oRes = $dbr->select (
			array( 'withcity_log' ),
			array( "city_id, records, start, end, unix_timestamp(end) - unix_timestamp(start) as diff, pos as value" ),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'pos DESC',
				'LIMIT' => $this->limit,
				'OFFSET' => $this->offset
			)
		);

		$this->mPercent = round (  ( isset($oLastRow->records) ) ? 100 * $oLastRow->value / $oLastRow->records : 0 , 2 ) ;

		# nbr all records 
		/*$res = $dbr->query('SELECT FOUND_ROWS() as rowcount');
		$oRow = $dbr->fetchObject ( $res );
		$num = $oRow->rowcount;*/

		$data = array( 'numrec' => 0, 'rows' => array() ) ;
		$loop = 0;
		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			$data[ 'rows' ][] = $oRow;
			$data[ 'numrec' ]++;
		}
		$dbr->freeResult( $oRes );

		$num = $this->outputResults( $wgUser->getSkin(), $data );

		wfProfileOut( __METHOD__ );
		return $num;
	}

	function formatResult( $skin, $result ) {
		$res = false;
		
		$wikia_url = WikiFactory::getVarValueByName( 'wgServer', $result->city_id );
		if (empty($this->mShow)) {
			$this->data[$result->city_id] = array(
				'value' 		=> $result->value, 
				'city_id'		=> $result->city_id,
				'city_url'		=> $wikia_url,
				'records'		=> $result->records,
				'start_update'	=> $result->start,
				'end_update'	=> $result->end,
				'percent'		=> $this->percent,
				'diff'			=> $result->diff
			);
			$res = $this->data[$result->city_id];
		} else {
			$wikia = Xml::element( "a", array( "href" => $wikia_url ), $wikia_url ) ;
			$record = sprintf("%s, finished: %s (%d sec.)", $wikia, $result->end, $result->diff, $result->value, $result->records);
			$value = sprintf(" <strong>%d/%d</strong> records ", $result->value, $result->records );
			$res = wfSpecialList( $record, $value );
		}
		return $res;
	}

	private function getLogList() {
		global $wgMemc, $wgExternalDatawareDB;
		global $wgCityId;
		$records = array();
		$memkey = wfForeignMemcKey( $wgExternalDatawareDB, null, "Logger" );
		$cached = $wgMemc->get($memkey);
		if (!is_array ($cached)) {
			$dbs = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
			if (!is_null($dbs)) {
				$res = $dbs->select(
					array( 'withcity_log' ),
					array( 'name', 'count(*) as log_count' ),
					array( ),
					__METHOD__,
					array(
						'GROUP BY' => 'name'
					)
				);

				foreach( $res as $row ) {
					$records[ $row->name ] = $row->log_count;
				}				
				$dbs->freeResult($res);
				$wgMemc->set( $memkey, $records, 60*60*3 );
			}
		} else {
			$records = $cached;
		}

		return $records;
	}
	
	public function outputResults( $skin, $data ) {
		global $wgContLang, $wgOut;

        wfProfileIn( __METHOD__ );
        
		$num = 0;		
		$html = array();
		if ( $this->mShow ) {
			$wgOut->addHTML( XML::openElement( 'div', array('class' => 'mw-spcontent') ) );
		}	

		if ( isset($data) && $data['numrec'] > 0 ) {
			$num = $data['numrec'];
			
			if ( $this->mShow ) {
				$html[] = XML::openElement( 'ol', array('start' => $this->offset + 1, 'class' => 'special' ) );
			}

			$loop = 0; $skip = 0;
			foreach ( $data['rows'] as $id => $oRow ) {
				$res = $this->formatResult( $skin, $oRow );
				$html[] = $this->mShow ? Xml::openElement( 'li' ) . $res . Xml::closeElement( 'li' ) : $wgContLang->listToText( array_values( $res ) ) . " <br />";
				$loop++;
			}

			if( $this->mShow ) {
				$html[] = XML::closeElement( 'ol' );
			}

		}

		# Top header and navigation
		if ( $this->mShow ) {
			$wgOut->addHTML( '<p>' . wfMsgExt( 'loggerrecordswithpercent', array('parse'), array($num, $this->mPercent) ) . '</p>' );
			if( $num > 0 ) {
				$wgOut->addHTML( '<p>' . wfShowingResults( $this->offset, $num ) . '</p>' );
				# Disable the "next" link when we reach the end
				$paging = wfViewPrevNext( 
					$this->offset, 
					$this->limit, 
					$wgContLang->specialPage( $this->mName ), 
					wfArrayToCGI( $this->linkParameters() ), 
					( $num < $this->limit ) 
				);
				$wgOut->addHTML( '<p>' . $paging . '</p>' );
			} else {
				$wgOut->addHTML( XML::closeElement( 'div' ) );
				return;
			}
		}

		$html = $this->mShow ? implode( '', $html ) : $wgContLang->listToText( $html );
		$wgOut->addHTML( $html );
		
		# Repeat the paging links at the bottom
		if( $this->mShow ) {
			$wgOut->addHTML( '<p>' . $paging . '</p>' );
		}

		$wgOut->addHTML( XML::closeElement( 'div' ) );
		
        wfProfileOut( __METHOD__ );
		return $num;
	}	
}

