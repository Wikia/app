<?php
/**
 * Class definition for Wikia\Search\Test\HooksTest
 */
namespace Wikia\Search\Test;

/**
 * Tests hooks related to Wikia\Search
 */
class HooksTest extends BaseTest {

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08024 ms
	 * @covers Wikia\Search\Hooks::onWikiFactoryPublicStatusChange
	 */
	public function testOnWikiFactoryPublicStatusChange() {
		$mockIndexer = $this->getMock( 'Wikia\Search\Indexer', array( 'reindexWiki', 'deleteWikiDocs' ) );
		$hooks = new \Wikia\Search\Hooks;
		$mockIndexer
		    ->expects( $this->at( 0 ) )
		    ->method ( 'deleteWikiDocs' )
		    ->will   ( $this->returnValue( true ) )
		;
		$status = 0;
		$wid = 123;
		$this->mockClass( 'Wikia\Search\Indexer', $mockIndexer );
		$this->assertTrue(
				$hooks->onWikiFactoryPublicStatusChange( $status, $wid, 'why not' )
		);
		$mockIndexer
		    ->expects( $this->at( 0 ) )
		    ->method ( 'reindexWiki' )
		    ->will   ( $this->returnValue( true ) )
		;
		$status = 1;
		$this->mockClass( 'Wikia\Search\Indexer', $mockIndexer );
		$this->assertTrue(
				$hooks->onWikiFactoryPublicStatusChange( $status, $wid, 'why not' )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07897 ms
	 * @covers Wikia\Search\Hooks::onGetPreferences
	 */
	public function testonGetPreferences() {
		$badKeys = array(
			'searchlimit',
			'contextlines',
			'contextchars',
			'disablesuggest',
			'searcheverything',
			'searchnamespaces',
		);
		$prefs = array_flip( $badKeys );
		$mockUser = $this->getMock( 'User' );
		$hooks = new \Wikia\Search\Hooks;
		$hooks->onGetPreferences( $mockUser, $prefs );
		foreach ( $badKeys as $key ) {
			$this->assertArrayNotHasKey( $key , $prefs );
		}
		$this->assertArrayHasKey( 'enableGoSearch', $prefs );
		$this->assertArrayHasKey( 'searchAllNamespaces', $prefs );
	}
}
