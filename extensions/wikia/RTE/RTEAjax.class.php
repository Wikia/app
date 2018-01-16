<?php

class RTEAjax {

	/**
	 * Perform wikitext parsing to HTML
	 */
	static public function wiki2html() {
		$wikitext = RequestContext::getMain()->getRequest()->getVal( 'wikitext', '' );

		RTE::log( __METHOD__, $wikitext );

		$ret = [
			'html' => RTE::WikitextToHtml( $wikitext ),
			'instanceId' => RTE::getInstanceId(),
		];

		if ( RTE::edgeCasesFound() ) {
			$ret = [
				'edgecase' => [
					'type' => RTE::getEdgeCaseType(),
					'info' => [
						'title' => wfMsg( 'rte-edgecase-info-title' ),
						'content' => wfMsg( 'rte-edgecase-info' ),
					],
				]
			];
		}

		return $ret;
	}

	/**
	 * Perform reverse parsing from HTML to wikitext
	 */
	static public function html2wiki() {
		global $wgRequest;
		$html = $wgRequest->getVal( 'html', '' );

		RTE::log( __METHOD__, $html );

		$wikitext = RTE::HtmlToWikitext( $html );

		return [
			'wikitext' => $wikitext,
		];
	}

	/**
	 * Check whether given page exists and return extra info about page (href and title attribute for link)
	 */
	static public function checkInternalLink() {
		global $wgTitle, $wgEnableWallEngine;

		$res = [ 'exists' => false ];

		if ( !empty( $wgTitle ) ) {
			// existing local URL or interwiki link
			$exists = $wgTitle->exists()
				|| $wgTitle->isSpecialPage()
				|| $wgTitle->isExternal()
				|| ( !empty( $wgEnableWallEngine ) && WallHelper::isWallNamespace( $wgTitle->getNamespace() ) );

			$res = [
				'exists' => $exists,
				'external' => $wgTitle->isExternal(),
				'href' => $wgTitle->getLocalUrl(),
				'title' => $exists ? $wgTitle->getPrefixedText() : wfMsg( 'red-link-title', $wgTitle->getPrefixedText() ),
			];
		}

		return $res;
	}

	/**
	 * Parse provided wikitext to HTML using MW parser
	 */
	static public function parse() {
		global $wgTitle, $wgRequest, $wgUser;

		$wikitext = $wgRequest->getVal( 'wikitext', '' );

		$parser = new Parser();
		$parserOptions = new ParserOptions();

		// call preSaveTransform so signatures, {{subst:foo}}, etc. will work
		$wikitext = $parser->preSaveTransform( $wikitext, $wgTitle, $wgUser, $parserOptions );

		// parse wikitext using MW parser
		$html = $parser->parse( $wikitext, $wgTitle, $parserOptions )->getText();

		$res = [
			'html' => $html,
		];

		return $res;
	}

	/**
	 * Parse provided wikitext to HTML using RTE parser
	 */
	static public function rteparse() {
		global $wgTitle, $wgRequest, $wgUser;

		$wikitext = $wgRequest->getVal( 'wikitext', '' );

		$parserOptions = new ParserOptions();
		// don't show [edit] link for sections
		$parserOptions->setEditSection( false );
		// disable headings numbering
		$parserOptions->setNumberHeadings( false );

		$parser = new RTEParser();

		// call preSaveTransform so signatures, {{subst:foo}}, etc. will work
		$wikitext = $parser->preSaveTransform( $wikitext, $wgTitle, $wgUser, $parserOptions );

		// parse wikitext using RTE parser
		$html = $parser->parse( $wikitext, $wgTitle, $parserOptions )->getText();

		$res = [
			'html' => $html,
		];

		return $res;
	}

