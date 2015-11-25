<?php
//TODO: draft - part of https://wikia-inc.atlassian.net/browse/DAT-3436
class QuoteTemplateTest extends WikiaBaseTest {


	public function testQuotesParams() {

		QuoteTemplate::mapQuoteParams( [ '1' => 'He\'s an amazing man.', '2' => '[[Samantha Carter]]' ] );
	}
}

