<?php
//TODO: draft - part of https://wikia-inc.atlassian.net/browse/DAT-3436
class QuoteTemplateTest extends WikiaBaseTest {


	/**
	 * @dataProvider quoteTemplateParamsProvider
	 *
	 * @param Array $expected
	 * @param Array $data
	 */
	public function testQuotesParams( $expected, $data ) {
		$this->assertEquals( $expected, QuoteTemplate::mapQuoteParams( $data ) );
	}

	public function quoteTemplateParamsProvider() {
		return [
			[ [ 'quotation' => 'He\'s an amazing man.', 'author' => '[[Samantha Carter]]' ],
			  [ '1' => 'He\'s an amazing man.', '2' => '[[Samantha Carter]]' ] ],
			[ [ 'quotation' => 'This is a quote.', 'author' => '[[Author|Some guy]]', 'subject' => 'subject' ],
			  [ '1' => 'This is a quote.', '2' => '[[Author|Some guy]]', '3' => 'subject' ] ],
			[ [ 'quotation' => 'Always Strive for the Unobtainable.' ],
			  [ 'text' => 'Always Strive for the Unobtainable.' ] ],
			[ [ 'quotation' => 'Ferocious [[Dragon]]s and ravaging [[Zombie]]s clash' .
							   'in these two new [[Structure Deck]]s. The [[Structure Deck]]s are tournament tough, ready to' .
							   'play with out of the box with powerful hard to find cards. Each [[Deck]] contains 40 cards,' .
							   'including one brand new [[Ultra Rare]] monster, rulebook, and Dueling guide which assists a' .
							   'Duelist in taking his game to the next level.',
				'author' => 'Upper Deck Entertainment' ],
			  [ '1' => 'Upper Deck Entertainment',
				'2' => 'Ferocious [[Dragon]]s and ravaging [[Zombie]]s clash' .
					   'in these two new [[Structure Deck]]s. The [[Structure Deck]]s are tournament tough, ready to' .
					   'play with out of the box with powerful hard to find cards. Each [[Deck]] contains 40 cards,' .
					   'including one brand new [[Ultra Rare]] monster, rulebook, and Dueling guide which assists a' .
					   'Duelist in taking his game to the next level.' ] ],
			[ [ 'quotation' => 'It\'s a Grade 3 like no other! And I should know, \'cause I\'m an expert on the matter!' .
							   'Be wary! When I join forces with the strongest card ever created, it signals your doom! ' .
							   'Dragonic Overlord the End! Super Strong Break Ride!',
				'author' => '\'\'\'Katsumi Morikawa\'\'\'', 'subject' => 'Episode 112' ],
			  [ 'color' => 'red',
				'1' => 'It\'s a Grade 3 like no other! And I should know, \'cause I\'m an expert on the matter!' .
					   'Be wary! When I join forces with the strongest card ever created, it signals your doom! ' .
					   'Dragonic Overlord the End! Super Strong Break Ride!',
				'2' => '\'\'\'Katsumi Morikawa\'\'\'', '3' => 'Episode 112' ] ],
		];
	}
}
