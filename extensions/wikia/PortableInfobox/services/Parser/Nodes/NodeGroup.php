<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeGroup extends Node {

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getChildNodes() ];
		}

		return $this->data;
	}

	public function isEmpty() {
		$data = $this->getData();
		foreach ( $data[ 'value' ] as $elem ) {
			if ( $elem[ 'type' ] != 'header' && !( $elem[ 'isEmpty' ] ) ) {
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
