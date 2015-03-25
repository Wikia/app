<?php

class BatchVarnishPurgeToolController extends WikiaSpecialPageController {

	private static $values = array (
			//[0] displayed name
			//[1] serialized value
			//[2] condition
			0 => array('true', true, '='),
			1 => array('false', false, '='),
			2 => array('not empty', '', '!=')
		);
	
	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'BatchVarnishPurgeTool', 'batchvarnishpurgetool', false );
	}
	
	public function index() {
		global $wgOut, $wgUser, $wgRequest, $wgTitle;

		if (!$this->wg->User->isAllowed( 'batchvarnishpurgetool' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		
		$formErrors = array();

		$gUrl = $this->getVal('url', null);
		$gUrl = trim($gUrl, '/');
		if (!$gUrl) {
			$formErrors['url'] = wfMsg('batchvarnishpurgetool-error-url');
		}

		$gVar = $this->getVal('var', null);
		if (!$gVar) {
			$formErrors['var'] = wfMsg('batchvarnishpurgetool-error-var');
		}

		$gVal = $this->getVal('val', 'true');
		$gLikeVal = $this->getVal('likeValue', 'true');
		$gTypeVal = $this->getVal('searchType', 'bool');

		if (empty($formErrors)) {
			$purgedUrls = $this->purge($gUrl, $gVar, $gTypeVal, $gVal, $gLikeVal);
			$this->setVal('purgedUrls', $purgedUrls);
		}

		$formData['vars'] = $this->getListOfVars($gVar == '');
		$formData['vals'] = self::$values;
		$formData['selectedVal'] = $gVal;
		$formData['likeValue'] = $gLikeVal;
		$formData['searchType'] = $gTypeVal;
		$formData['selectedGroup'] = $gVar == '' ? 27 : ''; //default group: extensions (or all groups when looking for variable, rt#16953)
		$formData['groups'] = WikiFactory::getGroups();
		$formData['actionURL'] = $wgTitle->getFullURL();
		
		$this->setVal('formData', $formData);
		$this->setVal('formErrors', $formErrors);
	}
	
	private function purge($url, $var, $typeVal, $val, $likeVal) {
		$wikis = $this->getListOfWikisWithVar($var, $typeVal, $val, $likeVal);
		$purgeUrls = array();
		foreach ($wikis as $cityId=>$wikiData) {
			$purgeUrls[] = $wikiData['u'] . $url;
		}
		SquidUpdate::purge($purgeUrls);
		
		return $purgeUrls;
	}

	private function getListOfWikisWithVar($varId, $type, $val, $likeVal) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		
		$aWikis = array();
		if (!isset(self::$values[$val][1])) {
			return $aWikis;
		}
		$selectedVal = serialize(self::$values[$val][1]);
		$selectedCond = self::$values[$val][2];

		$aTables = array(
			'city_variables',
			'city_list'
		);
		$aWhere = array('city_id = cv_city_id');
		
		if( $type == "full" ) {
			$aWhere[] = 'cv_value' . $dbr->buildLike( $dbr->anyString(), $likeVal, $dbr->anyString() );		
		} else {
			$aWhere[] = "cv_value $selectedCond '$selectedVal'";
		}
		
		$aWhere['cv_variable_id'] = $varId;

		$oRes = $dbr->select(
			$aTables,
			array('city_id', 'city_title', 'city_url', 'city_public'),
			$aWhere,
			__METHOD__,
			array('ORDER BY' => 'city_sitename')
		);

		while ($oRow = $dbr->fetchObject($oRes)) {
			$aWikis[$oRow->city_id] = array('u' => $oRow->city_url, 't' => $oRow->city_title, 'p' => ( !empty($oRow->city_public) ? true : false ) );
		}
		$dbr->freeResult( $oRes );

		return $aWikis;
	}

	//fetching variable list from 'extension' group
	private function getListOfVars($clear) {
		global $wgExternalSharedDB;
		$aTables = array( 'city_variables_pool', 'city_variables_groups' );

		$aWhere = array('cv_group_id = cv_variable_group');
		if ($clear) { //rt#16953
			$aWhere['cv_variable_group'] = '27'; //id 'extensions' group
		}

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$oRes = $dbr->select(
			$aTables,
			array('cv_id, cv_name'),
			$aWhere,
			__METHOD__,
			array('ORDER BY' => 'cv_name')
		);

		$aVariables = array();
		while ($oRow = $dbr->fetchObject($oRes)) {
			$aVariables[$oRow->cv_id] = $oRow->cv_name;
		}
		$dbr->freeResult( $oRes );
		return $aVariables;
	}

	
}
