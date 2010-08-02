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
