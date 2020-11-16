<?php

class TraceHeadersHelper {
	public static function getUserTraceHeaders( WebRequest $request ): array {
		$traceHeaders = [];
		Hooks::run( 'GetUserTraceHeaders', [ &$traceHeaders, $request ] );
		return $traceHeaders;
	}
}
