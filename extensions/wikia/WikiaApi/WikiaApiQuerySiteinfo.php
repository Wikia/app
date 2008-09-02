<?php

if (!defined('MEDIAWIKI')) {
	// Eclipse helper - will be ignored in production
	require_once ('ApiQueryBase.php');
}

/**
 * A query action to return meta information about the wiki site.
 * 
 * @addtogroup API
 */
class WikiaApiQuerySiteinfo extends ApiQuerySiteinfo {
	
	private $variablesList = array('wgDefaultSkin','wgAdminSkin','wgArticlePath','wgScriptPath','wgScript','wgServer','wgLanguageCode','wgCityId');
	
	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'si');
	}

	public function execute() {

		$params = $this->extractRequestParams();

		foreach ($params['prop'] as $p) {
			switch ($p) {
				default :
					ApiBase :: dieDebug(__METHOD__, "Unknown prop=$p");
				case 'general' :
					$this->appendGeneralInfo($p);
					break;
				case 'namespaces' :
					$this->appendNamespaces($p);
					break;
				case 'namespacealiases' :
					$this->appendNamespaceAliases($p);
					break;
				case 'interwikimap' :
					$filteriw = isset($params['filteriw']) ? $params['filteriw'] : false; 
					$this->appendInterwikiMap($p, $filteriw);
					break;
				case 'dbrepllag' :
					$this->appendDbReplLagInfo($p, $params['showalldb']);
					break;
				case 'statistics' :
					$this->appendStatistics($p);
					break;
				case 'variables':	
					$this->appendVariables($p);
					break;
			}
		}				
	}

	protected function appendVariables($property) {
		$data = array ();
		foreach ($this->variablesList as $id => $variableName) {
			$data[$id] = array( 'id' => $variableName );
			ApiResult :: setContent( $data[$id], (array_key_exists($variableName, $GLOBALS) && !is_null($GLOBALS[$variableName])) ? $GLOBALS[$variableName] : "" );
		}
		
		$result = $this->getResult();
		$result->setIndexedTagName($data, 'variable');
		$result->addValue('query', $property, $data);
	}

	public function getAllowedParams() {
		$params = parent::getAllowedParams();
		$params['prop'][ApiBase:: PARAM_TYPE][] = 'variables';
		return $params;
	}

	public function getParamDescription() {
		$params = parent::getParamDescription();
		$params['prop'][] = ' "variables"    - Returns values of main global variables';
		return $params;
	}

	public function getDescription() {
		return 'Return general information about the site.';
	}

	protected function getExamples() {
		return array_merge(
				parent::getExamples(), 
				array('api.php?action=query&meta=siteinfo&siprop=general|namespaces|statistics|variables')
		);
	}
}
