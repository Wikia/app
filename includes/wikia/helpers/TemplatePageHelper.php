<?php

/**
 * TemplatePageHelper
 *
 * @desc Helper class for Template pages
 * @author Matt Klucsarits <mattk@wikia-inc.com>
 */

class TemplatePageHelper {
	const TEMPLATE_NAMESPACE = 'Template';

	protected $parser;
	protected $parserOptions;
	protected $templateName;
	protected $title;

	function __construct__( $template = null ) {
		if ( $template instanceof Title ) {
			$this->setTitle( $template );
		}
		elseif ( is_string( $template ) ) {
			$this->setTemplateName( $template );
		}
	}

	/**
	 * Given a template name, sets the template name and Title object used by the class instance
	 * @param string $templateName
	 */
	public function setTemplateName( $templateName ) {
		$this->templateName = $templateName;
		$this->title = Title::newFromText( self::TEMPLATE_NAMESPACE . ':' . $templateName );
	}

	/**
	 * Given a Title object, sets the template name and Title object used by the class instance
	 * @param Title $titleObj
	 */
	public function setTitle( Title $titleObj ) {
		$this->title = $titleObj;
		$this->templateName = $titleObj->getText();
	}

	/**
	 * Gets the Parser instance used by other methods in this class
	 * @return Parser
	 */
	protected function getParser() {
		if ( $this->parser === null ) {
			global $wgParser, $wgRDBEnabled;

			$wgParser->getstriplist(); //we need to create (unstub) this object, because of in_array($tagName, $stripList) in parser
			$this->parser = new Parser();
			$this->parser->mTagHooks = &$wgParser->mTagHooks;
			$this->parser->mStripList = &$wgParser->mStripList;
		}

		return $this->parser;
	}

	/**
	 * Gets the ParserOptions instance used by other methods in this class
	 * @return ParserOptions
	 */
	protected function getParserOptions() {
		if ( $this->parserOptions === null ) {
			$this->parserOptions = new ParserOptions();
			$this->parserOptions->setEditSection( false );
		}

		return $this->parserOptions;
	}

	/**
	 * Gets the resulting HTML from parsing the given wikitext and Title
	 * @param string $wikitext
	 * @param Title $titleObj
	 * @return string HTML markup
	 */
	public function getHtml( $wikitext, Title $titleObj ) {
		global $wgRDBEnabled;
		// parsing wikitext in RDB (resolve double backets) mode
		$wgRDBEnabled = true;
		return $this->getParser()->parse( $wikitext, $titleObj, $this->getParserOptions() )->getText();
	}

	/**
	 * Gets all available parameters for the current template
	 * @return array
	 */
	public function getTemplateParams() {
		global $wgRTETemplateParams;
		wfProfileIn(__METHOD__);

		$params = array();

		// Parser must first parse the template name as wikitext before the parameters can be extracted
		$this->getHtml( '{{' . $this->templateName . '}}', $this->title );
		$wgRTETemplateParams = true;
		$templateDom = $this->getParser()->getTemplateDom( $this->title );
		$wgRTETemplateParams = false;

		if ( $templateDom[0] ) {
			// BugId:982 - use xpath to find all <tplarg> nodes
			$xpath = $templateDom[0]->getXPath();

			// <tplarg><title>foo</title></tplarg>
			$nodes = $xpath->query('//tplarg/title');

			foreach ( $nodes as $node ) {
				// skip nested <tplarg> tags
				if ( $node->childNodes->length === 1 ) {
					$params[$node->textContent] = 1;
				}
			}
		}

		wfProfileOut(__METHOD__);
		return array_keys( $params );
	}
}
