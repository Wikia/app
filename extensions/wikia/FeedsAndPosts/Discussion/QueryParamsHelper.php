<?php
namespace Wikia\FeedsAndPosts\Discussion;

class QueryParamsHelper {
	/**
	 * extract query params from request
	 * @param \WikiaRequest $request
	 * @param array $exclude
	 * @return array
	 */
	public static function getQueryParams( \WikiaRequest $request, array $exclude = [] ): array {
		$queryParams = $request->getParams();

		// standard nirvana query params
		unset( $queryParams['method'] );
		unset( $queryParams['controller'] );
		unset( $queryParams['format'] );

		foreach ( $exclude as $qp ) {
			unset( $queryParams[$qp] );
		}

		return $queryParams;
	}
}
