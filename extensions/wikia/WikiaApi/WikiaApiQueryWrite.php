<?php

/**
 * WikiaApiQuery
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 * @todo
 *
 */

if (!defined('MEDIAWIKI')) {
	// Eclipse helper - will be ignored in production
	require_once ('ApiBase.php');
}

class WikiaApiQueryWrite extends ApiQuery {

	private $mMasterDB = null;
	private $mAction;

	public function __construct($main, $action) {
		$this->mAction = $action;
		parent :: __construct($main, $action);
	}

	public function getDescription() {
		switch ($this->mAction)
		{
			case 'insert': return array (
								'Insert API module allows applications to add some data to the MediaWiki databases,',
								'and is loosely based on the Query API interface currently available on all MediaWiki servers.',
							);
			case 'delete': return array (
								'Delete API module allows applications to remove some data from the MediaWiki databases,',
								'and is loosely based on the Query API interface currently available on all MediaWiki servers.',
							);
			case 'update': return array (
								'Update API module allows applications to change some data in the MediaWiki databases,',
								'and is loosely based on the Query API interface currently available on all MediaWiki servers.',
							);
		}
	}

	public function getAllowedParams() {
		return array (
			'list' => array (
				ApiBase :: PARAM_ISMULTI => true,
				ApiBase :: PARAM_TYPE => 'string'
			),
			'wkXXXXX' => array (
				ApiBase :: PARAM_ISMULTI => true,
				ApiBase :: PARAM_TYPE => 'string'
			),
			'redirects' => false,
			'indexpageids' => false,
			'export' => false,
			'exportnowrap' => false
		);
	}

	public function getParamDescription() {
		return array (
			'list' 		=> 'Which lists to get',
			'wkXXXXX'	=> 'Wikia parameters. See list below to get Wikia parameters.',
			'redirects' => 'Automatically resolve redirects'
		);
	}

	public function getExamples() {
		return array (
			'api.php?action='.$this->mAction.'&list=wkvoteart&wkpage=0'
		);
	}

	public function getDB() {
		if (!isset ($this->mMasterDB)) {
			$this->profileDBIn();
			$this->mMasterDB = wfGetDB(DB_MASTER);
			$this->profileDBOut();
		}
		return $this->mMasterDB;
	}

	public function makeHelpMsg() {
		global $wgAPIListModules;

		// Use parent to make default message for the query module
		static $lnPrfx = "\n  ";
		$astriks = str_repeat('--- ', 8);

		#---
		$msg = $this->getDescription();

		if ($msg !== false) {
			if (!is_array($msg)) {
				$msg = array( $msg );
			}
			$msg = $lnPrfx . implode($lnPrfx, $msg) . "\n";
		}

		#--- Examples
		$paramsMsg = $this->makeHelpMsgParameters();
		if ($paramsMsg !== false) {
			$msg .= "Parameters:\n$paramsMsg";
		}

		#--- Examples
		$examples = $this->getExamples();
		if ($examples !== false) {
			if (!is_array($examples)) {
				$examples = array( $examples );
			}
			$msg .= 'Example' . (count($examples) > 1 ? 's' : '') . ":\n  ";
			$msg .= implode($lnPrfx, $examples) . "\n";
		}

		$this->mPageSet = null;

		$msg .= "\n$astriks ".ucfirst($this->mAction).": List  $astriks\n\n";
		$msg .= $this->makeHelpMsgHelper($wgAPIListModules, 'list');
		$msg .= "\n$astriks end of List  $astriks\n\n";

		return $msg;
	}

	public function makeHelpMsgParameters() {
		return ApiBase :: makeHelpMsgParameters();
	}

	private function makeHelpMsgHelper($moduleList, $paramName) {

		$moduleDscriptions = array ();

		foreach ($moduleList as $moduleName => $moduleClass) {
			$module = new $moduleClass ($this, $moduleName, null);
			$msg2 = $module->makeHelpMsg();
			if ($msg2 === false) { // module not implemented
				continue;
			}
			$msg = "* $paramName=$moduleName *";
			if ($msg2 !== false)
				$msg .= $msg2;
			if ($module instanceof ApiQueryGeneratorBase)
				$msg .= "Generator:\n  This module may be used as a generator\n";
			$moduleDscriptions[] = $msg;
		}

		return implode("\n", $moduleDscriptions);
	}


}
?>
