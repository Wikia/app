<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeInfobox extends Node {

	protected $params;

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getChildNodes() ];
		}

		return $this->data;
	}

	public function isEmpty() {
		$data = $this->getData();
		foreach ( $data[ 'value' ] as $item ) {
			if ( $item[ 'isEmpty' ] == false ) {
				return false;
			}
		}

		return true;
	}

	public function getParams() {
		if ( !isset( $this->params ) ) {
			$result = [ ];
			foreach ( $this->xmlNode->attributes() as $k => $v ) {
				$result[ $k ] = (string)$v;
			}
			$this->params = $result;
		}

		return $this->params;
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
