<?php

class Scribunto_LuaMessageLibrary extends Scribunto_LuaLibraryBase {
	function register() {
		$lib = array(
			'plain' => array( $this, 'messagePlain' ),
			'check' => array( $this, 'messageCheck' ),
		);

		// Get the correct default language from the parser
		if ( $this->getParser() ) {
			$lang = $this->getParser()->getTargetLanguage();
		} else {
			global $wgContLang;
			$lang = $wgContLang;
		}

		$this->getEngine()->registerInterface( 'mw.message.lua', $lib, array(
			'lang' => $lang->getCode(),
		) );
	}

	private function makeMessage( $data, $setParams ) {
		if ( isset( $data['rawMessage'] ) ) {
			$msg = new RawMessage( $data['rawMessage'] );
		} else {
			$msg = Message::newFallbackSequence( $data['keys'] );
		}
		$msg->inLanguage( $data['lang'] )
			->useDatabase( $data['useDB'] );
		if ( $setParams ) {
			$msg->params( array_values( $data['params'] ) );
		}
		return $msg;
	}

	function messagePlain( $data ) {
		try {
			$msg = $this->makeMessage( $data, true );
			return array( $msg->plain() );
		} catch( MWException $ex ) {
			throw new Scribunto_LuaError( "msg:plain() failed (" . $ex->getMessage() . ")" );
		}
	}

	function messageCheck( $what, $data ) {
		if ( !in_array( $what, array( 'exists', 'isBlank', 'isDisabled' ) ) ) {
			throw new Scribunto_LuaError( "invalid what for 'messageCheck'" );
		}

		try {
			$msg = $this->makeMessage( $data, false );
			return array( call_user_func( array( $msg, $what ) ) );
		} catch( MWException $ex ) {
			throw new Scribunto_LuaError( "msg:$what() failed (" . $ex->getMessage() . ")" );
		}
	}
}
