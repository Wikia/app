<?php

class SassSourceContextFactory {

	protected static $defaultContext;

	public static function getDefault() {
		global $IP;

		if ( self::$defaultContext === null ) {
			self::$defaultContext = new SassSourceContext($IP);
		}

		return self::$defaultContext;
	}

}