<?php
class SpecialCssController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('CSS', 'specialcss', true);
	}
	
	public function index() {
		wfProfileIn(__METHOD__);

		$this->response->addAsset('/extensions/wikia/SpecialCss/css/SpecialCss.scss');
		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );
		
		//FIXME: implement pulling Wikia.css content here (story: CON-127)
		$this->cssContent = '/* Css Content */';

		wfProfileOut(__METHOD__);
	}
}