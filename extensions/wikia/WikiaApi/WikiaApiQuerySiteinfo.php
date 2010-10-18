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

	private $variablesList = array('wgDefaultSkin','wgDefaultTheme','wgAdminSkin','wgArticlePath','wgScriptPath','wgScript','wgServer','wgLanguageCode','wgCityId','wgContentNamespaces','wgWikiaGlobalUserGroups');

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'si');
		$this->showError = true;
	}

	public function execute() {
		global $wgCityId;
		$params = $this->extractRequestParams();
		$this->cityId = $wgCityId;
		foreach ($params['prop'] as $p) {
			switch ($p) {
				case 'variables':
					$this->appendVariables($p);
					break;
				case 'category':
					$this->appendCategory($p);
					break;
				case 'wikidesc':
					$this->appendWikidesc($p);
					break;
			}
		}
		parent::execute();
	}

	protected function appendWikidesc($property) {
		global $wgLanguageCode, $wgDBcluster;
		$result = $this->getResult();
		$lang_id = WikiFactory::LangCodeToId($wgLanguageCode);
		$cats = WikiFactory::getCategory($this->cityId);
		$oWiki = WikiFactory::getWikiByID($this->cityId);
		$cat_id = ( !emptY($cats) ) ? $cats->cat_id : 0;
		$data = array( 
			"langid" => $lang_id,
			"id" => $this->cityId,
			"catid" => $cat_id,
			"pagetitle" => wfMsg( 'pagetitle' ),
			"flags"	=> $oWiki->city_flags,
			"position" => ( isset($wgDBcluster) ) ? $wgDBcluster : $oWiki->city_cluster
		);
		$result->setIndexedTagName($data, $property);
		$result->addValue('query', $property, $data);
	}

	protected function appendVariables($property) {
		$data = array ();
		foreach ($this->variablesList as $id => $variableName) {
			$data[$id] = array( 'id' => $variableName );
			$value = (array_key_exists($variableName, $GLOBALS) && !is_null($GLOBALS[$variableName])) ? $GLOBALS[$variableName] : "";
			if ( is_array($value) ) {
				$loop = 0; foreach ($value as $key => $v) {
					$data[$id]["value".$loop] = array( 'id' => $key);
					ApiResult :: setContent( $data[$id]["value".$loop], $v );
					$loop++;
				}
			} else {
				ApiResult :: setContent( $data[$id], $value );
			}
		}

		$result = $this->getResult();
		$result->setIndexedTagName($data, $property);
		$result->addValue('query', $property, $data);
	}

	protected function appendCategory($property) {
		$oHub = WikiFactoryHub::getInstance();
		$catId = $oHub->getCategoryId($this->cityId);
		$catName = $oHub->getCategoryName($this->cityId);
		$data = array("catid" => $catId, "catname" => $catName);
		$result = $this->getResult();
		$result->setIndexedTagName($data, $property);
		$result->addValue('query', $property, $data);

	}
	
	public function getAllowedParams() {
		$params = parent::getAllowedParams();
		array_push($params['prop'][ApiBase::PARAM_TYPE],'category');
		array_push($params['prop'][ApiBase::PARAM_TYPE],'variables');
		array_push($params['prop'][ApiBase::PARAM_TYPE],'wikidesc');
		return $params;
	}

	public function getParamDescription() {
		$params = parent::getParamDescription();
		$params['prop'][] = ' "category"     - Returns name of category of selected Wikia';
		$params['prop'][] = ' "variables"    - Returns values of main global variables';
		$params['prop'][] = ' "wikidesc"     - Returns wiki description (such as Mediawiki:pagetitle)';
		return $params;
	}

	public function getDescription() {
		return 'Return general information about the site.';
	}

	protected function getExamples() {
		return array_merge(
				parent::getExamples(),
				array('api.php?action=query&meta=siteinfo&siprop=general|namespaces|statistics|variables|category|wikidesc')
		);
	}
}