	/**
	 * Get info about given wikitext with double brackets syntax (templates, magic words, parser functions)
	 */
	static public function resolveDoubleBrackets() {
		global $wgRequest, $wgTitle, $wgRDBData, $wgCityId;

		$templateHelper = new TemplatePageHelper();
		$wikitext = $wgRequest->getVal( 'wikitext', '' );
		$html = $templateHelper->getHtml( $wikitext, $wgTitle );
		$tcs = new TemplateClassificationService();

		// processing data from RDB mode
		if ( !is_array( $wgRDBData ) || !isset( $wgRDBData['type'] ) || $wgRDBData['type'] == 'error' ) {
			$out = [ 'type' => 'unknown' ];
		} else {
			if ( $wgRDBData['type'] == 'tpl' ) {
				$out = [];
				$out['title'] = $wgRDBData['title']->getPrefixedDBkey();
				$out['exists'] = $wgRDBData['title']->exists() ? true : false;

				if ( $out['exists'] ) {
					$templateHelper->setTemplateByTitle( $wgRDBData['title'] );
					$out['availableParams'] = $templateHelper->getTemplateParams();
					$out['templateType'] = $tcs->getType( $wgCityId, $wgRDBData['title']->getArticleID() );
				}

				// Get key and value for each argument
				for ( $argIndex = 0; $argIndex < $wgRDBData['args']->node->length; $argIndex++ ) {
					$argNode = new PPNode_DOM( $wgRDBData['args']->node->item( $argIndex ) );
					$argParts = $argNode->splitArg();

					$key = !empty($argParts['index']) ? $argParts['index'] : $argParts['name']->node->textContent;
					$valueNodes = $argParts['value']->getChildren();

					$value = "";

					// Loop through all children and concatenate their contents, parsing tags if necessary
					for ( $valueIndex = 0; $valueIndex < $valueNodes->node->length; $valueIndex++ ) {
						$valueNode = new PPNode_DOM( $valueNodes->node->item( $valueIndex ) );

						// Parse extension tags (BugId:43779)
						if ( $valueNode->node->nodeName == 'ext' ) {
							$extParts = $valueNode->splitExt();

							// Name and attr are required parameters, the others are optional.
							$value .= "<" .
								$extParts['name']->node->textContent .
								$extParts['attr']->node->textContent .
								">";

							if ( isset( $extParts['inner'] ) ) {
								$value .= $extParts['inner']->node->textContent;
							}

							if ( isset( $extParts['close'] ) ) {
								$value .= $extParts['close']->node->textContent;
							}
						} elseif ( $valueNode->node->nodeName === 'template' ) {
							$value .= self::getTemplateInvocationWikitext( $valueNode->node );
						} else { // Just use text content
							$value .= $valueNode->node->textContent;
						}

						$out['passedParams'][trim( $key )] = trim( $value );
					}
				}
			}

			$out['type'] = $wgRDBData['type'];
			$out['html'] = $html;
		}
		return $out;
	}

	static private function getTemplateInvocationWikitext( $templateNode ) {
		$xpath = new DOMXPath( $templateNode->ownerDocument );
		$templateTitle = $xpath->query( 'title', $templateNode )->item( 0 )->nodeValue;
		$templateParameters = $xpath->query( 'part', $templateNode );

		$wikitext = '{{' . $templateTitle;
		foreach ( $templateParameters as $param ) {
			$wikitext .= '|';
			for ( $i = 0; $i < $param->childNodes->length; $i++ ) {
				$paramChild = $param->childNodes->item( $i );

				if ( $paramChild->nodeName === 'value' ) {
					$wikitext .= self::getTemplateParamValueWikitext( $paramChild );
				} else {
					$wikitext .= $paramChild->textContent;
				}
			}
		}
		$wikitext .= '}}';

		return $wikitext;
	}

	static private function getTemplateParamValueWikitext( $paramValueNode ) {
		$wikitext = '';
		for ( $j = 0; $j < $paramValueNode->childNodes->length; $j++ ) {
			$paramValueChildNode = $paramValueNode->childNodes->item( $j );
			if ( $paramValueChildNode->nodeName === 'template' ) {
				$wikitext .= self::getTemplateInvocationWikitext( $paramValueChildNode );
			} else {
				$wikitext .= $paramValueChildNode->textContent;
			}
		}

		return $wikitext;
	}

	/**
	 * Get list of frequently used templates
	 */
	static public function getHotTemplates() {
		return RTE::getHotTemplates();
	}

	/**
	 * Get messages script (format specific to CKEditor)
	 */
	static public function getMessagesScript() {
		// code of requested language
		global $wgLang;
		$lang = $wgLang->getCode();

		// get CK messages array
		$messages = RTELang::getMessages( $lang );
		$js = "CKEDITOR.lang['{$lang}'] = " . json_encode( $messages ) . ';';

		return $js;
	}


	/**
	 * @deprecated
	 * Get localisation entry point
	 */
	static public function i18n() {
		$js = self::getMessagesScript();

		$ret = new AjaxResponse( $js );
		$ret->setContentType( 'application/x-javascript' );
		$ret->setCacheDuration( 86400 * 365 * 10 ); // 10 years

		return $ret;
	}
}
