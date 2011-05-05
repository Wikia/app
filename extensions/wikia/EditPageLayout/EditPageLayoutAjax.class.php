<?php

class EditPageLayoutAjax {

	/**
	 * Perform reverse parsing on given HTML (when needed)
	 */
	static private function resolveWikitext($content, $mode, $page, $method, $section ) {
		global $wgRequest, $wgTitle;
		wfProfileIn(__METHOD__);
		if(class_exists($page)) {
			$pageObj = new $page();
			if(is_a( $pageObj, 'SpecialCustomEditPage' )) {
				$wikitext = $pageObj->getWikitextFromRequestForPreview($wgRequest->getVal('title', 'empty'));
				$service = new EditPageService($wgTitle);
				$html = $pageObj->getOwnPreviewDiff($wikitext, $method);
				
				if($html === false ) {
					$html = '';
					if($method == 'preview') {
						$html = $service->getPreview($wikitext);
					} elseif($method == 'diff') {
						$html = $service->getDiff($wikitext, $section);	
					}
				}
				
				$res = array(
					'html' => $html
				);
				
				wfProfileOut(__METHOD__);
				return $res;
			}			
		}
		wfProfileOut(__METHOD__);
		return array( 'html' => '' );
	}
	
	/**
	 * pass request to resolveWikitext
	 */
	static private function resolveWikitextFromRequest( $method ) {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$content = $wgRequest->getVal('content', '');
		$mode = $wgRequest->getVal('mode', '');
		$page = $wgRequest->getVal('page', '');
		$section = $wgRequest->getInt('section', 0);
		
		$wikitext = self::resolveWikitext($content, $mode, $page, $method, $section);
		wfProfileOut(__METHOD__);
		return $wikitext;
	}

	/**
	 * Parse provided wikitext to HTML using MW parser
	 */
	static public function preview() {
		wfProfileIn(__METHOD__);

		$res = self::resolveWikitextFromRequest('preview');
		
		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Render diff between the latest version of an article and given wikitext
	 */
	static public function diff() {
		global $wgRequest, $wgTitle;
		wfProfileIn(__METHOD__);

		$res = self::resolveWikitextFromRequest('diff');

		wfProfileOut(__METHOD__);
		return $res;
	}
}
