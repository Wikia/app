<?php
namespace Wikia\PortableInfobox\Parser;

class Parser {

	protected $infoboxData;

	public function __construct( $infoboxData ) {
		$this->infoboxData = $infoboxData;
	}

	/**
	 * @param \SimpleXMLElement $xmlIterable
	 * @return array
	 */
	public function getDataFromNodes( \SimpleXMLElement $xmlIterable ) {
		$data = [];
		foreach ( $xmlIterable as $node ) {
			$nodeHandler = $this->getNode( $node );
			$data[] = [
				'type' => $nodeHandler->getType(),
				'data' => $nodeHandler->getData()
			];
		}
		return $data;
	}

	/**
	 * @param \SimpleXMLElement $xmlNode
	 * @return \Wikia\PortableInfobox\Parser\Nodes\Node
	 */
	public function getNode( \SimpleXMLElement $xmlNode ) {
		$tagType = $xmlNode->getName();
		$className = 'Wikia\\PortableInfobox\\Parser\\Nodes\\'.'Node' . ucfirst( strtolower( $tagType ) );
		if ( class_exists( $className ) ) {
			return new $className( $xmlNode, $this->infoboxData );
		}
		return new Nodes\NodeUnimplemented( $xmlNode, $this->infoboxData );
	}
}
