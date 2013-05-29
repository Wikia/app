<?php
class SpecialCssModel extends WikiaModel {
	const CSS_FILE_NAME = 'Wikia.css';
	
	public function getCssFileName() {
		return self::CSS_FILE_NAME;
	}

	public function getCssFileContent() {
		wfProfileIn(__METHOD__);
		
		$out = '';
		$cssTitle = $this->getCssFileTitle();

		if( $cssTitle instanceof Title) {
			$cssArticle = $this->getCssFileArticle( $cssTitle->getArticleId() );
			$out = $cssArticle->getContent();
		}

		wfProfileOut(__METHOD__);
		return $out;
	}
	
	private function getCssFileTitle() {
		return Title::newFromText( $this->getCssFileName(), NS_MEDIAWIKI);
	}
	
	private function getCssFileArticle($articleId) {
		return Article::newFromID($articleId);
	}
}