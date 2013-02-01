<?php

abstract class PhalanxModel extends WikiaObject {
	protected $blockId = 0;
	protected $model = null;
	protected $text = "";
	private $service = null;
	
	public function __construct( $model, $data = array() ) {
		parent::contruct();
		$this->model = $model;
		if ( !empty( $data ) ) {
			foreach ( $data as $key => $value ) {
				$this->setter( $key, $value );		
			}
		}
		$this->service = F::build("PhalanxService");
	}

	abstract public function isOk();

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
		return $this;
	}
	
	public function setText( $text ) {
		$this->text = $text;
		return $this;
	}
	
	public function getText() {
		return $this->text;
	}

	public function logBlock() {
		Wikia::log( __METHOD__, __LINE__, "Block '#{$this->blockId}' blocked '{$this->text}'." );		
	}

	public function match( $type, $language = "en" ) {
		return $this->service->limit(1)->match( $type, $this->text, $language );
	}
	
	public function check( $type, $language = "en" ) {
		return $this->service->check( $type, $this->text, $language );		
	}
}
