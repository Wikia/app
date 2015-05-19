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
	public function getDataFromNodes( \SimpleXMLElement $xmlIterable ) {
		wfProfileIn(__METHOD__);
		$data = [ ];
		foreach ( $xmlIterable as $node ) {
			$nodeHandler = $this->getNode( $node );
			$nodeData = $nodeHandler->getData();
			if ( !$nodeHandler->isEmpty( $nodeData ) ) {
				$data[ ] = [
					'type' => $nodeHandler->getType(),
					'data' => $nodeData
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
		$data = $this->getDataFromNodes( $xml );

		wfProfileOut( __METHOD__ );
		return $data;
	}

	public function logXmlParseError( $level, $code, $message ) {
		\Wikia\Logger\WikiaLogger::instance()->info( "PortableInfobox XML Parser problem", [
			"level" => $level,
			"code" => $code,
			"message" => $message ] );
	}

	/**
	 * @param \SimpleXMLElement $xmlNode
	 * @return \Wikia\PortableInfobox\Parser\Nodes\Node
	 */
	public function getNode( \SimpleXMLElement $xmlNode ) {
		wfProfileIn(__METHOD__);
		$tagType = $xmlNode->getName();
		$className = 'Wikia\\PortableInfobox\\Parser\\Nodes\\' . 'Node' . ucfirst( strtolower( $tagType ) );
		if ( class_exists( $className ) ) {
			/* @var $instance \Wikia\PortableInfobox\Parser\Nodes\Node */
			$instance = new $className( $xmlNode, $this->infoboxData );
			if ( !empty( $this->externalParser ) ) {
				$instance->setExternalParser( $this->externalParser );
			}
			wfProfileOut(__METHOD__);
			return $instance;
		}
		wfProfileOut(__METHOD__);
		return new Nodes\NodeUnimplemented( $xmlNode, $this->infoboxData );
	}

}

class XmlMarkupParseErrorException extends \Exception {
}