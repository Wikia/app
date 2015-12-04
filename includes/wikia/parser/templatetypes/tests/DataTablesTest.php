<?php

use Wikia\Util\GlobalStateWrapper;

class DataTablesTest extends WikiaBaseTest {

	/** @var GlobalStateWrapper */
	private $globals;

	public function setUp() {
		parent::setUp();
		$this->globals = new GlobalStateWrapper( [ 'wgEnableDataTablesParsing' => true, 'wgArticleAsJson' => true ] );
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
}
