<?php

class RTEAjax {

	/**
	 * Perform wikitext parsing to HTML
	 */
	static public function wiki2html() {
		global $wgRequest;
		$wikitext = $wgRequest->getVal('wikitext', '');

		RTE::log(__METHOD__, $wikitext);

		$html = RTE::WikitextToHtml($wikitext);

		return array(
			'html' => $html,
			'edgecases' => RTE::edgeCasesFound()
		);
	}

	/**
	 * Perform reverse parsing from HTML to wikitext
	 */
	static public function html2wiki() {
		global $wgRequest;
		$html = $wgRequest->getVal('html', '');

		RTE::log(__METHOD__, $html);

		$wikitext = RTE::HtmlToWikitext($html);

		return array(
			'wikitext' => $wikitext,
		);
	}

	/**
	 * Check whether given page exists and return extra info about page (href and title attribute for link)
	 */
	static public function checkInternalLink() {
		global $wgTitle;

		$res = array('exists' => false);

		if (!empty($wgTitle)) {
			$res = array(
				'exists' => $wgTitle->exists(),
				'href' => $wgTitle->getLocalUrl(),
				'title' => ( $wgTitle->exists() ? $wgTitle->getPrefixedText() : wfMsg('red-link-title', $wgTitle->getPrefixedText()) ),
			);
		}

		return $res;
	}

	/**
	 * Parse provided wikitext to HTML using MW parser
	 */
	static public function parse() {
		global $wgTitle, $wgRequest, $wgUser;

		$wikitext = $wgRequest->getVal('wikitext', '');

		$parser = new Parser();
		$parserOptions = new ParserOptions();

		// call preSaveTransform so signatures, {{subst:foo}}, etc. will work
		$wikitext = $parser->preSaveTransform($wikitext, $wgTitle, $wgUser, $parserOptions);

		// parse wikitext using MW parser
		$html = $parser->parse($wikitext, $wgTitle, $parserOptions)->getText();

		return array(
			'html' => $html,
		);
	}

	/**
	 * Parse provided wikitext to HTML using RTE parser
	 */
	static public function rteparse() {
		global $wgTitle, $wgRequest, $wgUser;

		$wikitext = $wgRequest->getVal('wikitext', '');

		$parser = new RTEParser();
		$parserOptions = new ParserOptions();

		// call preSaveTransform so signatures, {{subst:foo}}, etc. will work
		$wikitext = $parser->preSaveTransform($wikitext, $wgTitle, $wgUser, $parserOptions);

		// parse wikitext using RTE parser
		$html = $parser->parse($wikitext, $wgTitle, $parserOptions)->getText();

		return array(
			'html' => $html,
		);
	}

	/**
	 * Get info about given wikitext with double brackets syntax (templates, magic words, parser functions)
	 */
	static public function resolveDoubleBrackets() {
		global $wgRequest, $wgTitle, $wgRDBEnabled, $wgRDBData;

		// initialization of required objects and settings
		$parser = new Parser();
		$parser->mDefaultStripList = $parser->mStripList = array();
		$parserOptions = new ParserOptions();
		$parserOptions->setEditSection(false);

		// parsing wikitext in RDB (resolve double backets) mode
		$wgRDBEnabled = true;
		$wikitext = $wgRequest->getVal('wikitext', '');
		$html = $parser->parse($wikitext, $wgTitle, $parserOptions)->getText();

		// processing data from RDB mode
		if(!is_array($wgRDBData) || !isset($wgRDBData['type']) || $wgRDBData['type'] == 'error') {
			$out = array('type' => 'unknown');
		} else {
			if($wgRDBData['type'] == 'tpl') {
				$out = array();
				$out['title'] = $wgRDBData['title']->getPrefixedDBkey();
				$out['exists'] = $wgRDBData['title']->exists() ? true : false;
				if($out['exists']) {
					$out['availableParams'] = RTE::getTemplateParams($wgRDBData['title'], $parser);
				}
				for($i = 0; $i < $wgRDBData['args']->node->length; $i++) {
					$arg = new PPNode_DOM($wgRDBData['args']->node->item($i));
					$argSplited = $arg->splitArg();
					$key = !empty($argSplited['index']) ? $argSplited['index'] : $argSplited['name']->node->textContent;
					$value = $argSplited['value']->node->textContent;
					$out['passedParams'][ trim($key) ] = trim($value);
				}
			}
			$out['type'] = $wgRDBData['type'];
			$out['html'] = $html;
		}
		return $out;
	}

	/**
	 * Get list of frequently used templates
	 */
	static public function getHotTemplates() {
		return RTE::getHotTemplates();
	}
}
