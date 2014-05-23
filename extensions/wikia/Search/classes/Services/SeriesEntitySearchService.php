<?php

namespace Wikia\Search\Services;

class SeriesEntitySearchService extends EntitySearchService {

	const XWIKI_CORE = 'xwiki';
	const WIKI_LIMIT = 1;
	const MINIMAL_WIKIA_ARTICLES = 30;
	const MINIMAL_WIKIA_SCORE = 2;
	const DEFAULT_SLOP = 1;

	private static $EXCLUDED_WIKIS = [ '*fanon.wikia.com', '*answers.wikia.com' ];

	protected function getCore() {
		return static::XWIKI_CORE;
	}

	protected function prepareQuery( $query ) {
		$select = $this->getSelect();

		$phrase = $this->sanitizeQuery( $query );
		$slang = $this->sanitizeQuery( $this->getLang() );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( '+("' . $phrase . '") AND +(lang_s:' . $slang . ')' );
		$select->setRows( static::WIKI_LIMIT );

		$excluded = [ ];
		foreach ( static::$EXCLUDED_WIKIS as $ex ) {
			$excluded[ ] = "-(hostname_s:{$ex})";
		}
		$select->createFilterQuery( 'A&F' )->setQuery( implode( ' AND ', $excluded ) );
		$select->createFilterQuery( 'articles' )->setQuery( 'articles_i:[' . static::MINIMAL_WIKIA_ARTICLES . ' TO *]' );

		$dismax->setQueryFields( 'series_mv_tm^15 description_txt categories_txt top_categories_txt top_articles_txt ' .
			'sitename_txt^4 all_domains_mv_wd^15' );
		$dismax->setPhraseFields( 'series_mv_tm^15 sitename_txt^5 all_domains_mv_wd^15' );

		$dismax->setBoostFunctions( 'wam_i^2' );

		$dismax->setQueryPhraseSlop(static::DEFAULT_SLOP);
		$dismax->setPhraseSlop(static::DEFAULT_SLOP);

		return $select;
	}

	protected function consumeResponse( $response ) {
		$result = [ ];
		foreach ( $response as $doc ) {
			if ( ( $doc[ 'id' ] && $doc[ 'url' ] ) && $doc[ 'score' ] > static::MINIMAL_WIKIA_SCORE ) {
				$result[ ] = [ 'id' => $doc[ 'id' ] ];
			}
		}
		return $result;
	}

}