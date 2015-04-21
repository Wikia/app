<?php
namespace Wikia\PortableInfobox\Parser;

//interface moved here, because of $wgAutoloadClass issue
interface ExternalParser {
	public function parse( $text );
	public function parseRecursive( $text );
}

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
		$data = [];
		foreach ( $xmlIterable as $node ) {
			$nodeHandler = $this->getNode( $node );
			$nodeData = $nodeHandler->getData();
			$data[] = [
				'type' => $nodeHandler->getType(),
				'data' => $nodeData,
				'isEmpty' => $nodeHandler->isEmpty( $nodeData )
			];
		}
		return $data;
	}

	/**
	 * @param $xml String
	 * @return array
	 */
	public function getDataFromXmlString( $xml ) {
		$xml = simplexml_load_string( $xml );
		return $this->getDataFromNodes( $xml );
	}

	/**
	 * @param \SimpleXMLElement $xmlNode
	 * @return \Wikia\PortableInfobox\Parser\Nodes\Node
	 */
	public function getNode( \SimpleXMLElement $xmlNode ) {
		$tagType = $xmlNode->getName();
		$className = 'Wikia\\PortableInfobox\\Parser\\Nodes\\'.'Node' . ucfirst( strtolower( $tagType ) );
		if ( class_exists( $className ) ) {
			/* @var $instance \Wikia\PortableInfobox\Parser\Nodes\Node */
			$instance = new $className( $xmlNode, $this->infoboxData );
			if ( !empty( $this->externalParser ) ) {
				$instance->setExternalParser( $this->externalParser );
			}
			return $instance;
		}
		return new Nodes\NodeUnimplemented( $xmlNode, $this->infoboxData );
	}

}
