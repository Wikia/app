<?php

class PortableInfoboxErrorRenderService extends WikiaService {

	const XML_DEBUG_TEMPLATE = 'PortableInfoboxMarkupDebug.mustache';
	const XML_ERR_GENERAL = 'xml-parse-error';

	private $errorList = [];

	// For full list of possible errors, see:
	// http://www.xmlsoft.org/html/libxml-xmlerror.html#xmlParserErrors
	private $supportedErrors = [
		5 => 'XML_ERR_DOCUMENT_END',
		26 => 'XML_ERR_UNDECLARED_ENTITY',
		39 => 'XML_ERR_ATTRIBUTE_NOT_STARTED',
		41 => 'XML_ERR_ATTRIBUTE_WITHOUT_VALUE',
		65 => 'XML_ERR_SPACE_REQUIRED',
		68 => 'XML_ERR_NAME_REQUIRED',
		73 => 'XML_ERR_GT_REQUIRED',
		76 => 'XML_ERR_TAG_NAME_MISMATCH',
		77 => 'XML_ERR_TAG_NOT_FINISHED'
	];

	/* @var $templateEngine Wikia\Template\MustacheEngine */
	private $templateEngine;

	function __construct( $errorList ) {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/../templates' );
		$this->errorList = $errorList;
	}

	public function renderMarkupDebugView( $sourceCode ) {
		if ( count( $this->errorList ) ) {

			$templateData = [];
			$templateData['code'] = $this->getLinesWithErrors( $sourceCode );
			$templateData['info'] = wfMessage( 'portable-infobox-xml-parse-error-info' )->escaped();
			return $this->templateEngine->clearData()->setData( $templateData )->render( self::XML_DEBUG_TEMPLATE );
		}
		return false;
	}

	protected function getLinesWithErrors( $sourceCode ) {
		$lines = [];

		$errorsByLine = $this->getErrorsByLine( $this->errorList );
		$sourceCodeByLines = explode( "\n", ( $sourceCode ) );

		foreach ( $sourceCodeByLines as $i => $codeLine ) {
			$line = [
				'line' => $i,
				'codeLine' => $codeLine,
				'error' => false,
			];
			if ( isset( $errorsByLine[ $i ] ) ) {
				$line['error'] = true;
				foreach ( $errorsByLine[ $i ] as $error ) {
					$line['error_messages'][] = [ 'message' => $this->getErrorMessage( $error ) ];
				}
			}
			$lines[] = $line;
		}
		return $lines;
	}

	protected function getErrorsByLine( $errorList ) {
		$errorsByLine = [];
		foreach ( $errorList as $error ) {
			$errorsByLine[ $error->line - 1 ][ $error->code ] = $error;
		}
		return $errorsByLine;
	}

	public function renderArticleMsgView() {
		return wfMessage( 'portable-infobox-xml-parse-error-info' )->escaped();
	}

	public function getErrorMessage( libXMLError $error ) {
		if ( isset( $this->supportedErrors[ $error->code ] ) ) {
			$key = $this->supportedErrors[ $error->code ];
		} else {
			$key = self::XML_ERR_GENERAL;
		}
		return wfMessage( $this->convertConstNameToMsgKey( $key ) )->escaped();
	}

	private function convertConstNameToMsgKey( $name ) {
		$msg = str_replace( 'XML_ERR', 'xml_parse_error', $name );
		$msg = str_replace( '_', '-', strtolower( $msg ) );
		return 'portable-infobox-' . $msg;
	}

}