<?php

class CentralAuthAntiSpoofHooks extends AntiSpoofHooks {
	/**
	 * @param $name string Username
	 * @return CentralAuthAntiSpoofHooks
	 */
	protected static function makeSpoofUser( $name ) {
		return new CentralAuthSpoofUser( $name );
	}
}
