<?php

/**
 * Nirvana Framework - Function wrapper (facade)
 *
 * @group nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 */
class WikiaFunctionWrapper {

	/**
	 * run function
	 * @param string $funcName
	 * @param array $funcArgs
	 */
	public function run( $funcName, $funcArgs ) {
		if( function_exists( $funcName ) ) {
			return call_user_func_array( $funcName, $funcArgs );
		}
		else {
			throw new WikiaException( "Call to undefined function $funcName" );
		}
	}

	public function __call( $funcName, $funcArgs ) {
		$funcName = ( 'wf' . ucfirst( $funcName ) );
		return $this->run( $funcName, $funcArgs );
	}

	/**
	 * wfProfileIn wrapper
	 * @see wfProfileIn
	 */
	public function profileIn( $method ) {
		wfProfileIn( $method );
	}

	/**
	 * wfProfileOut wrapper
	 * @see wfProfileOut
	 */
	public function profileOut( $method ) {
		wfProfileOut( $method );
	}

	/**
	 * wfGetDB wrapper
	 * @see wfGetDB
	 * @return DatabaseMysql
	 */
	public function &getDB( $db, $groups = array(), $wiki = false ) {
		return wfGetDB( $db, $groups, $wiki );
	}

	/**
	 * wfMsg wrapper
	 * @see wfMsg
	 */
	public function msg( $key) {
		return wfMsg( $key );
	}

	/**
	 * wfMsgExt
	 * @see wfMsgExt
	 */
	public function msgExt( $key, $options ) {
		return wfMsgExt( $key, $option );
	}

}
