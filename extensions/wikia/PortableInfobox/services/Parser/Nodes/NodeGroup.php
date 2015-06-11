<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeGroup extends Node {

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getDataForChildren() ];
		}

		return $this->data;
	}

	public function getRenderData() {
		return [
			'type' => $this->getType(),
			'data' => [ 'value' => $this->getRenderDataForChildren() ],
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
		$data = $this->getData();
		$result = [ ];
		foreach ( $data[ 'value' ] as $item ) {
			if ( isset( $item[ 'source' ] ) ) {
				$source = !is_array( $item[ 'source' ] ) ? [ $item[ 'source' ] ] : $item[ 'source' ];
				$result = array_merge( $result, $source );
			}
		}

		return array_unique( $result );
	}
}
