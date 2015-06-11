<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeSet extends Node {

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getDataForChildren() ];
		}

		return $this->data;
	}

	public function getRenderData() {
		return [
			'type' => $this->getType(),
			'data' => [
				'value' => array_map( function ( Node $item ) {
					return $item->getRenderData();
				}, $this->getChildNodes() ) ],
			'isEmpty' => $this->isEmpty(),
			'source' => $this->getSource()
		];
	}

	public function isEmpty() {
		/** @var Node $item */
		foreach ( $this->getChildNodes() as $item ) {
			if ( !$item->isType( 'header' ) && !$item->isEmpty() ) {
				return false;
			}
		}

		return true;
	}

	public function getSource() {
		return $this->getSourceForChildren();
	}
}
