<?php

abstract class PhalanxModel extends WikiaObject {
	protected $blockId = 0;
	protected $model = null;
	protected $text = "";
	
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
	
	public function setText( $text ) {
		$this->text = $text;
	}
	
	public function getText() {
		return $this->text;
	}

	public function logBlock() {
		Wikia::log( __METHOD__, __LINE__, "Block '#{$this->blockId}' blocked '{$this->text}'." );		
	}

	public function match( $type, $language = "en" ) {
		return PhalanxService::match( $type, $this->text, $language );
	}
	
	public function check( $type, $language = "en" ) {
		return PhalanxService::check( $type, $this->text, $language );		
	}
}
