<?php
/**
 * Class definition for Wikia\Search\Test\HooksTest
 */
namespace Wikia\Search\Test;
use Wikia\Search\Hooks;
/**
 * Tests hooks related to Wikia\Search
 */
class HooksTest extends BaseTest {
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.08068 ms
	 * @covers \Wikia\Search\Hooks
	 */
	public function testOnWikiaMobileAssetsPackages() {

		$hooks		= new Hooks;

		$mockTitle	= $this->getMock( 'Title', array( 'isSpecial' ) );
		$jsStatic		= array();
		$jsExtension	= array();
		$cssPkg		= array();

		$mockTitle
			->expects	( $this->at( 0 ) )
			->method	( 'isSpecial' )
			->with		( 'Search' )
			->will		( $this->returnValue( false ) )
		;
		$mockTitle
			->expects	( $this->at( 1 ) )
			->method	( 'isSpecial' )
			->with		( 'Search' )
			->will		( $this->returnValue( true ) )
		;

		$this->mockGlobalVariable( 'wgTitle', $mockTitle );
		$this->assertTrue(
				$hooks->onWikiaMobileAssetsPackages( $jsStatic, $jsExtension, $cssPkg ),
				'As a hook, Wikia\Search\Hooks::onWikiaMobileAssetsPackages must return true.'
		);
		$this->assertEmpty(
		        $jsExtension,
		        'Wikia\Search\Hooks::onWikiaMobileAssetsPackages shoudl not append the value "wikiasearch_js_wikiamobile" to the jsBodyPackages array if the title is not special search.'
		);
		$this->assertEmpty(
		        $cssPkg,
		        'Wikia\Search\Hooks::onWikiaMobileAssetsPackages should not append the value "wikiasearch_scss_wikiamobile" to the jsBodyPackages array  if the title is not special search.'
		);
		$this->assertTrue(
		        $hooks->onWikiaMobileAssetsPackages( $jsStatic, $jsExtension, $cssPkg ),
		        'As a hook, Wikia\Search\Hooks::onWikiaMobileAssetsPackages must return true.'
		);
		$this->assertContains(
				'wikiasearch_js_wikiamobile',
				$jsExtension,
				'Wikia\Search\Hooks::onWikiaMobileAssetsPackages shoudl append the value "wikiasearch_js_wikiamobile" to the jsBodyPackages array.'
		);
		$this->assertContains(
		        'wikiasearch_scss_wikiamobile',
		        $cssPkg,
		        'Wikia\Search\Hooks::onWikiaMobileAssetsPackages shoudl append the value "wikiasearch_scss_wikiamobile" to the jsBodyPackages array.'
		);
	}

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
