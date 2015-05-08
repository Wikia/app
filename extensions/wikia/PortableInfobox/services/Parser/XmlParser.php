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
			$data[ ] = [
				'type' => $nodeHandler->getType(),
				'data' => $nodeData,
				'isEmpty' => $nodeHandler->isEmpty( $nodeData )
			];
		}
		wfProfileOut(__METHOD__);
		return $data;
	}

	/**
	 * @param $xml String
	 * @return array
	 */
	public function getDataFromXmlString( $xml ) {
		wfProfileIn( __METHOD__ );
		$xml = simplexml_load_string( $xml );
		$data = $this->getDataFromNodes( $xml );
		wfProfileOut( __METHOD__ );
		return $data;
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
