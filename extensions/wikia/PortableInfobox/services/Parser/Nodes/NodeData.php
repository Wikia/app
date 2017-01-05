<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeData extends Node {
	const COLLAPSE_ATTR_NAME = 'collapse';
	const COLLAPSE_CLOSED_OPTION = 'closed';

	private $supportedDataCollapses = [
		self::COLLAPSE_CLOSED_OPTION
	];

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [
				'collapse' => $this->getCollapse(),
				'label' => $this->getInnerValue( $this->xmlNode->{self::LABEL_TAG_NAME} ),
				'value' => $this->getValueWithDefault( $this->xmlNode )
			];
		}

		return $this->data;
	}

	protected function getCollapse() {
		$collapse = $this->getXmlAttribute( $this->xmlNode, self::COLLAPSE_ATTR_NAME );
		return ( isset( $collapse ) && in_array( $collapse, $this->supportedDataCollapses ) ) ? $collapse : null;
	}
}
