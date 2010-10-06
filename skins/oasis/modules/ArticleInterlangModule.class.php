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
		$wgOut->addScript('<script src="'. $wgStylePath .'/oasis/js/Interlang.js"></script>');
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
			
			foreach($language_urls as $val) {

				// remove duplicates
				if (!in_array($val['href'], $lang_index)) {
					array_push($lang_index, $val['href']);
					
					$list[] = array(
							'href'  => $val['href'], 
							'name'  => $val['text'],
					);
				}
			}
		}
		
				
		if (!empty($list)) {
			$this->language_list = $list;
			if (count($this->language_list) >= $this->max_visible) {
				$this->enable_more = true;
			}
			
		}	
		wfProfileOut(__METHOD__);
	}
}