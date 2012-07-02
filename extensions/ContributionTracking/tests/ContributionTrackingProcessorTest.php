<?php

/**
 * Tests for the ContributionTrackingProcessor class. This class is used by both
 * the interstitial page and the API to process donation requests, determine
 * where the donor should be sent next, and send them there with all the
 * required information in a format accepted by the gateway.
 * @group Fundraising
 * @group Splunge
 * @author Katie Horn <khorn@wikimedia.org>
 */
class ContributionTrackingProcessorTest extends MediaWikiTestCase {

	/**
	 * tests the rekey function in the ContributionTrackingProcessor.
	 */
	function testRekey() {
		$start = array(
			'bears' => 'green',
			'emus' => 'purple'
		);
		$expected = array(
			'llamas' => 'green',
			'emus' => 'purple'
		);

		ContributionTrackingProcessor::rekey( $start, 'bears', 'llamas' );

		$this->assertEquals( $start, $expected, "Rekey is not working as expected." );
	}

	/**
	 * Tests the stage_checkbox function
	 * $start coming out as $expected will tell us that it works as expected
	 * with both existing and non-existant keys
	 */
	function testStageCheckbox() {
		$start = array(
			'bears' => 'green',
			'emus' => 'purple'
		);
		$expected = array(
			'bears' => 1,
			'emus' => 'purple'
		);

		ContributionTrackingProcessor::stage_checkbox( $start, 'bears' );
		ContributionTrackingProcessor::stage_checkbox( $start, 'llamas' );

		$this->assertEquals( $start, $expected, "stage_checkbox is not working as expected." );
	}

	/**
	 * tests the stage_contribution function, and as a by-product,
	 * the getContributionDefaults function as well.
	 * Asserts that:
	 * 		A staged contribution with no relevant fields will come back equal
	 * to exactly the defaults
	 * 		A staged contribution with some relevant fields will come back as
	 * the defaults, with keys overwritten by the supplied fields where they
	 * exist
	 * 		A staged contribution with some relevant fields and some irrelevant
	 * fields will come back as the defaults, with relevant keys overwritten by
	 * the supplied fields where they exist. The irrelevant fields should not
	 * come back at all.
	 * 		A staged contribution with boolean (checkbox) fields will come back
	 * with those values either set to "1" or "0", depending solely on whether
	 * they exist in the supplied parameters or not.
	 */
	function testStageContribution() {
		$start = array(
			'bears' => 'green',
			'emus' => 'purple'
		);
		$expected = ContributionTrackingProcessor::getContributionDefaults();
		$result = ContributionTrackingProcessor::stage_contribution( $start );
		$this->assertEquals( $expected, $result, "Staged Contribution with no defined fields should be exactly all the default values." );

		$additional = array(
			'note' => 'B Flat',
			'referrer' => 'phpunit_processor',
			'anonymous' => 'Raspberries'
		);

		$expected = array(
			'note' => 'B Flat',
			'referrer' => 'phpunit_processor',
			'anonymous' => 1,
			'utm_source' => null,
			'utm_medium' => null,
			'utm_campaign' => null,
			'optout' => 0,
			'language' => null,
			'owa_session' => null,
			'owa_ref' => null,
			'ts' => null,
		);
		$result = ContributionTrackingProcessor::stage_contribution( $additional );
		$this->assertEquals( $expected, $result, "Contribution not staging properly." );

		$start = array_merge( $start, $additional );
		$result = ContributionTrackingProcessor::stage_contribution( $start );
		$this->assertEquals( $expected, $result, "Contribution not staging properly." );


		$complete = array(
			'note' => 'Batman',
			'referrer' => 'phpunit_processor',
			'anonymous' => 'of course',
			'utm_source' => 'batcave',
			'utm_medium' => 'Alfred',
			'utm_campaign' => 'Joker',
			'language' => 'squeak!',
			'owa_session' => 'arghargh',
			'owa_ref' => 'test',
			'ts' => '11235813'
		);

		$expected = $complete;
		$expected['anonymous'] = 1;
		$expected['optout'] = 0;

		$result = ContributionTrackingProcessor::stage_contribution( $complete );
		$this->assertEquals( $expected, $result, "Contribution not staging properly." );
	}

