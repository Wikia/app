<?php
namespace Wikia\CollectionView\Parser;

interface ExternalParser {
	public function parse( $text );
}

class XmlParser {

	protected $externalParser;

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
	 * @return \Wikia\CollectionView\Parser\Nodes\Node
	 */
	public function getNode( \SimpleXMLElement $xmlNode ) {
		$tagType = $xmlNode->getName();
		$className = 'Wikia\\CollectionView\\Parser\\Nodes\\'.'Node' . ucfirst( strtolower( $tagType ) );
		if ( class_exists( $className ) ) {
			/* @var $instance \Wikia\CollectionView\Parser\Nodes\Node */
			$instance = new $className( $xmlNode );
			if ( !empty( $this->externalParser ) ) {
				$instance->setExternalParser( $this->externalParser );
			}
			return $instance;
		}
		return new Nodes\NodeUnimplemented( $xmlNode );
	}

}
