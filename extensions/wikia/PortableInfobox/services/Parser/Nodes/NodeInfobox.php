<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeInfobox extends Node {

	protected $params;

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getDataForChildren() ];
		}

		return $this->data;
	}

	public function getRenderData() {
		return array_map( function ( Node $item ) {
			return $item->getRenderData();
		}, array_filter( $this->getChildNodes(), function ( Node $item ) {
			return !$item->isEmpty();
		} ) );
	}

	public function isEmpty() {
		/** @var Node $child */
		foreach ( $this->getChildNodes() as $child ) {
			if ( !$child->isEmpty() ) {
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
