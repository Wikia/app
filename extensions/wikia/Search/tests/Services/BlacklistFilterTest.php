<?php


namespace Wikia\Search\Test\Services;


use Wikia\Search\Services\BlacklistFilter;
use Wikia\Search\Services\EntitySearchService;
use Wikia\Search\Services\SearchCores;
use Wikia\Search\Test\BaseTest;

class BlackListFilterTest extends BaseTest {
	public function testStaticProvider_works() {
		$provider = BlacklistFilter::staticProvider( [ 1, 2, 3 ] );
		$this->assertEquals( [ 1, 2, 3 ], $provider() );
	}

	public function testUnionSetProvider_providesUnionOfTwoStatics() {
		$a = BlacklistFilter::staticProvider( [ 1, 2, 3 ] );
		$b = BlacklistFilter::staticProvider( [ 1, 2, 3, 4 ] );

		$provider = BlacklistFilter::unionSetProvider( $a, $b );

		$this->assertEquals( [ 1, 2, 3, 4 ], BlacklistFilter::materializeProvider( $provider ) );
	}

	public function testUnionSetProvider_providesUnionWhenOneProviderIsNull() {
		$a = BlacklistFilter::staticProvider( [ 1, 2, 3 ] );
		$b = BlacklistFilter::staticProvider( [ 4, 5, 6 ] );

		$provider = BlacklistFilter::unionSetProvider( $a, null );
		$this->assertEquals( [ 1, 2, 3 ], BlacklistFilter::materializeProvider( $provider ) );

		$provider = BlacklistFilter::unionSetProvider( $b, null );
		$this->assertEquals( [ 4, 5, 6 ], BlacklistFilter::materializeProvider( $provider ) );
	}

	public function testUnionSetProvider_providesNullWhenBothProvidersAreNull() {
		$provider = BlacklistFilter::unionSetProvider( null, null );
		$this->assertEquals( null, BlacklistFilter::materializeProvider( $provider ) );
	}

	public function testBlacklistedWikiIdsQuery_producedCorrectQueryForMainCore() {
		$filter = new BlacklistFilter( SearchCores::CORE_MAIN );

		//turnoff default providers
		$filter->setBlacklistedIdsProvider( null );

		// test adding to empty provider
		$filter->addBlacklistedIdsProvider(
			BlacklistFilter::staticProvider( [ 1, 2, 3 ] )
		);
		$this->assertEquals( "-(wid:1) AND -(wid:2) AND -(wid:3)", $filter->getBlacklistedWikiIdsQuery() );

		$filter->addBlacklistedIdsProvider(
			BlacklistFilter::staticProvider( [ 4 ] )
		);
		$this->assertEquals( "-(wid:1) AND -(wid:2) AND -(wid:3) AND -(wid:4)", $filter->getBlacklistedWikiIdsQuery() );
	}

	public function testBlacklistedWikiIdsQuery_producedCorrectQueryForXWikiCore() {
		$filter = new BlacklistFilter( SearchCores::CORE_XWIKI );

		//turnoff default providers
		$filter->setBlacklistedIdsProvider( null );

		// test adding to empty provider
		$filter->addBlacklistedIdsProvider(
			BlacklistFilter::staticProvider( [ 1, 2, 3 ] )
		);
		$this->assertEquals( "-(id:1) AND -(id:2) AND -(id:3)", $filter->getBlacklistedWikiIdsQuery() );

		$filter->addBlacklistedIdsProvider(
			BlacklistFilter::staticProvider( [ 4 ] )
		);
		$this->assertEquals( "-(id:1) AND -(id:2) AND -(id:3) AND -(id:4)", $filter->getBlacklistedWikiIdsQuery() );
	}

	public function testBlacklistedHostsQuery_producedCorrectQueryForMainCore() {
		$filter = new BlacklistFilter( SearchCores::CORE_MAIN );

		//turnoff default providers
		$filter->setBlacklistedHostsProvider( BlacklistFilter::staticProvider( [ 'host.com' ] ) );

		// test adding to empty provider
		$filter->addBlacklistedHostsProvider(
			BlacklistFilter::staticProvider( [ 'hostb.com', '*.wildcard.net' ] )
		);

		$this->assertEquals( "-(host:host.com) AND -(host:hostb.com) AND -(host:*.wildcard.net)", $filter->getBlacklistedHostsQuery() );
	}

	public function testBlacklistedHostsQuery_producedCorrectQueryForXWikiCore() {
		$filter = new BlacklistFilter( SearchCores::CORE_XWIKI );

		//turnoff default providers
		$filter->setBlacklistedHostsProvider( BlacklistFilter::staticProvider( [ 'host.com' ] ) );

		// test adding to empty provider
		$filter->addBlacklistedHostsProvider(
			BlacklistFilter::staticProvider( [ 'hostb.com', '*.wildcard.net' ] )
		);

		$this->assertEquals( "-(hostname_s:host.com) AND -(hostname_s:hostb.com) AND -(hostname_s:*.wildcard.net)", $filter->getBlacklistedHostsQuery() );
	}


	/**
	 * Licenced wikis calls out to database
	 * @group Slow
	 */

	public function testBlacklistedLicensedWikiDefaultHandling() {
		$licencedService = new \LicensedWikisService();
		$commercialWikiIds = array_keys( $licencedService->getCommercialUseNotAllowedWikis() );

		$filter = new BlacklistFilter( SearchCores::CORE_MAIN );
		$defaultIds = BlacklistFilter::materializeProvider($filter->getBlacklistedIdsProvider());

		$this->assertEquals($commercialWikiIds, $defaultIds);
	}
}
