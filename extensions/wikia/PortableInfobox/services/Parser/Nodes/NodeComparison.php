<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeComparison extends Node {

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getChildNodes() ];
		}

		return $this->data;
	}

	public function isEmpty() {
		$data = $this->getData();
		foreach ( $data[ 'value' ] as $group ) {
			if ( $group[ 'isEmpty' ] == false ) {
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
