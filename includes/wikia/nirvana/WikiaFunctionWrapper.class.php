<?php

/**
 * Nirvana Framework - Function wrapper (facade)
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 *
 * //helpers for PHP Lint
 * @method MsgForContent
 * @method Message Message
 * @method LoadExtensionMessages
 * @method RenderModule
 * @method RunHooks
 * @method LocalFile FindFile
 * @method ReplaceImageServer
 * @method BlankImgUrl
 * @method memcKey
 * @method sharedMemcKey
 * @method PaginateArray
 * @method debug
 * @method ReadOnly
 * @method Timestamp
 * @method TimestampNow
 *
 * @deprecated
 */
class WikiaFunctionWrapper {

	/**
	 * run function
	 * @param string $funcName
	 * @param array $funcArgs
	 * @deprecated
	 */
	public function run( $funcName, $funcArgs ) {
		if( is_callable( $funcName ) ) {
			return call_user_func_array( $funcName, $funcArgs );
		}
		else {
			throw new WikiaException( "Call to undefined function $funcName" );
		}
	}

	/**
	 * @param $funcName
	 * @param $funcArgs
	 * @return mixed
	 * @deprecated
	 */
	public function __call( $funcName, $funcArgs ) {
		$funcName = ( 'wf' . ucfirst( $funcName ) );
		return call_user_func_array( $funcName, $funcArgs );
	}

	/**
	 * wfProfileIn wrapper
	 * @see wfProfileIn
	 * @deprecated
	 */
	public function profileIn( $method ) {
		wfProfileIn( $method );
	}

	/**
	 * wfProfileOut wrapper
	 * @see wfProfileOut
	 * @deprecated
	 */
	public function profileOut( $method ) {
		wfProfileOut( $method );
	}

	/**
	 * wfGetDB wrapper
	 * @see wfGetDB
	 * @return DatabaseMysqli
	 * @deprecated
	 */
	public function &getDB( $db, $groups = array(), $wiki = false ) {
		return wfGetDB( $db, $groups, $wiki );
	}

	/**
	 * wfMsg wrapper
	 * @see wfMsg
	 * @deprecated
	 */
	public function msg( $key ) {
		$args = func_get_args();
		array_shift( $args );
		return wfMsgReal( $key, $args, true );
	}

	/**
	 * wfMsgExt
	 * @see wfMsgExt
	 * @deprecated
	 */
	public function msgExt( $key, $options ) {
		$args = func_get_args();
		array_shift( $args );
		array_shift( $args );
		return wfMsgExt( $key, $options, $args );
	}

}
