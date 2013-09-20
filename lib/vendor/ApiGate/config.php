<?php
/**
 * @author Sean Colombo
 * @date 20111005
 *
 * This is the configuration file for API Gate.
 */

/*
 * SETTINGS THAT MUST BE CUSTOMIZED
 */
$APIGATE_CONTACT_EMAIL = "api@wikia.com";

global $wgScriptPath, $wgDevelEnvironment;

// Wikia-specific settings (ie: not used by ApiGate in general)
$WIKIA_CITYID_APIWIKI = "352316";
if( empty( $wgDevelEnvironment ) ) {
	// used because Special:ApiGate should be on all wikis (where it will appear in user-links) but the page should redirect to the version on API Wiki.
	$APIGATE_API_WIKI_SPECIAL_PAGE = "http://api.wikia.com/wiki/Special:ApiGate";
}

/*
 * HEADERS
 */
// Expected & understood by Fastly (a CDN that has worked with API Gate) to indicate that this result requires a valid API key in the request.
$APIGATE_HEADER_REQUIRES_API = "X-Requires-ApiKey";

// Recommended that each app override this for clarity.  Example value (follows a widely used convention): "X-Wikia-API-Key".
//$APIGATE_HEADER_API_KEY = "X-ApiGate-API-Key";
$APIGATE_HEADER_API_KEY = "X-Wikia-API-Key"; // TODO: Can we separate Wikia's default config from ApiGate's default config easily?

/*
 * HTTP STATUS CODES
 */
$APIGATE_HTTP_STATUS_OK = 200;
$APIGATE_HTTP_STATUS_FAILED_AUTH = 401;
$APIGATE_HTTP_STATUS_RATE_LIMITED = 509; // 509 means "Bandwidth exceeded" which is the closest match.
//$APIGATE_HTTP_STATUS_TEAPOT = 418; // unused, for now ;)