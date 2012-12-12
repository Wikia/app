<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

############################## Ajax ##################################

class WikiStatsAjax {
	var $mStats;
	var $mCityId;
	var $mAction; 
	var $mResult;
	var $mRequest;
	function __construct($request, $action, $cityId) {
		$this->mCityId 	= $cityId;
		$this->mAction 	= $action;
		$this->mRequest = $request;
		$this->mResult 	= "";
	}
	
	public static function fromRequest( ) {
		global $wgRequest, $wgCityId;
		$request = $wgRequest;
		$action = $wgRequest->getVal('ws');
		$cityId = $wgRequest->getVal('wikia', $wgCityId);
		$obj = new WikiStatsAjax($request, $action, $cityId);
		return $obj;
	}
	
	private function run() {
		global $wgRequest;
        wfProfileIn( __METHOD__ );
        
		if ( preg_match('/^[a-zA-Z]+$/',$this->mAction) ) {
			$func = "__".$this->mAction;
			if ( method_exists($this, $func)) {
				$this->mStats = WikiStats::newFromId($this->mCityId);
				$this->mResult = $this->$func();
			}
		}
        
        wfProfileOut( __METHOD__ );
	}

	public function getResult() {
		if ( empty($this->mResult) ) {
			$this->run();
		}
		return $this->mResult;
	}

	private function __info() {
		global $wgOut;
        wfProfileIn( __METHOD__ );

		$wgOut->setArticleBodyOnly(true);
		$out = $this->mStats->getBasicInformation();

        wfProfileOut( __METHOD__ );
		return $out;
	}

	private function __addinfo() {
		global $wgOut;
        wfProfileIn( __METHOD__ );

		$wgOut->setArticleBodyOnly(true);
		$out = $this->mStats->getAddInformation();

        wfProfileOut( __METHOD__ );
		return $out;
	}

	private function __breakdown() {
		global $wgOut;
        wfProfileIn( __METHOD__ );
		
		$month = $this->mRequest->getVal('month', 0);
		$limit = $this->mRequest->getVal('limit', WIKISTATS_WIKIANS_RANK_NBR);
		$anons = $this->mRequest->getVal('anons', 0);
		$wgOut->setArticleBodyOnly(true);
		$out = $this->mStats->userBreakdown($month, $limit, $anons);

        wfProfileOut( __METHOD__ );
		return $out;		
	}
	
	private function __activity() {
		global $wgOut, $wgUser, $wgRequest;
        wfProfileIn( __METHOD__ );
		
		$op 		= $wgRequest->getVal('op', '');
		$lang    	= $wgRequest->getVal('lang');
		$cat		= $wgRequest->getVal('cat');
		$year 		= $wgRequest->getVal('year', date('Y'));
		$month		= $wgRequest->getVal('month', date('m'));
		$limit		= $wgRequest->getVal('limit');
		$offset		= $wgRequest->getVal('offset');
		$loop		= $wgRequest->getVal('loop');
		$order		= $wgRequest->getVal('order');
		$numOrder	= $wgRequest->getVal('numOrder');
		$summary 	= $wgRequest->getVal('summary');

		$result = array(
			'sEcho' => intval($loop), 
			'iTotalRecords' => 0, 
			'iTotalDisplayRecords' => 0, 
			'sColumns' => '',
			'aaData' => array()
		);
				
		if ( empty($wgUser) ) {
			wfProfileOut( __METHOD__ );
			return "";
		}
		if ( $wgUser->isBlocked() ) {
			wfProfileOut( __METHOD__ );
			return "";
		}
		if ( !$wgUser->isLoggedIn() ) {
			wfProfileOut( __METHOD__ );
			return "";
		}
	
		$params = array(
			'year' 		=> $year, 
			'month'		=> $month, 
			'lang'		=> $lang, 
			'cat'		=> $cat, 
			'order' 	=> $order, 
			'limit'		=> $limit, 
			'offset' 	=> $offset,
			'summary'	=> $summary	
		);
		
		if ( empty($op) ) {
			#error_log ( print_r($params, true) );
			$data = $this->mStats->getWikiActivity( $params );

			if ( !empty($result) ) {
				$result['iTotalRecords'] = intval(count($data['res']));
				$result['iTotalDisplayRecords'] = isset( $data['cnt'] ) ?  intval( $data['cnt'] ) : 0;
				$result['sColumns'] = 'id,dbname,title,url,users,edits,articles,lastedit,users_diff,edits_diff,articles_diff';
				$result['aaData'] = ( $result['iTotalRecords'] > 0 ) ? array_values($data['res']) : array();
			}
		} elseif ( $op == 'xls' ) {
			$data = $this->mStats->getWikiActivity( $params, 1 );
			
			$XLSObj = new WikiStatsXLS( $this, $data['res'], wfMsg('wikistats_active_useredits'));
			$XLSObj->makeWikiaActivity($params);	
			exit;		
		}
		
		wfProfileOut( __METHOD__ );			
		return json_encode($result); 		
	}
}

function axWStats() {
	wfProfileIn( __METHOD__ );
	$return = WikiStatsAjax::fromRequest()->getResult();
	$ar = new AjaxResponse($return);
	$ar->setCacheDuration(60 * 30); // cache results for one hour
	wfProfileOut( __METHOD__ );
	return $ar;
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "axWStats";
//xls-functions
#$wgAjaxExportList[] = "axWStatisticsXLS";