	/**
	 * Tests saveNewContribution()
	 * Assertions:
	 * 		saveNewContributions returns a number.
	 * 		Each parameter saved to the contribution_tracking table is identical
	 * to the value we were trying to save, in the row matching the ID returned
	 * from saveNewContribution.
	 * 		The owa_ref URL value is stored in the owa_ref table, and referenced
	 * by the correct id in the owa_ref column
	 *
	 */
	function testSaveNewContribution() {
		//TODO: Test inserting pure garbage.
		$complete = array(
			'note' => 'Batman is pretty awesome.',
			'referrer' => 'phpunit_processor',
			'anonymous' => 'of course',
			'utm_source' => 'batcave',
			'utm_medium' => 'Alfred',
			'utm_campaign' => 'Joker',
			'language' => 'squeak!',
			'owa_session' => 'arghargh',
			'owa_ref' => 'test'
		);
		$table1_check = $complete;
		$table1_check['anonymous'] = 1;
		$table1_check['optout'] = 0;
		unset( $table1_check['owa_ref'] );

		$id = ContributionTrackingProcessor::saveNewContribution( $complete );
		$this->assertTrue( is_numeric( $id ), "Returned value is not an ID." );

		$db = ContributionTrackingProcessor::contributionTrackingConnection();
		$row = $db->selectRow( 'contribution_tracking', '*', array( 'id' => $id ) );

		foreach ( $table1_check as $key => $value ) {
			$this->assertEquals( $value, $row->$key, "$key does not match in the database." );
		}

		$row = $db->selectRow( 'contribution_tracking_owa_ref', '*', array( 'id' => $row->owa_ref ) );
		$this->assertEquals( $complete['owa_ref'], $row->url, "OWA Reference lookup does not match" );
	}

