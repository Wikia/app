<?php

use Wikia\Util\GlobalStateWrapper;

class DataTablesTest extends WikiaBaseTest {

	/** @var GlobalStateWrapper */
	private $globals;

	public function setUp() {
		parent::setUp();
		$this->globals = new GlobalStateWrapper( [ 'wgEnableDataTablesParsing' => true, 'wgArticleAsJson' => true ] );
	}

	public function tearDown() {
		parent::tearDown();
		libxml_clear_errors();
	}

	/**
	 * @dataProvider wikitextProvider
	 */
	public function testTemplateTablesMarking( $wt, $expected ) {
		$this->globals->wrap( function () use ( &$wt ) {
			DataTables::markTranscludedTables( $wt );
		} );
		$this->assertEquals( $expected, $wt );
	}

	/**
	 * @dataProvider htmlTablesProvider
	 */
	public function testTablesMarking( $html, $expected ) {
		$this->globals->wrap( function () use ( &$html ) {
			DataTables::markDataTables( $html );
		} );
		$dom = new DOMDocument();
		$dom->loadHTML( $html );
		$xpath = new DOMXPath( $dom );
		$result = $xpath->query( '*//table[@data-portable="true"]' )->length;

		$this->assertEquals( $expected, $result );
	}

	public function wikitextProvider() {
		return [
			[ "", "" ],
			[
				'{| class="va-table va-table-center"
! {{icon|pistol|big|tooltip=Weapon name}}
! {{Icon|damage|big|tooltip=Weapon damage}}
! {{Icon|merchant|big|tooltip=Weapon value}}
! {{icon|rarity|big|Tooltip=Weapon rarity}}

|-
| [[Rusty BB gun]]
| 0-1
| 10
| {{common}}
|}

{| class="va-table va-table-center"
! {{icon|pistol|big|tooltip=Weapon name}}
! {{Icon|damage|big|tooltip=Weapon damage}}
! {{Icon|merchant|big|tooltip=Weapon value}}
! {{icon|rarity|big|Tooltip=Weapon rarity}}

|-
| [[Rusty BB gun]]
| 0-1
| 10
| {{common}}
|}',
				'{| data-portable="false"  class="va-table va-table-center"
! {{icon|pistol|big|tooltip=Weapon name}}
! {{Icon|damage|big|tooltip=Weapon damage}}
! {{Icon|merchant|big|tooltip=Weapon value}}
! {{icon|rarity|big|Tooltip=Weapon rarity}}

|-
| [[Rusty BB gun]]
| 0-1
| 10
| {{common}}
|}

{| data-portable="false"  class="va-table va-table-center"
! {{icon|pistol|big|tooltip=Weapon name}}
! {{Icon|damage|big|tooltip=Weapon damage}}
! {{Icon|merchant|big|tooltip=Weapon value}}
! {{icon|rarity|big|Tooltip=Weapon rarity}}

|-
| [[Rusty BB gun]]
| 0-1
| 10
| {{common}}
|}' ],
			[ '{| data-portable="false" class="va-table va-table-center"
|}',
			  '{| data-portable="false" class="va-table va-table-center"
|}' ]
		];
	}

	public function htmlTablesProvider() {
		return [
			[ "", 0 ],
			[ "<table></table>", 1 ],
			[ "<table data-portable=\"false\"></table>", 0 ],
			[ "<table data-portable=\"false\"></table><table data-portable=\"true\"></table>", 1 ],
			[ "<table><tr><td colspan='1'>dsafsd</td></tr></table>", 0 ],
			[ "<table><tr><td rowspan='1'>dsafsd</td></tr></table>", 0 ]
		];
	}
}
