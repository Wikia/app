<?php

abstract class PhalanxModel extends WikiaObject {
	protected $blockId = 0;
	protected $model = null;
	
	public function __construct( $model, $data = array() ) {
		parent::contruct();
		$this->model = $model;
		$oModel = F::build( $this->model );
		if ( !empty( $data ) ) {
			foreach ( $data as $key => $value ) {
				$oModel->setter( $key, $value );		
			}
		}
	}

	abstract public static function isOk();

	private function setter( $key, $val ) {
		$method = sprintf( "set%s", ucfirst( $key ) );
		if ( method_exists( $this, $method ) ) {
			$this->$method( $val );
		} 
	}
		
	public function getBlockId() {
		return $this->blockId;
	}
	
	public function setBlockId( $id ) {
		$this->blockId = ( int ) $id;
	}
}
