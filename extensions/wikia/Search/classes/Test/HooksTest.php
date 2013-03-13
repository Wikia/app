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
	 * @covers Wikia\Search\Hooks
	 */
	public function testOnWikiaMobileAssetsPackages() {

		$hooks		= new Hooks;

		$mockTitle	= $this->getMock( 'Title', array( 'isSpecial' ) );
		$jsHead		= array();
		$jsBody		= array();
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
		$this->mockApp();
		$this->assertTrue(
				$hooks->onWikiaMobileAssetsPackages( $jsHead, $jsBody, $cssPkg ),
				'As a hook, Wikia\Search\Hooks::onWikiaMobileAssetsPackages must return true.'
		);
		$this->assertEmpty(
		        $jsBody,
		        'Wikia\Search\Hooks::onWikiaMobileAssetsPackages shoudl not append the value "wikiasearch_js_wikiamobile" to the jsBodyPackages array if the title is not special search.'
		);
		$this->assertEmpty(
		        $cssPkg,
		        'Wikia\Search\Hooks::onWikiaMobileAssetsPackages should not append the value "wikiasearch_scss_wikiamobile" to the jsBodyPackages array  if the title is not special search.'
		);
		$this->assertTrue(
		        $hooks->onWikiaMobileAssetsPackages( $jsHead, $jsBody, $cssPkg ),
		        'As a hook, Wikia\Search\Hooks::onWikiaMobileAssetsPackages must return true.'
		);
		$this->assertContains(
				'wikiasearch_js_wikiamobile',
				$jsBody,
				'Wikia\Search\Hooks::onWikiaMobileAssetsPackages shoudl append the value "wikiasearch_js_wikiamobile" to the jsBodyPackages array.'
		);
		$this->assertContains(
		        'wikiasearch_scss_wikiamobile',
		        $cssPkg,
		        'Wikia\Search\Hooks::onWikiaMobileAssetsPackages shoudl append the value "wikiasearch_scss_wikiamobile" to the jsBodyPackages array.'
		);
	}
	
}