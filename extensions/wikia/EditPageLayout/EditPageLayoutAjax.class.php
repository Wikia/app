<?php

class EditPageLayoutAjax {

	/**
	 * Perform reverse parsing on given HTML (when needed)
	 */
	static private function resolveWikitext($content, $mode) {
		if ($mode == 'wysiwyg') {
			$reverseParser = new RTEReverseParser();
			$wikitext = $reverseParser->parse($content);
		}
		else {
			$wikitext = $content;
		}

		return $wikitext;
	}

	/**
	 * Parse provided wikitext to HTML using MW parser
	 */
	static public function preview() {
		global $wgTitle, $wgRequest;
		wfProfileIn(__METHOD__);

		$service = new EditPageService($wgTitle);

		$content = $wgRequest->getVal('content', '');
		$mode = $wgRequest->getVal('mode', '');

		$wikitext = self::resolveWikitext($content, $mode);

		$res = array(
			'html' => $service->getPreview($wikitext),
		);

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Render diff between the latest version of an article and given wikitext
	 */
	static public function diff() {
		global $wgTitle, $wgRequest, $wgOut;
		wfProfileIn(__METHOD__);

		$service = new EditPageService($wgTitle);

		$content = $wgRequest->getVal('content', '');
		$mode = $wgRequest->getVal('mode', '');
		$section = $wgRequest->getInt('section');

		$wikitext = self::resolveWikitext($content, $mode);

		$res = array(
			'html' => $service->getDiff($wikitext, $section),
		);

		wfProfileOut(__METHOD__);
		return $res;
	}
}
