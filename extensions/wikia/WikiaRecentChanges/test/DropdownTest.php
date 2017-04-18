<?php
namespace RecentChanges;

use PHPUnit\Framework\TestCase;
use Language;
use WikiaApp;
use WikiaLocalRegistry;

class DropdownTest extends TestCase {
	/** @var Dropdown $dropdown */
	private $dropdown;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../WikiaRecentChanges.setup.php';

		$this->dropdown = new Dropdown();
	}

	public function testSpecialNamespaceIsExcludedFromDropdown() {
		$langMock = $this->createMock( Language::class );
		$langMock->expects( $this->once() )
			->method( 'getFormattedNamespaces' )
			->willReturn( [
				NS_SPECIAL => 'special',
				NS_MAIN => 'main',
			    NS_TALK => 'talk'
			] );

		$app = new WikiaApp( new WikiaLocalRegistry() );
		$app->wg->ContLang = $langMock;

		$this->dropdown->setApp( $app );
		$opts = $this->dropdown->getNamespaceOptions();

		$this->assertCount( 2, $opts );
		foreach ( $opts as $option ) {
			$this->assertArrayHasKey( 'value', $option );
			$this->assertNotEquals( NS_SPECIAL, $option['value'] );
		}
	}

	public function testDropdownContainsAllLogTypes() {
		$logTypes = [ 'foobarlog', 'upload', 'block' ];

		$app = new WikiaApp( new WikiaLocalRegistry() );
		$app->wg->LogTypes = $logTypes;

		$this->dropdown->setApp( $app );
		$opts = $this->dropdown->getLogTypeOptions();

		$this->assertCount( 3, $opts );
		foreach ( $logTypes as $i => $logType ) {
			$this->assertArrayHasKey( 'value', $opts[$i] );
			$this->assertEquals( $logType, $opts[$i]['value'] );
		}
	}
}
