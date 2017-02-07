<?php
/**
 * Class definition for Wikia\Search\Test\Query\Select
 */
namespace Wikia\Search\Test\Query;
use Wikia\Search\Query\Select as Query, Wikia\Search\MediaWikiService, Wikia\Search\Test\BaseTest, ReflectionMethod, ReflectionProperty;
use Wikia\Search\Query\Select;

class SelectTest extends BaseTest
{
	/**
	 * @group Slow
	 * @slowExecutionTime 0.10199 ms
	 * @covers \Wikia\Search\Query\Select::__construct
	 */
	public function testConstruct()
	{
		$query = new Query( 'foo' );
		$this->assertAttributeEquals(
				'foo',
				'rawQuery',
				$query
		);
	}
	
	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.10945 ms
	 * @covers \Wikia\Search\Query\Select::getSanitizedQuery
	 * @dataProvider getSanitizedQueryDataProvider
	 * @param string $rawQuery raw user input (search query)
	 * @param string $expectedResult expected query after sanitization and formatting
	 */
	public function testGetSanitizedQuery( string $rawQuery, string $expectedResult ) {
		$query = new Query( $rawQuery );
		$this->assertAttributeEmpty( 'sanitizedQuery', $query );

		$this->assertEquals( $expectedResult, $query->getSanitizedQuery() );
		$this->assertAttributeEquals( $expectedResult, 'sanitizedQuery', $query );
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.10793 ms
	 * @covers \Wikia\Search\Query\Select::getQueryForHtml
	 * @dataProvider getQueryForHtmlDataProvider
	 * @param string $rawQuery raw user input (search query)
	 * @param string $expectedSafeOutput expected html-safe output
	 */
	public function testGetQueryForHtml( string $rawQuery, string $expectedSafeOutput ) {
		$query = new Query( $rawQuery );
		$this->assertEquals( $expectedSafeOutput, $query->getQueryForHtml() );
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.10823 ms
	 * @covers \Wikia\Search\Query\Select::hasTerms
	 * @dataProvider hasTermsDataProvider
	 * @param string $rawQuery raw user input (search query)
	 * @param bool $shouldHaveTerms whether the input counts as a valid search term
	 */
	public function testHasTerms( string $rawQuery, bool $shouldHaveTerms ) {
		$query = new Query( $rawQuery );

		$this->assertEquals( $query->hasTerms(), $shouldHaveTerms );
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09127 ms
	 * @covers \Wikia\Search\Query\Select::getService
	 */
	public function testGetService() {
		$query = new Query( 'foo' );
		$method = new ReflectionMethod( 'Wikia\Search\Query\Select', 'getService' );
		$method->setAccessible( true );
		$this->assertInstanceOf(
				MediaWikiService::class,
				$method->invoke( $query )
		);
		$this->assertAttributeInstanceOf(
				MediaWikiService::class,
				'service',
				$query
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09147 ms
	 * @covers \Wikia\Search\Query\Select::initializeNamespaceData
	 * @covers \Wikia\Search\Query\Select::getNamespacePrefix
	 * @covers \Wikia\Search\Query\Select::getNamespaceId
	 * @dataProvider namespaceLogicDataProvider
	 * @param string $rawQuery raw user input (search query)
	 * @param null|int $expectedNamespaceId expected NS number or null if no NS
	 * @param null|string $expectedNamespacePrefix expected ns prefix or null if no NS
	 */
	public function testNamespaceLogic( string $rawQuery, $expectedNamespaceId, $expectedNamespacePrefix ) {
		$query = new Query( $rawQuery );
		$this->assertEquals( $query->getNamespaceId(), $expectedNamespaceId );
		$this->assertEquals( $query->getNamespacePrefix(), $expectedNamespacePrefix );
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09139 ms
	 * @covers \Wikia\Search\Query\Select::getSolrQuery
	 */
	public function testGetSolrQuery() {
		$query = new Query( "Category:Shortcuts" );
		$this->assertEquals(
				"Shortcuts",
				$query->getSolrQuery()
		);
		$query = new Query( "123foo" );
		$this->assertEquals(
				"123 foo",
				$query->getSolrQuery()
		);
		$query = new Query( '"foo:bar&&baz"' );
		$this->assertEquals(
				'\"foo\:bar\&&baz\"',
				$query->getSolrQuery()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09074 ms
	 */
	public function testGetSolrQueryWithWordLimit() {
		$query = <<<YEEZY
Uh:my mind move like a Tron bike
Uh, pop a wheelie on the Zeitgeist
Uh, I'm finna start a new movement
YEEZY;
		$q = new Query( $query );
		$this->assertEquals(
				'Uh\:my mind move like a Tron bike Uh, pop a',
				$q->getSolrQuery( 10 )
		);

		$sQuery = 'test';
		$q = new Query( $sQuery );
		$this->assertEquals(
			$sQuery,
			$q->getSolrQuery( 10 )
		);
	}

	public function getSanitizedQueryDataProvider(): array {
		return [
			'html entities and tags' => [
				"crime &amp; <b>punishment</b>",
				"crime & punishment"
			]
		];
	}

	public function getQueryForHtmlDataProvider(): array {
		return [
			'html entities and tags' => [
				"crime &amp; <b>punishment</b>",
				"crime &amp; punishment"
			],
			'html entity' => [
				"crime & punishment",
				"crime &amp; punishment"
			]
		];
	}

	public function hasTermsDataProvider(): array {
		return [
			'query consisting of only spaces' => [
				'    ', false
			],
			'query consisting of only whitespace characters' => [
				" \t\n", false
			],
			'valid search query' => [
				'co to jest', true
			],
			'sanitized search query' => [
				'<code>na dawaj no html!</code>   ', true
			]
		];
	}

	public function namespaceLogicDataProvider(): array {
		return [
			'invalid namespace' => [
				'NaCoToJest:Isnotanamespace', null, null
			],
			'valid namespace' => [
				'Category:Na dobre', NS_CATEGORY, 'Category'
			],
			'evil string ending with colon' => [
				'jestesmy zgubieni:', null, null
			]
		];
	}
}
