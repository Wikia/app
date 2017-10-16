<?php

class ChatConfig {

	public static function getPublicHost() {
		global $wgWikiaEnvironment, $wgChatPublicHost, $wgChatPublicHostOverride;

		if ( !empty( $wgChatPublicHostOverride ) ) {
			return $wgChatPublicHostOverride;
		}

		return ( $wgWikiaEnvironment === WIKIA_ENV_PROD ? '' : $wgWikiaEnvironment . '-' ) . $wgChatPublicHost;
	}

	public static function getApiServer() {
		global $wgWikiaEnvironment, $wgChatPrivateServerOverride;

		if ( !empty( $wgChatPrivateServerOverride ) ) {
			return $wgChatPrivateServerOverride;
		}

		$consul = new Wikia\Consul\Client();
		$serverNodes = $consul->getNodes( 'chat-private', $wgWikiaEnvironment );

		$index = rand( 0, count( $serverNodes ) - 1 );

		return $serverNodes[ $index ];
	}

	public static function getSecretToken() {
		global $wgChatCommunicationToken;

		return $wgChatCommunicationToken;
	}

}
