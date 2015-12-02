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

		/*
		This commented block is an another/alternative approach to the same problem. Potentially
		it is better because it parses wikitext in a way identical to how it is parser for article
		view - however it is not able to throw exception if the passed text is not a valid infobox.
		I'm keeping it here because I think it is a great approach and in the future I'm planning
		to create an separated API that uses this approach. - Inez Korczyński

		$fakeTemplate = 'FakeTemplate' . wfRandomString( 4 );
		$fakeTemplateTitle = Title::newFromText( $fakeTemplate, NS_TEMPLATE );

		$parametersWT = '';
		foreach( $arguments as $key => $value ) {
			$parametersWT .= '|' . $key . '=' . $value;
		}
		$callWT = '{{' . $fakeTemplate . $parametersWT . '}}';

		global $wgParser;
		$popts = ParserOptions::newFromContext( $this->getContext() );
		$popts->setTemplateCallback( function ( $title, $parser = false ) use ( $fakeTemplateTitle, $text ) {
			if ( $title->equals( $fakeTemplateTitle ) ) {
				return array( 'text' => $text );
			} else {
				return Parser::statelessFetchTemplate( $title, $parser );
			}
		} );
		$output = $wgParser->parse( $callWT, Title::newFromText( $title ), $popts )->getText();
		$this->getResult()->addValue( null, $this->getModuleName(), [ 'text' => [ '*' => $output ] ] );
		*/

		global $wgParser;
		$wgParser->firstCallInit();
		$wgParser->startExternalParse( Title::newFromText( $title ), ParserOptions::newFromContext( $this->getContext() ), Parser::OT_HTML, true );

		if ( is_array( $arguments ) ) {
			foreach( $arguments as $key => &$value ) {
				$value =  $wgParser->replaceVariables( $value );
			}
		}

		$frame = $wgParser->getPreprocessor()->newCustomFrame( $arguments );

		try {
			$output = PortableInfoboxParserTagController::getInstance()->render( $text, $wgParser, $frame );
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
