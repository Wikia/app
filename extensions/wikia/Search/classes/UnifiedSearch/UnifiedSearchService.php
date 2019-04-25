<?php

namespace Wikia\Search\UnifiedSearch;

class UnifiedSearchService {

	public function search( UnifiedSearchRequest $request ) {
		return new UnifiedSearchResult( [
				[
					'pageid' => 2709,
					'text' => 'zorf',
					'wid' => 3035,
					'title' => 'BB',
					'url' => 'https=>//fallout.mturek.wikia-dev.pl/wiki/BB',
					'ns' => 0,
					'hub_s' => 'Gaming',
				],
			] );
	}
}
