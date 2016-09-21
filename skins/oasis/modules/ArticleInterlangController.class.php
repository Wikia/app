<?php
/**
 * Renders language link box below the article
 *
 * @author Bernhard Schmidt
 */

class ArticleInterlangController extends WikiaController {
	public function init() {
		if($this->app->getSkinTemplateObj()) {
			$this->language_urls = $this->app->getSkinTemplateObj()->data['language_urls'];
		} else {
			$this->language_urls = array();
		}
		$this->language_list = null;
	}
	
	public function executeIndex() {
		wfProfileIn(__METHOD__);
		$this->WidgetLanguages();
		wfProfileOut(__METHOD__);
	}

	function WidgetLanguages() {
		wfProfileIn( __METHOD__ );

		$request_language_urls = $this->request->getVal('request_language_urls');
		if(!empty($request_language_urls)) {
			$this->language_urls = $request_language_urls;
		}
		$language_urls = $this->language_urls;
		$langSortBy = array();
		// only display the interlang links if there are interlanguage links
		if(!empty($language_urls) && is_array($language_urls)) {
			$lang_index = array();
			
			// language order
			$langSortBy = array("interwiki-en" => 1, "interwiki-de" => 2, "interwiki-es" => 3, "interwiki-ru" => 4, "interwiki-pl" => 5, "interwiki-fr" => 6, "interwiki-it" => 7, "interwiki-pt" => 8);

			foreach($language_urls as $val) {
				if (!in_array($val['href'], $lang_index)) {
					if (!isset($langSortBy[$val["class"]])) {
						$langSortBy[$val["class"]] = true;
					}

					$langSortBy[$val["class"]] = array(
							'href'  => $val['href'],
							'name'  => $val['text'],
							'class'  => $val['class'],
					);
				}
			}
			//	ordering the languages
			foreach ($langSortBy as $key => $value) {
				 if (!is_array($value)) {
						unset($langSortBy[$key]);
				}
			}
		}
		if (!empty($langSortBy)) {
			$this->language_list = $langSortBy;
		}
		wfProfileOut(__METHOD__);
	}

	public static function onMakeGlobalVariablesScript(Array &$vars) {
		global $wgOut;
		$vars['wgArticleInterlangList'] = $wgOut->getLanguageLinks();
		return true;
	}
}
