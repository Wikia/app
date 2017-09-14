<?php

namespace Wikia\Search\Services;

class WikiSeriesEntitySearchService extends EntitySearchService {

	const WIKI_LIMIT = 1;
	const MINIMAL_WIKIA_ARTICLES = 20;
	const MINIMAL_WIKIA_SCORE = 2;
	const DEFAULT_SLOP = 1;

	protected $blacklistedWikiHosts = [ '*fanon.wikia.com', '*answers.wikia.com' ];

	protected function getCore() {
		return SearchCores::CORE_XWIKI;
	}

	protected function prepareQuery( string $query ) {
		$this->getBlacklist()->addBlacklistedHostsProvider(
			BlacklistFilter::staticProvider( $this->blacklistedWikiHosts )
		);
		$select = $this->getSelect();

		$phrase = $this->sanitizeQuery( $query );
		$slang = $this->sanitizeQuery( $this->getLang() );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( '+("' . $phrase . '") AND +(lang_s:' . $slang . ')' );
		$select->setRows( static::WIKI_LIMIT );

		$select = $this->getBlacklist()->applyFilters( $select );

		$select->createFilterQuery( 'articles' )->setQuery(
			'articles_i:[' . static::MINIMAL_WIKIA_ARTICLES . ' TO *]'
		);

		$dismax->setQueryFields(
			'series_mv_tm^15 description_txt categories_txt top_categories_txt top_articles_txt ' .
			'sitename_txt^2 all_domains_mv_wd^5'
		);
		$dismax->setPhraseFields( 'series_mv_tm^15 sitename_txt^2 all_domains_mv_wd^5' );

		$dismax->setBoostFunctions( 'wam_i^4' );

		$dismax->setQueryPhraseSlop( static::DEFAULT_SLOP );
		$dismax->setPhraseSlop( static::DEFAULT_SLOP );

		return $select;
	}

	protected function consumeResponse( $response ) {
		$result = [];
		foreach ( $response as $doc ) {
			if ( ( $doc['id'] && $doc['url'] ) && $doc['score'] > static::MINIMAL_WIKIA_SCORE ) {
				$result[] = [ 'id' => $doc['id'] ];
			}
		}

		return $result;
	}

}
