<?php

class ChatConfig {

	public static function getApiServer() {
		global $wgWikiaEnvironment, $wgChatPrivateServerOverride;

		if ( !empty( $wgChatPrivateServerOverride ) ) {
			return $wgChatPrivateServerOverride;
		}

		$consul = new Wikia\Consul\Client( [
			// SUS-4742: use per-DC Consul agent instead of assuming a local one running on 127.0.0.1:8500
			'base_uri' => Wikia\Consul\Client::getConsulBaseUrl()
		] );

		$serverNodes = $consul->getNodes( 'chat-private', $wgWikiaEnvironment );

		$index = rand( 0, count( $serverNodes ) - 1 );

		return $serverNodes[ $index ];
	}

	public static function getSecretToken() {
		global $wgChatCommunicationToken;

		return $wgChatCommunicationToken;
	}

}
