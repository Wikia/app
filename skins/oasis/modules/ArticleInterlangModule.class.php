<?php
/**
 * Renders language link box below the article
 *
 * @author Bernhard Schmidt
 */

class ArticleInterlangModule extends Module {
	var $language_urls;
	var $language_list;
	var $enable_more;
	var $max_visible = 3; /** max languages which are visible, for all languages, click "see all >" **/
	var $request_all = false;
	
	
	public function executeIndex() {
		global $wgOut, $wgStylePath;
		// moved to static chuke
		//$wgOut->addScript('<script src="'. $wgStylePath .'/oasis/js/Interlang.js"></script>');
		wfProfileIn(__METHOD__);
		$this->WidgetLanguages();
		
		wfProfileOut(__METHOD__);
	}
	
	function WidgetLanguages() {
		wfProfileIn( __METHOD__ );
		global $wgUser, $wgRequest;
		
		if (!empty($wgRequest->data["interlang"])) {
			
			$this->request_all =  ($wgRequest->data["interlang"] == 'all') ? true: false;
		}
		
		$language_urls = $this->language_urls;
		
		// only display the interlang links if there are interlanguage links
		if(!empty($language_urls) && is_array($language_urls)) {
			$lang_index = array();
			
			// language order
			$this->langSortBy = array("interwiki-en" => 1, "interwiki-de" => 2, "interwiki-es" => 3, "interwiki-ru" => 4, "interwiki-pl" => 5, "interwiki-fr" => 6, "interwiki-it" => 7, "interwiki-pt" => 8);
			
			
			
			foreach($language_urls as $val) {
				if (!in_array($val['href'], $lang_index)) {
					if (!isset($this->langSortBy[$val["class"]])) {
						$this->langSortBy[$val["class"]] = true;
					}	
					
					$this->langSortBy[$val["class"]] = array(
							'href'  => $val['href'], 
							'name'  => $val['text'],
							'class'  => $val['class'],
					);
					
				}
			}
			//	ordering the languages
			foreach ($this->langSortBy as $key => $value) {
				 if (!is_array($value)) {
						unset($this->langSortBy[$key]);
				}	
			}		
		}
		
		if (!empty($this->langSortBy)) {
			$this->language_list = $this->langSortBy;
			
			if (count($this->language_list) >= $this->max_visible) {
				$this->enable_more = true;
			}
			
		}	
		
		wfProfileOut(__METHOD__);
	}
	
	static function languageSorting($a, $b) {
		strcmp($a["class"], $b["class"]); 
	}
}