	/**
	 * tests the getRepostFields function.
	 * Assertions:
	 * 		getRepostFields returns an array.
	 * 		getRepostFields returns expected fields for a one-time paypal
	 * donation.
	 * 		getRepostFields returns expected fields for a one-time paypal
	 * donation.
	 * 		getRepostFields returns expected fields for a one-time paypal
	 * donation.
	 * 		getRepostFields returns translated fields (when they will be
	 * displayed by the gateway) and return-to's for the specified language.
	 *
	 */
	function testGetRepostFields() {
		//TODO: More here.
		$minimal = array(
			'referrer' => 'phpunit_processor',
			'gateway' => 'paypal',
			'amount' => '8.80'
		);

		$returnTitle = Title::newFromText( 'Donate-thanks/en' );
		$expected = array(
			'action' => 'https://www.paypal.com/cgi-bin/webscr',
			'fields' => array(
				'business' => 'donations@wikimedia.org',
				'item_number' => 'DONATE',
				'no_note' => 0,
				'return' => wfExpandUrl( $returnTitle->getFullUrl(), PROTO_HTTP ),
				'currency_code' => 'USD',
				'cmd' => '_xclick',
				'notify_url' => 'https://civicrm.wikimedia.org/fundcore_gateway/paypal',
				'item_name' => 'One-time donation',
				'amount' => '8.80',
				'custom' => '',
			)
		);

		$ret = ContributionTrackingProcessor::getRepostFields( $minimal );
		$this->assertTrue( is_array( $ret ), "Returned value is not an array" );

		$this->assertEquals( $ret, $expected, "Fields for reposting (Paypal, one-time) do not match expected fields" );

		//test paypal recurring
		$minimal['recurring_paypal'] = true;
		$expected['fields']['t3'] = 'M';
		$expected['fields']['p3'] = '1';
		$expected['fields']['srt'] = '12';
		$expected['fields']['src'] = '1';
		$expected['fields']['sra'] = '1';
		$expected['fields']['cmd'] = '_xclick-subscriptions';
		$expected['fields']['item_name'] = 'Recurring monthly donation';
		$expected['fields']['a3'] = '8.80';
		unset( $expected['fields']['amount'] );


		$ret = ContributionTrackingProcessor::getRepostFields( $minimal );
		$this->assertEquals( $ret, $expected, "Fields for reposting (Paypal, recurring) do not match expected fields" );


		//test moneybookers... just in case anybody cares anymore.
		unset( $minimal['recurring_paypal'] );
		$minimal['gateway'] = 'moneybookers';

		$expected = array(
			'action' => 'https://www.moneybookers.com/app/payment.pl',
			'fields' => Array
				(
				'merchant_fields' => 'os0',
				'pay_to_email' => 'donation@wikipedia.org',
				'status_url' => 'https://civicrm.wikimedia.org/fundcore_gateway/moneybookers',
				'language' => 'en',
				'detail1_description' => 'One-time donation',
				'detail1_text' => 'DONATE',
				'currency' => 'USD',
				'amount' => '8.80',
				'custom' => '',
			)
		);
		$ret = ContributionTrackingProcessor::getRepostFields( $minimal );
		$this->assertEquals( $ret, $expected, "Fields for reposting (moneybookers, one-time) do not match expected fields" );

		//test alternate language
		$minimal['gateway'] = 'paypal';
		$minimal['language'] = 'ja'; //japanese.

		$returnTitle = Title::newFromText( 'Donate-thanks/ja' );
		$expected = array(
			'action' => 'https://www.paypal.com/cgi-bin/webscr',
			'fields' => array(
				'business' => 'donations@wikimedia.org',
				'item_number' => 'DONATE',
				'no_note' => 0,
				'return' => wfExpandUrl( $returnTitle->getFullUrl(), PROTO_HTTP ), //Important to the language test.
				'currency_code' => 'USD',
				'cmd' => '_xclick',
				'notify_url' => 'https://civicrm.wikimedia.org/fundcore_gateway/paypal',
				'item_name' => '1回だけ寄付', //This should be translated.
				'amount' => '8.80',
				'custom' => '',
			)
		);

		$ret = ContributionTrackingProcessor::getRepostFields( $minimal );
		$this->assertEquals( $ret, $expected, "Fields for reposting (paypal, one-time, language=ja) do not match expected fields" );

		//test T-shirtness
		$minimal['gateway'] = 'paypal';
		$minimal['language'] = 'en';
		$minimal['tshirt'] = true;
		$minimal['size'] = 'medium';
		$minimal['premium_language'] = 'ja';

		$returnTitle = Title::newFromText( 'Donate-thanks/en' );
		$expected = array(
			'action' => 'https://www.paypal.com/cgi-bin/webscr',
			'fields' => array(
				'business' => 'donations@wikimedia.org',
				'item_number' => 'DONATE',
				'no_note' => 0,
				'return' => wfExpandUrl( $returnTitle->getFullUrl(), PROTO_HTTP ),
				'currency_code' => 'USD',
				'cmd' => '_xclick',
				'notify_url' => 'https://civicrm.wikimedia.org/fundcore_gateway/paypal',
				'item_name' => 'One-time donation',
				'amount' => '8.80',
				'custom' => '',
				'on0' => 'Shirt size',
				'os0' => 'medium',
				'on1' => 'Shirt language',
				'os1' => 'ja',
				'no_shipping' => 2
			)
		);

		$ret = ContributionTrackingProcessor::getRepostFields( $minimal );
		$this->assertEquals( $ret, $expected, "Fields for reposting (paypal, one-time, T-shirt) do not match expected fields" );
	}

