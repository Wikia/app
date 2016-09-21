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
			DataTables::markTranscludedTables( $wt, $title );
		} );
		$this->assertEquals( $expected, $wt );
	}

	/**
	 * @dataProvider htmlTablesProvider
	 */
	public function testTablesMarking( $html, $expected ) {
		$this->globals->wrap( function () use ( &$html ) {
			DataTables::markDataTables( null, $html );
		} );
		$dom = new DOMDocument();
		$dom->loadHTML( $html );
		$xpath = new DOMXPath( $dom );
		$result = $xpath->query( '*//table[@data-portable="true"]' )->length;

		$this->assertEquals( $expected, $result );
	}

	/**
	 * Verifies if there is no CDATA inserted inside of widget script tag
	 * as it would break widgets on Mercury
	 *
	 * @see http://wikia-inc.atlassian.net/browse/MAIN-6066
	 * @dataProvider noCDATAProvider
	 */
	public function testNoCDATA( $html, $expected ) {
		$this->globals->wrap( function () use ( &$html ) {
			DataTables::markDataTables( null, $html );
		} );
		$this->assertEquals( $expected, $html );
	}

	public function wikitextProvider() {
		return [
			[ "", "" ],
			[
				'<includeonly><onlyinclude>{| class="myClass va-table va-table-center"
! {{icon|pistol|big|tooltip=Weapon name}}
! {{Icon|damage|big|tooltip=Weapon damage}}
! {{Icon|merchant|big|tooltip=Weapon value}}
! {{icon|rarity|big|Tooltip=Weapon rarity}}

|-
| [[Rusty BB gun]]
| 0-1
| 10
| {{common}}
|}</onlyinclude></includeonly>',
				'<includeonly><onlyinclude>{| data-portable="false" class="myClass va-table va-table-center"
! {{icon|pistol|big|tooltip=Weapon name}}
! {{Icon|damage|big|tooltip=Weapon damage}}
! {{Icon|merchant|big|tooltip=Weapon value}}
! {{icon|rarity|big|Tooltip=Weapon rarity}}

|-
| [[Rusty BB gun]]
| 0-1
| 10
| {{common}}
|}</onlyinclude></includeonly>'
			],
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
				'{| data-portable="false" class="va-table va-table-center"
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

{| data-portable="false" class="va-table va-table-center"
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
|}' ],
			[
				'<includeonly><onlyinclude>
					<table><tr><td>sth</td><td>sth2</td></tr></table>
				</onlyinclude></includeonly>',

				'<includeonly><onlyinclude>
					<table data-portable="false"><tr><td>sth</td><td>sth2</td></tr></table>
				</onlyinclude></includeonly>'
			],
			[ '<table></table>', '<table data-portable="false"></table>' ],
			[ '{| class="va-table va-table-center"
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
asdkjf kasjdflk [[asdfasdf]]
<table><tr><td>asdfadsf</td></tr><tr><td>asdfadfasdf</td></tr></table>',
			  '{| data-portable="false" class="va-table va-table-center"
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
asdkjf kasjdflk [[asdfasdf]]
<table data-portable="false"><tr><td>asdfadsf</td></tr><tr><td>asdfadfasdf</td></tr></table>' ],
			[ '<table></table> sakjdflkjds k <table/>',
			  '<table data-portable="false"></table> sakjdflkjds k <table data-portable="false"/>' ],
			[ '{{{{{|safesubst:}}}#replace:{{{1}}}|a|b}}',
			  '{{{{{|safesubst:}}}#replace:{{{1}}}|a|b}}'],
			[ '{{{| (quote) }}}',
			  '{{{| (quote) }}}']
		];
	}

	public function noCDATAProvider() {
		return [
			[
				'<table cellspacing="5" style="margin:auto">

<tr valign="middle">
<td><img src=\'//:0\' class=\'article-media\' data-ref=\'0\' />
				</td><td><img src=\'//:0\' class=\'article-media\' data-ref=\'1\' />
</td></tr></table>
<center><script type="x-wikia-widget"><iframe data-wikia-widget="pollsnack" scrolling="no" frameborder="0" allowtransparency="true" seamless="" width="300" height="500" src="http://files.quizsnack.com/iframe/embed.html?hash=qh3f6pud&amp;width=&amp;height=500&amp;bgcolor=%23000000"></iframe></script></center>',
				'<table cellspacing="5" style="margin:auto" data-portable="true"><tr valign="middle">
<td><img src="//:0" class="article-media" data-ref="0"></td>
<td><img src="//:0" class="article-media" data-ref="1"></td>
</tr></table>
<center><script type="x-wikia-widget"><iframe data-wikia-widget="pollsnack" scrolling="no" frameborder="0" allowtransparency="true" seamless="" width="300" height="500" src="http://files.quizsnack.com/iframe/embed.html?hash=qh3f6pud&amp;width=&amp;height=500&amp;bgcolor=%23000000"></script></center>'
]
		];
	}


	public function htmlTablesProvider() {
		return [
			[ "", 0 ],
			[ "<table></table>", 1 ],
			[ "<table></table><table></table>", 2 ],
			[ "<table data-portable=\"false\"></table>", 0 ],
			[ "<table data-portable=\"false\"></table><table data-portable=\"true\"></table>", 1 ],
			[ "<table><tr><td colspan='1'>dsafsd</td></tr></table>", 0 ],
			[ "<table><tr><td rowspan='1'>dsafsd</td></tr></table>", 0 ],
			[ "<table></table><table><tr><td rowspan='1'>dsafsd</td></tr></table>
<table><tr><td colspan='1'>dsafsd</td></tr></table>", 1 ],
			[ "<table><table></table></table>", 0 ],
			[ "<table></table><table><table></table></table>", 1 ],
			[ "<table><table><table></table></table></table>", 0 ]
		];
	}
}
