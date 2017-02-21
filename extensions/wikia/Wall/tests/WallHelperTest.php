<?php

class WallHelperTest extends WikiaBaseTest {

	/**
	 * SUS-1684: Regression test for Wall Wiki Activity entries
	 * Verify that entries conform to max length constraint (by default 150 characters) and that they contain no html
	 *
	 * @dataProvider provideDataForWikiActivityEntries
	 * @covers WallHelper::getMessageSnippet()
	 * @param string $text
	 * @param string $expectedText
	 */
	public function testWikiActivityEntriesAreFormatted( string $text, string $expectedText ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|WallMessage $wallMessageMock */
		$wallMessageMock = $this->getMockBuilder( WallMessage::class )
			->disableOriginalConstructor()
			->setMethods( [ 'getRawText' ] )
			->getMock();
		$wallMessageMock->expects( $this->once() )
			->method( 'getRawText' )
			->willReturn( $text );

		$wallHelper = new WallHelper();
		$entryText = $wallHelper->getMessageSnippet( $wallMessageMock );

		$maxLength = WallHelper::WA_WALL_COMMENTS_MAX_LEN;
		$this->assertLessThanOrEqual( $maxLength, mb_strlen( $entryText ), "Wiki Activity Wall entries must not be longer than $maxLength characters." );
		$this->assertEquals( $expectedText, $entryText, 'Wiki Activity Wall entries must not contain malformed HTML tags.' );
	}

	public function provideDataForWikiActivityEntries(): array {
		return [
			'message wrapped in HTML' => [
				'<div class="quote">Gruby jak armata Szczepan błąkał się po kuli ziemskiej; Trafił do Ameryki prosto z Legii Cudzoziemskiej.</div>',
				'Gruby jak armata Szczepan błąkał się po kuli ziemskiej; Trafił do Ameryki prosto z Legii Cudzoziemskiej.'
			],
			'long message wrapped in HTML' => [
				'<div class="quote">Karawan z Holandii, on przyjechał tutaj wreszcie, Są już Kula, Czarny Dusioł - słychać strzały na mieście. Znam jednak takie miejsca gdzie jest lepiej chodzić z nożem; Całe Górne i Podlasie - wszyscy są za Kolejorzem. (Hej Kolejorz!)</div>',
				'Karawan z Holandii, on przyjechał tutaj wreszcie, Są już Kula, Czarny Dusioł - słychać strzały na mieście. Znam jednak takie miejsca gd...'
			],
			'message with interwoven HTML' => [
				'Classic: <div class="quote">Name und Vorname? Grzegorz Brzęczyszczykiewicz.</div>',
				'Classic: Name und Vorname? Grzegorz Brzęczyszczykiewicz.'
			],
			'long message with interwoven HTML' => [
				'Read the license: <div class="quote">MediaWiki is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.</div>',
				'Read the license: MediaWiki is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty...'
			]
		];
	}
}