	/**
	 * tests the stage_repost function
	 * Assertions:
	 * 		Garbage in, defaults out.
	 * 		The recurring_paypal key is treated like a boolean
	 */
	function testStageRepost() {
		$start = array(
			'bears' => 'green',
			'emus' => 'purple'
		);
		ContributionTrackingProcessor::getLanguage( array( 'language' => 'en' ) );
		$expected = ContributionTrackingProcessor::getRepostDefaults();
		$expected['item_name'] = 'One-time donation';
		$expected['notify_url'] = 'https://civicrm.wikimedia.org/fundcore_gateway/paypal';

		$result = ContributionTrackingProcessor::stage_repost( $start );
		$this->assertEquals( $expected, $result, "Staged Repost with no defined fields should be exactly all the default values." );

		$additional = array(
			'gateway' => 'testgateway',
			'recurring_paypal' => 'raspberries',
			'amount' => '6.60'
		);

		$expected = array(
			'gateway' => 'testgateway',
			'tshirt' => false,
			'size' => false,
			'premium_language' => false,
			'currency_code' => 'USD',
			'return' => 'Donate-thanks/en',
			'fname' => '',
			'lname' => '',
			'email' => '',
			'recurring_paypal' => '1',
			'amount' => '6.60',
			'amount_given' => '',
			'contribution_tracking_id' => '',
			'notify_url' => 'https://civicrm.wikimedia.org/fundcore_gateway/paypal',
			'item_name' => 'Recurring monthly donation'
		);
		$result = ContributionTrackingProcessor::stage_repost( $additional );
		$this->assertEquals( $expected, $result, "Repost not staging properly." );


		unset( $additional['recurring_paypal'] );
		$expected['recurring_paypal'] = 0;
		$expected['item_name'] = 'One-time donation';
		$result = ContributionTrackingProcessor::stage_repost( $additional );
		$this->assertEquals( $expected, $result, "Repost not staging properly." );
	}

	/**
	 * tests the get_owa_ref_id function
	 * Assertions:
	 * 		The unique add comes back with a numeric id.
	 * 		The second call also comes back with a numeric id.
	 * 		The insert and the lookup come back with the same numeric id.
	 */
	function testGetOWARefID() {
		$testRef = "test_ref_" . time();
		$id_1 = ContributionTrackingProcessor::get_owa_ref_id( $testRef ); //add
		$id_2 = ContributionTrackingProcessor::get_owa_ref_id( $testRef ); //get
		$this->assertTrue( is_numeric( $id_1 ), "First id is not numeric: Problem adding OWA Ref URL" );
		$this->assertTrue( is_numeric( $id_2 ), "Second id is not numeric: Problem retrieving OWA Ref ID" );
		$this->assertEquals( $id_1, $id_2, "IDs do not match." );
	}

	/**
	 * tests the getLanguage function.
	 * NOTE: Static vars are involved here.
	 * Assertions:
	 * 		getLanguage with no parameters returns english (if none of the
	 * previous tests set the var differently. Static vars have tricky initial
	 * conditions...)
	 * 		Passing getLanguage a different language than the one previously in
	 * use will cause the var to reset to the explicit language. Messages should
	 * be sent in the new language.
	 */
	function testGetLanguage() {
		$messageKey = 'contributiontracking';
		$messageBG = 'Проследяване на дарението';
		$messageEN = 'Contribution tracking';

		$code = ContributionTrackingProcessor::getLanguage();
		$this->assertEquals( $code, 'en', "Default language is not US (or your test has a hangover)" );

		$params['language'] = 'bg';
		$code = ContributionTrackingProcessor::getLanguage( $params );
		$this->assertEquals( $params['language'], $code, "Returned language is not the one we just sent." );
		$message = ContributionTrackingProcessor::msg( $messageKey );
		$this->assertEquals( $message, $messageBG, "Returned language is not the one we just sent." );

		$params['language'] = 'en';
		$code = ContributionTrackingProcessor::getLanguage( $params );
		$this->assertEquals( $params['language'], $code, "Returned language is not the one we just sent." );
		$message = ContributionTrackingProcessor::msg( $messageKey );
		$this->assertEquals( $message, $messageEN, "Returned language is not the one we just sent." );
	}

	/**
	 * Helper function that recursively sorts arrays by key. Nice for debugging
	 * failed assertEquals, where you're comparing large arrays. 
	 * @param array $array The array you want to recursively ksort.
	 * @return array The ksorted array. 
	 */
	function deepKSort( $array ) {
		foreach ( $array as $key => $value ) {
			if ( is_array( $value ) ) {
				$array[$key] = $this->deepKSort( $value );
			}
		}
		ksort( $array );
		return $array;
	}

}

?>
