<?php

namespace Wikia\Search\UnifiedSearch;

use UnifiedSearchService;
use Wikia\Logger\WikiaLogger;

class UniSearchService {

	public function search( UnifiedSearchRequest $request ): UnifiedSearchResult {
		$result =
			( new UnifiedSearchService() )->query( $request->getWikiId(),
				$request->getLanguageCode(), $request->getQuery()->getSanitizedQuery(),
				$request->getNamespaces() );
		WikiaLogger::instance()->info( "fetched" . json_encode( $result ) );

		return new UnifiedSearchResult( [
			[
				'pageid' => 2709,
				'text' => 'zorf',
				'wid' => 3035,
				'title' => 'BB',
				'url' => 'https://fallout.mturek.wikia-dev.pl/wiki/BB',
				'ns' => 0,
				'hub_s' => 'Gaming',
			],
		] );
	}
}
