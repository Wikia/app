<?php

namespace Wikia\FeedsAndPosts\Discussion;

use Hooks;
use WebRequest;

class TraceHeadersHelper {
	public static function getUserTraceHeaders( WebRequest $request ): array {
		$traceHeaders = [];
		Hooks::run( 'GetUserTraceHeaders', [ &$traceHeaders, $request ] );
		return $traceHeaders;
	}
}
