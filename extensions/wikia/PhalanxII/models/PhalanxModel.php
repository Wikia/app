<?php

abstract class PhalanxModel extends WikiaObject {
	protected $model = null;
	protected $text = "";
	protected $block = null;
	protected $lang = "";
	protected $user = null;
	private $service = null;

	public function __construct( $model, $data = array() ) {
		parent::__construct();
		$this->model = $model;
		if ( !empty( $data ) ) {
			foreach ( $data as $key => $value ) {
				$method = "set{$key}";
				$this->$method( $value );
			}
		}
		$this->service = new PhalanxService();
	}

	abstract public function isOk();

	public function __call($name, $args) {
		$method = substr($name, 0, 3);
		$key = strtolower( substr( $name, 3 ) );

		$result = null;
		switch($method) {
			case 'get':
				if ( isset( $this->$key ) ) {
					$result = $this->$key;
				}
				break;
			case 'set':
				$this->$key = $args[0];
				$result = $this;
				break;
		}
		return $result;
	}
	
	protected function fallback( $method, $type ) {
		$fallback = "{$method}_{$type}_old";
		$ret = false; 
		if ( method_exists( $this, $fallback ) ) {
			Wikia::log( __METHOD__, __LINE__, "Call method from previous version of Phalanx - check Phalanx service!\n" );
			$ret = call_user_func( array( $this, $fallback ) );
		}
		return $ret;
	}
	
	public function logBlock() { 
		Wikia::log( __METHOD__, __LINE__, "Block '#{$this->block->id}' blocked '{$this->getText()}'.\n" );
	}

	public function match( $type, $method = 'logBlock' ) {
		$ret = true;

		if ( !$this->isOk() ) {
			$isUser = isset( $this->user ) && ( $this->user->getName() == $this->wg->User->getName() );
			
			# send request to service
error_log( __METHOD__ . "( $type, {$this->getText()}, {$this->getLang()} )\n", 3, "/tmp/moli.log" );
error_log( __METHOD__ . ": service: " . print_r( $this->service, true ), 3, "/tmp/moli.log" );
			$result = $this->service
				->setLimit(1)
				->setUser( $isUser ? $this->user : null )
				->match( $type, $this->getText(), $this->getLang() );
error_log ( "result: ". print_r( $result, true ) . "\n", 3, "/tmp/moli.log" );
			if ( $result !== false ) {
				# we have response from Phalanx service - check block
				if ( is_object( $result ) && isset( $result->id ) && $result->id > 0 ) {
					$this->setBlock( $result )->$method();
					$ret = false;
				}
			} else {
				$ret = $this->fallback( "match", $type );
			}
		}

		return $ret;
	}

	public function check( $type ) {
		# send request to service 
		$result = $this->service->check( $type, $this->getText, $this->getLang() );
		
		if ( $result !== false ) {
			# we have response from Phalanx service - 0/1
			$ret = $result;
		} else {
			$ret = $this->fallback( "check", $type );
		}				

		return $ret;
	}
}
