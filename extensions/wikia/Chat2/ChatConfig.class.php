<?php

class ChatConfig {

	// constants with config file sections
	const CHAT_DEVBOX_ENV = 'dev';
	const CHAT_PREVIEW_ENV = 'preview';
	const CHAT_VERIFY_ENV = 'verify';
	const CHAT_PRODUCTION_ENV = 'prod';

	const SERVER_TYPE_MAIN = 'Main';
	const SERVER_TYPE_API = 'Api';

	const VAR_SERVER_BASKET = 'wgChatServersBasket';
	const VAR_OPERATION_MODE = 'wgChatOperationMode';
	const CENTRAL_WIKI_ID = 177;

	private static $configData = array();

	public static function getMainServer() {
		return self::getServer( self::SERVER_TYPE_MAIN );
	}

	public static function getApiServer() {
		return self::getServer( self::SERVER_TYPE_API );
	}

	public static function getMainServersList() {
		return self::getServersList( self::SERVER_TYPE_MAIN );
	}

	private static function getServer( $type ) {
		global $wgCityId;

		$servers = self::getServersList( $type );
		$index = $wgCityId % count( $servers );

		list( $host, $port ) = explode( ':', $servers[$index], 2 );

		return [
			'host' => $host,
			'port' => $port,
			'serverId' => $index + 1,
		];
	}

	public static function getSecretToken() {
		return ChatConfig::getConfigValue( 'ChatCommunicationToken' );
	}

	private static function getServersList( $type ) {
		$servers = self::getConfigValue( $type . 'ChatServers' );

		return $servers[self::getServerBasket()];
	}

	public static function getPublicHost() {
		return self::getConfigValue( 'ChatHost' );
	}

	/**
	 * Get a configuration value. Returns false when not found.
	 *
	 * @param string $key Key
	 * @return mixed|false
	 */
	private static function getConfigValue( $key ) {
		global $wgWikiaEnvironment;

		if ( empty( self::$configData ) ) {
			$configDir = getenv( 'WIKIA_CONFIG_ROOT' );
			$configFile = $configDir . '/ChatConfig.json';
			$jsonConfig = file_get_contents( $configFile );
			self::$configData = json_decode( $jsonConfig, true );
		}

		if ( empty( self::$configData ) ) {
			return false;
		}

		$env = $wgWikiaEnvironment;
		if ( isset( self::$configData[$env][$key] ) ) {
			return self::$configData[$env][$key];
		}

		if ( isset( self::$configData[$key] ) ) {
			return self::$configData[$key];
		}

		return false;
	}

	/**
	 * $mode - true = operation, false = failover
	 */
	public static function changeMode( $mode = true ) {
		if ( self::getMode() == false ) { // just promote server to operation mode
			self::setMode( true );

			return true;
		}

		$basket = self::getServerBasket();
		self::setServerBasket( ( $basket ) % 2 + 1 );
		self::setMode( false );

		return false;
	}

	public static function getMode() {
		$mode = WikiFactory::getVarValueByName( self::VAR_OPERATION_MODE, self::CENTRAL_WIKI_ID );
		if ( is_null( $mode ) ) {
			return true;
		}

		return $mode;
	}

	public static function setMode( $mode ) {
		WikiFactory::setVarByName( self::VAR_OPERATION_MODE, self::CENTRAL_WIKI_ID, $mode );
	}

	public static function getServerBasket() {
		$basket = WikiFactory::getVarValueByName( self::VAR_SERVER_BASKET, self::CENTRAL_WIKI_ID );
		if ( empty( $basket ) ) {
			return 1;
		}

		return $basket;
	}

	public static function setServerBasket( $basket ) {
		WikiFactory::setVarByName( self::VAR_SERVER_BASKET, self::CENTRAL_WIKI_ID, $basket );
	}

}