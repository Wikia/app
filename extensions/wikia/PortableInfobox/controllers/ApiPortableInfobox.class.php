<?php

class ApiPortableInfobox extends ApiBase {

	public function __construct( $main, $action ) {
		parent:: __construct( $main, $action );
	}

	public function execute() {
		$text = $this->getParameter( "text" );
		$title = $this->getParameter( "title" );
		$arguments = $this->getFrameArguments();
		if ( $arguments === null ) {
			$this->getResult()->setWarning( "Arguments json format incorect or empty" );
		}
		$parser = new Parser();
		$parser->startExternalParse( Title::newFromText( $title ), new ParserOptions(), 'text', true );
		$frame = $parser->getPreprocessor()->newCustomFrame( $arguments );

		try {
			$output = PortableInfoboxParserTagController::getInstance()->render( $text, $parser, $frame );
			$this->getResult()->addValue( null, $this->getModuleName(), [ 'text' => [ '*' => $output ] ] );
		} catch ( \Wikia\PortableInfobox\Parser\Nodes\UnimplementedNodeException $e ) {
			$this->dieUsage( wfMessage( 'unimplemented-infobox-tag', [ $e->getMessage() ] )->escaped(), "notimplemented" );
		} catch ( \Wikia\PortableInfobox\Parser\XmlMarkupParseErrorException $e ) {
			$this->dieUsage( wfMessage( 'xml-parse-error' )->text(), "badxml" );
		}
	}

	public function getAllowedParams() {
		return array(
			'text' => array(
				ApiBase :: PARAM_TYPE => 'string'
			),
			'title' => array(
				ApiBase :: PARAM_TYPE => 'string'
			),
			'args' => array(
				ApiBase :: PARAM_TYPE => 'string'
			)
		);
	}

	public function getParamDescription() {
		return array(
			'text' => 'Infobox to parse (xml string)',
			'title' => 'Title of page the text belongs to',
			'args' => 'Variable list to use during parse (json format)',
		);
	}

	public function getDescription() {
		return array( 'This module provides infobox parser' );
	}

	/**
	 * Examples
	 */
	public function getExamples() {
		return array(
			'api.php?action=infobox',
			'api.php?action=infobox&text=<infobox><data><default>{{PAGENAME}}</default></data></infobox>&title=Test',
			'api.php?action=infobox&text=<infobox><data source="test" /></infobox>&args={"test": "test value"}',
		);
	}

	public function getVersion() {
		return __CLASS__ . '$Id$';
	}

	/**
	 * @return mixed
	 */
	protected function getFrameArguments() {
		$arguments = $this->getParameter( "args" );
		return isset( $arguments ) ? json_decode( $arguments, true ) : false;
	}

}