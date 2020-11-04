<?php

class DiscussionCommonHooks {
	public static function onGetUserTraceHeaders( array &$traceHeaders, WebRequest $request ): void {
		$traceHeaders = [
			'X-Original-User-Agent' => $request->getHeader( 'user-agent' ) ?? '',
			'Fastly-Client-IP' => $request->getHeader( 'Fastly-Client-IP' ) ?? '',
			'X-GeoIP-City' => $request->getHeader( 'X-GeoIP-City' ) ?? '',
			'X-GeoIP-Region' => $request->getHeader( 'X-GeoIP-Region' ) ?? '',
			'X-GeoIP-Country-Name' => $request->getHeader( 'X-GeoIP-Country-Name' ) ?? '',
			'X-Wikia-WikiaAppsID' => $request->getHeader( 'X-Wikia-WikiaAppsID' ) ?? '',
		];
	}
}
