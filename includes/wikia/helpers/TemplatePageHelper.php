<?php

/**
 * TemplatePageHelper
 *
 * @desc Helper class for Template pages
 * @author Matt Klucsarits <mattk@wikia-inc.com>
 */

class TemplatePageHelper {
	protected $parser;
	protected $parserOptions;
	protected $templateName;
	protected $title;

	/**
	 * Constructor
	 * @param Title|string Template title as a Title object or the article name (with or without namespace)
	 */
	function __construct__( $title = null ) {
		if ( $title instanceof Title ) {
			$this->setTemplateByTitle( $title );
		}
		elseif ( is_string( $title ) ) {
			$this->setTemplateByName( $title );
		}
	}

	/**
	 * Given a template article title, sets the template name and Title object used by the class instance
	 * @param string $title
	 */
	public function setTemplateByName( $title ) {
		$this->setTemplateByTitle( Title::newFromText( $title ) );
	}

	/**
	 * Given a Title object, sets the template name and Title object used by the class instance
	 * @param Title $titleObj
	 */
	public function setTemplateByTitle( Title $titleObj ) {
		$this->title = $titleObj;
		$this->templateName = $this->title->getText();
	}

	/**
	 * Access the Title object for the current template
	 * @return Title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Gets the Parser instance used by other methods in this class
	 * @return Parser
	 */
	protected function getParser() {
		if ( $this->parser === null ) {
			global $wgParser;

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
	 * Gets the resulting HTML from parsing the given wikitext using the given Title
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
