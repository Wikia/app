<?php
class SpecialCssController extends WikiaSpecialPageController {
	const CSS_FILE_NAME = 'Wikia.css';
	
	public function __construct() {
		parent::__construct('CSS', 'specialcss', true);
	}
	
	public function index() {
		wfProfileIn(__METHOD__);

		$this->response->addAsset('/extensions/wikia/SpecialCss/css/SpecialCss.scss');
		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );
		
		$this->cssContent = $this->getCssFileContent();

		wfProfileOut(__METHOD__);
	}

	protected function getCssFileContent() {
		$out = '';
		$cssTitle = Title::newFromText(self::CSS_FILE_NAME, NS_MEDIAWIKI);
		
		if( $cssTitle instanceof Title) {
			$cssArticle = Article::newFromID( $cssTitle->getArticleId() );
			$out = $cssArticle->getContent();
		}
		
		return $out;
	}
}