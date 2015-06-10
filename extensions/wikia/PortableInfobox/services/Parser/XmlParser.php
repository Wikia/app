<?php
namespace Wikia\PortableInfobox\Parser;

class XmlParser {

	protected $infoboxData;
	protected $externalParser;

	public function __construct( $infoboxData ) {
		$this->infoboxData = $infoboxData;
	}

	/**
	 * @return mixed
	 */
	public function getExternalParser() {
		return $this->externalParser;
	}

	/**
	 * @param mixed $externalParser
	 */
	public function setExternalParser( ExternalParser $externalParser ) {
		$this->externalParser = $externalParser;
	}

	/**
	 * @param \SimpleXMLElement $xmlIterable
	 * @return array
	 */
	public function getDataFromNodes( \SimpleXMLElement $xmlIterable, $parentNode = null ) {
		wfProfileIn(__METHOD__);
		$data = [ ];
		foreach ( $xmlIterable as $node ) {
			$nodeHandler = Nodes\NodeFactory::newFromSimpleXml( $node, $this->infoboxData );
			if ( $this->getExternalParser() ) {
				$nodeHandler->setExternalParser( $this->getExternalParser() );
			}
			if ( $parentNode ) {
				$nodeHandler->setParent( $parentNode );
			}
			$nodeData = $nodeHandler->getData();
			// add data if node is not empty or - when node can not be ignored when empty
			if ( !$nodeHandler->isEmpty() || !$nodeHandler->ignoreNodeWhenEmpty() ) {
				$data[ ] = [
					'type' => $nodeHandler->getType(),
					'data' => $nodeData,
					'isEmpty' => $nodeHandler->isEmpty( $nodeData ),
					'source' => $nodeHandler->getSource()
				];
			}
		}
		wfProfileOut(__METHOD__);
		return $data;
	}

	/**
	 * @param $xmlString
	 * @return array
	 * @throws XmlMarkupParseErrorException
	 */
	public function getDataFromXmlString( $xmlString ) {
		wfProfileIn( __METHOD__ );

		$xml = $this->parseXmlString( $xmlString );
		$data = $this->getDataFromNodes( $xml );

		wfProfileOut( __METHOD__ );
		return $data;
	}

	public function getInfoboxParams( $xmlString ) {
		$xml = $this->parseXmlString( $xmlString );
		$result = [];
		foreach ( $xml->attributes() as $k => $v ) {
			$result[$k] = (string) $v;
		}
		return $result;
	}

	protected function logXmlParseError( $level, $code, $message ) {
		\Wikia\Logger\WikiaLogger::instance()->info( "PortableInfobox XML Parser problem", [
			"level" => $level,
			"code" => $code,
			"message" => $message ] );
	}

	/**
	 * @param $xmlString
	 * @return \SimpleXMLElement
	 * @throws XmlMarkupParseErrorException
	 */
	protected function parseXmlString( $xmlString ) {
		$global_libxml_setting = libxml_use_internal_errors();
		libxml_use_internal_errors( true );
		$xml = simplexml_load_string( $xmlString );
		$errors = libxml_get_errors();
		libxml_use_internal_errors( $global_libxml_setting );

		if ( $xml === false ) {
			foreach ( $errors as $xmlerror ) {
				$this->logXmlParseError( $xmlerror->level, $xmlerror->code, trim( $xmlerror->message ) );
			}
			libxml_clear_errors();
			throw new XmlMarkupParseErrorException();
		}
		return $xml;
	}

}

class XmlMarkupParseErrorException extends \Exception {
}
