<?php

class RTEAjax {

	/**
	 * Perform wikitext parsing to HTML
	 */
	static public function wiki2html() {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$wikitext = $wgRequest->getVal('wikitext', '');

		RTE::log(__METHOD__, $wikitext);

		$ret = array(
			'html' => RTE::WikitextToHtml($wikitext),
			'instanceId' => RTE::getInstanceId(),
		);

		if (RTE::edgeCasesFound()) {
			$ret = array(
				'edgecase' => array(
					'type' => RTE::getEdgeCaseType(),
					'info' => array(
						'title' => wfMsg('rte-edgecase-info-title'),
						'content' => wfMsg('rte-edgecase-info'),
					),
				)
			);
		}

		wfProfileOut(__METHOD__);
		return $ret;
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
		global $wgTitle, $wgEnableWallEngine;
		wfProfileIn(__METHOD__);

		$res = array('exists' => false);

		if (!empty($wgTitle)) {
			// existing local URL or interwiki link
			$exists = $wgTitle->exists() || $wgTitle->isExternal() || ( !empty($wgEnableWallEngine) && WallHelper::isWallNamespace($wgTitle->getNamespace()) );

			$res = array(
				'exists' => $exists,
				'external' => $wgTitle->isExternal(),
				'href' => $wgTitle->getLocalUrl(),
				'title' => $exists ? $wgTitle->getPrefixedText() : wfMsg('red-link-title', $wgTitle->getPrefixedText()),
			);
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Parse provided wikitext to HTML using MW parser
	 */
	static public function parse() {
		global $wgTitle, $wgRequest, $wgUser;
		wfProfileIn(__METHOD__);

		$wikitext = $wgRequest->getVal('wikitext', '');

		$parser = new Parser();
		$parserOptions = new ParserOptions();

		// call preSaveTransform so signatures, {{subst:foo}}, etc. will work
		$wikitext = $parser->preSaveTransform($wikitext, $wgTitle, $wgUser, $parserOptions);

		// parse wikitext using MW parser
		$html = $parser->parse($wikitext, $wgTitle, $parserOptions)->getText();

		$res = array(
			'html' => $html,
		);

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Parse provided wikitext to HTML using RTE parser
	 */
	static public function rteparse() {
		global $wgTitle, $wgRequest, $wgUser;
		wfProfileIn(__METHOD__);

		$wikitext = $wgRequest->getVal('wikitext', '');

		$parserOptions = new ParserOptions();
		// don't show [edit] link for sections
		$parserOptions->setEditSection(false);
		// disable headings numbering
		$parserOptions->setNumberHeadings(false);

		$parser = new RTEParser();

		// call preSaveTransform so signatures, {{subst:foo}}, etc. will work
		$wikitext = $parser->preSaveTransform($wikitext, $wgTitle, $wgUser, $parserOptions);

		// parse wikitext using RTE parser
		$html = $parser->parse($wikitext, $wgTitle, $parserOptions)->getText();

		$res = array(
			'html' => $html,
		);

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Get info about given wikitext with double brackets syntax (templates, magic words, parser functions)
	 */
	static public function resolveDoubleBrackets() {
		global $wgRequest, $wgTitle, $wgRDBEnabled, $wgRDBData, $wgParser;

		// initialization of required objects and settings
		$wgParser->getstriplist(); //we need to create (unstub) this object, because of in_array($tagName, $stripList) in parser
		$parser = new Parser();
		//$parser->mDefaultStripList = $parser->mStripList = array();
		$parser->mTagHooks = &$wgParser->mTagHooks;
		$parser->mStripList = &$wgParser->mStripList;

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

	/**
	 * Get localisation
	 */
	static public function i18n() {
		// code of requested language
		global $wgLang;
		$lang = $wgLang->getCode();

		// get CK messages array
		$messages = RTELang::getMessages($lang);
		$js = "CKEDITOR.lang['{$lang}'] = " . json_encode($messages) . ';';

		$ret = new AjaxResponse($js);
		$ret->setContentType('application/x-javascript');
		$ret->setCacheDuration(86400 * 365 * 10); // 10 years

		return $ret;
	}
}
