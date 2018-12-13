<?php

namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeSection extends Node {
	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [
				'label' => $this->getInnerValue( $this->xmlNode->{self::LABEL_TAG_NAME} ),
				'value' => $this->getRenderDataForChildren(),
				'item-name' => $this->getItemName(),
			];
		}

		return $this->data;
	}

	protected function getChildNodes() {
		if ( !isset( $this->children ) ) {
			$this->children = [ ];
			foreach ( $this->xmlNode as $child ) {
				if ( !in_array( $child->getName(), [ 'section', 'panel', 'label' ] ) ) {
					$this->children[] = NodeFactory::newFromSimpleXml( $child, $this->infoboxData )
						->setExternalParser( $this->externalParser );
				}
			}
		}

		return $this->children;
	}
}
