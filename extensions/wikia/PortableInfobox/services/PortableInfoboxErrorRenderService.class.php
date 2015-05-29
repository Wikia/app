<?php

class PortableInfoboxErrorRenderService extends WikiaService {

	const XML_DEBUG_TEMPLATE = 'PortableInfoboxMarkupDebug.mustache';
	private $errorList = [];

	/* @var $templateEngine Wikia\Template\MustacheEngine */
	private $templateEngine;

	function __construct( $errorList ) {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/../templates' );
		$this->errorList = $errorList;
	}

	public function renderMarkupDebugView( $sourceCode ) {

		if ( count( $this->errorList ) ) {
			$error = array_values( $this->errorList )[0];

			$sourceCodeByLines = explode( "\n", ( $sourceCode ) );

			$templateData = [];
			$templateData['code'] = [];
			foreach ( $sourceCodeByLines as $i => $codeLine ) {
				$templateData['code'][] = [
					'line' => $i,
					'codeLine' => $codeLine,
					'error' => $i == $error->line -1 ? true : false
				];
			}
			$templateData['message'] = $this->getErrorMessage( $error );

			return $this->templateEngine->clearData()->setData( $templateData )->render( self::XML_DEBUG_TEMPLATE );

		}
		return false;
	}

	public function getErrorMessage( libXMLError $error ) {
		return 'msg: ' . $error->code;
	}

}