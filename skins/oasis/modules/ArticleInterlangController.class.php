<?php
/**
 * Renders language link box below the article
 *
 * @author Bernhard Schmidt
 */

class ArticleInterlangController extends WikiaService {
	public function init() {
		if($this->app->getSkinTemplateObj()) {
			$this->language_urls = $this->app->getSkinTemplateObj()->data['language_urls'] ?: [];
		} else {
			$this->language_urls = [];
		}
		$this->languageList = null;
	}

	public function executeIndex() {
		$this->widgetLanguages();
	}

	private function widgetLanguages() {
		$requestLanguageUrls = $this->request->getVal('request_language_urls');
		if(!empty($requestLanguageUrls)) {
			$this->language_urls = $requestLanguageUrls;
		}
		$languageUrls = $this->language_urls;
		$languages = [];

		foreach ( $languageUrls as $lang) {
			$languages[$lang['lang']] = [
				'href' => $lang['href'],
				'name' => $lang['text'],
				'class'  => $lang['class'],
			];
		}

		ksort( $languages );
		$this->languageList = $languages;
	}

	public static function onMakeGlobalVariablesScript(Array &$vars) {
		global $wgOut;
		$vars['wgArticleInterlangList'] = $wgOut->getLanguageLinks();
		return true;
	}
}
