<?php
class SpecialCssController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('CSS', 'specialcss', true);
	}
	
	public function index() {
		wfProfileIn(__METHOD__);

		if( $this->checkPermissions() ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$this->response->addAsset('/extensions/wikia/SpecialCss/css/SpecialCss.scss');
		$this->response->addAsset('/extensions/wikia/SpecialCss/js/SpecialCss.js');
		// This shouldn't be moved to asset manager package because of Ace internal autoloader
		$this->response->addAsset('/resources/Ace/ace.js');

		$aceUrl = AssetsManager::getInstance()->getOneCommonURL('/resources/Ace');
		$aceUrlParts = parse_url($aceUrl);
		$this->wg->Out->addJsConfigVars([
			'aceScriptsPath' => $aceUrlParts['path']
		]);

		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );
		
		$model = new SpecialCssModel();
		$this->cssContent = $model->getCssFileContent();

		wfProfileOut(__METHOD__);
	}
	
	public function notOasis() {
		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );
	}
}
