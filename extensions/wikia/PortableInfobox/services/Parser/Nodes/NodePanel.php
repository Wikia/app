<?php


namespace Wikia\PortableInfobox\Parser\Nodes;

class NodePanel extends Node {
	const COLLAPSE_ATTR_NAME = 'collapse';
	const COLLAPSE_OPEN_OPTION = 'open';
	const COLLAPSE_CLOSED_OPTION = 'closed';

	private $supportedGroupCollapses = [
		self::COLLAPSE_OPEN_OPTION,
		self::COLLAPSE_CLOSED_OPTION
	];

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [
				'value' => $this->getRenderDataForChildren(),
				'collapse' => $this->getCollapse(),
				'item-name' => $this->getItemName(),
			];
		}

		return $this->data;
	}

	protected function getChildNodes() {
		if ( !isset( $this->children ) ) {
			$this->children = [ ];
			foreach ( $this->xmlNode as $child ) {
				if ( in_array( $child->getName(), [ 'header', 'section' ] ) ) {
					$this->children[] = NodeFactory::newFromSimpleXml( $child, $this->infoboxData )
						->setExternalParser( $this->externalParser );
				}
			}
		}

		return $this->children;
	}

	protected function getCollapse() {
		$collapse = $this->getXmlAttribute( $this->xmlNode, self::COLLAPSE_ATTR_NAME );
		return ( isset( $collapse ) && in_array( $collapse, $this->supportedGroupCollapses ) ) ? $collapse : null;
	}
}
