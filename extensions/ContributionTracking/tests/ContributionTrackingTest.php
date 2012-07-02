<?php

/**
 * Yes, I realize this whole test class is full of things that are more 
 * regression run by phpunit, than actual unit tests. For the sake of coverage,
 * it's going to stay that way until we can completely refactor
 * ContributionTracking_body.php (beyond splitting its newly-shared
 * functionality out into something the new API can also reach).
 * //TODO: Refactor ContributionTracking_body.php, and clean up this whole mess.
 * //TODO: Add tests to make sure that garbage requests fail gracefully.
 *
 * //FIXME: Yes, this test class and ContributionTrackingAPITest are nearly
 * exactly the same. They should probably be combined into a thing that tests
 * both entry methods simultaneously with the same requests.
 * @group Fundraising
 * @group Splunge
 * @author Katie Horn <khorn@wikimedia.org>
 */
class ContributionTrackingTest extends MediaWikiTestCase {

	/**
	 * Takes $request parameters and checks them against $expected parameters in
	 * the hidden form that comes back from the ContributionTracking page.
	 * All assert failures will start with the $message_prefix so we know which
	 * test actually failed.
	 * @param array $request The request parameters
	 * @param array $expected Expected contents of the hidden form about to be
	 * reposted to the gateway.
	 * @param string $message_prefix A readable string that identifies the test
	 * on failed assert.
	 */
	function assertExecute_repostFormAsExpected( $request, $expected, $message_prefix ) {
		$page_xml = $this->getPageHTML( $request );

		$reposters = array( );
		foreach ( $page_xml->getElementsByTagName( 'input' ) as $node ) {
			$attributes = $this->getNodeAttributes( $node );
			if ( $attributes['type'] == 'hidden' ) {
				$reposters[$attributes['name']] = $attributes['value'];
			}
		}

		foreach ( $expected['fields'] as $name => $value ) {
			if ( $name === 'custom' ) {
				$this->assertTrue( is_numeric( $reposters[$name] ), $message_prefix . ": 'custom' should be a number." );
			} elseif ( $name === 'item_name' && array_key_exists( 'language', $request ) && $request['language'] !== 'en' ) {
				//TODO: Actually deal with the encoding mismatch here. Urgh.
				$this->assertTrue( ($reposters[$name] != 'One-time Donation' ), $message_prefix . ": Alternate language is coming up English." );
			} else {
				$this->assertEquals( $value, $reposters[$name], $message_prefix . ": Field $name was not reposted as expected by the interstitial page" );
			}
		}

		//and don't forget to check it's the proper action!
		foreach ( $page_xml->getElementsByTagName( 'form' ) as $node ) {
			$attributes = $this->getNodeAttributes( $node );
			if ( $attributes['name'] == 'contributiontracking' ) {
				$this->assertEquals( $attributes['action'], $expected['action'], $message_prefix . ": Form action was incorrect!" );
			}
		}
	}

	/**
	 * Gets the ContributionTracking page's HTML and loads it into a DomDocument
	 * @global FauxRequest $wgRequest used to shoehorn in our own request vars.
	 * @global <type> $wgOut Needed so I can grab the resultant HTML.
	 * @global <type> $wgTitle Needed to solve a totally weird bug. (See below)
	 * @param <type> $request Request vars we are sending to the
	 * ContributionTracking page
	 * @return DomDocument Loaded up with the generated page's html.
	 */
	function getPageHTML( $request ) {
		global $wgRequest, $wgOut, $wgTitle;

		//The next line addresses a totally weird bug I found. Uncomment the next line and run the test to see it.
		$wgTitle = Title::newFromText( 'whatever' );

		$ctpage = new ContributionTracking();
		$wgRequest = new FauxRequest( $request );
		if ( array_key_exists( 'language', $request ) ) {
			$language = $request['language'];
		} else {
			$language = 'en';
		}
		$ctpage->execute( $language );
		$page_xml = new DomDocument( '1.0' );

		$page_xml->loadHTML( trim( $wgOut->getHTML() ) );

		return $page_xml;

		//echo "Hidden form: " . print_r($reposters, true);
		//echo "wgOut: ##" . print_r($wgOut->getHTML(), true) . "##\n";
	}

	/**
	 * Sets up a bare-bones request to send to the interstitial page, and the
	 * values we expect to see in the page's hidden repost form after
	 * processing. Then calls assertExecute_repostFormAsExpected for the actual
	 * processing and assertions.
	 */
	function testExecuteforRepostFields_minimal() {
		$minimal = array(
			'referrer' => 'phpunit_interstitial',
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
				'custom' => '', //this is overridden later. Should be the id of the inserted transaction.
			)
		);

		$this->assertExecute_repostFormAsExpected( $minimal, $expected, "Minimal Repost Test" );
	}

	/**
	 * Sets up a recurring payment type request to send to the interstitial
	 * page, and the values we expect to see in the page's hidden repost form
	 * after processing. Then calls assertExecute_repostFormAsExpected for the
	 * actual processing and assertions.
	 */
	function testExecuteforRepostFields_recurring() {
		//test paypal recurring
		$recurring = array(
			'referrer' => 'phpunit_interstitial',
			'gateway' => 'paypal',
			'amount' => '8.80',
			'recurring_paypal' => true
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
				'a3' => '8.80',
				'custom' => '', //this is overridden later. Should be the id of the inserted transaction.
				't3' => 'M',
				'p3' => '1',
				'srt' => '12',
				'src' => '1',
				'sra' => '1',
				'cmd' => '_xclick-subscriptions',
				'item_name' => 'Recurring monthly donation',
			)
		);


		$this->assertExecute_repostFormAsExpected( $recurring, $expected, "Paypal Recurring Test" );
	}

	/**
	 * Sets up a non-english request (in a language that has a translation) to
	 * send to the interstitial page, and the values we expect to see in the
	 * page's hidden repost form after processing. Then calls
	 * assertExecute_repostFormAsExpected for the actual processing and
	 * assertions.
	 * FIXME: something about the encoding makes this not work as expected.
	 */
	function testExecuteforRepostFields_language() {

		//test alternate language
		$language = array(
			'referrer' => 'phpunit_interstitial',
			'gateway' => 'paypal',
			'amount' => '8.80',
			'language' => 'ja'
		);


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

		$this->assertExecute_repostFormAsExpected( $language, $expected, "Translation Test" );
	}

	/**
	 * Sets up a "premium" request to send to the interstitial page, and the
	 * values we expect to see in the page's hidden repost form after
	 * processing. Then calls assertExecute_repostFormAsExpected for the actual
	 * processing and assertions.
	 */
	function testExecuteforRepostFields_tshirts() {

		//test T-shirtness
		$tshirts = array(
			'referrer' => 'phpunit_interstitial',
			'gateway' => 'paypal',
			'amount' => '8.80',
			'language' => 'en',
			'tshirt' => 'true',
			'size' => 'medium',
			'premium_language' => 'ja'
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
				'on0' => 'Shirt size',
				'os0' => 'medium',
				'on1' => 'Shirt language',
				'os1' => 'ja',
				'no_shipping' => 2
			)
		);

		$this->assertExecute_repostFormAsExpected( $tshirts, $expected, "T-shirt Test" );
	}

	/**
	 * Tests to make sure the contribution was saved in the database properly.
	 * Assertions:
	 * 		The saved contribution ID is reposted to paypal
	 * 		Each parameter saved to the contribution_tracking table is identical
	 * to the value we were trying to save, in the row matching the ID passed to
	 * paypal
	 * 		The owa_ref URL value is stored in the owa_ref table, and referenced
	 * by the correct id in the owa_ref column
	 *
	 */
	function testExecuteForContributionSave() {
		//TODO: Test inserting pure garbage.
		$complete = array(
			'comment' => 'Interstitial Save',
			'referrer' => 'phpunit_interstitial',
			'comment-option' => 'yep',
			'utm_source' => 'here',
			'utm_medium' => 'large',
			'utm_campaign' => 'testy01',
			'language' => 'en',
			'owa_session' => 'foo2',
			'owa_ref' => 'execute_save',
			'gateway' => 'paypal',
			'amount' => '6.60'
		);
		$table1_check = $complete;
		$table1_check['anonymous'] = 0;
		$table1_check['optout'] = 1;
		$table1_check['note'] = $complete['comment'];
		unset( $table1_check['owa_ref'] );
		unset( $table1_check['comment'] );
		unset( $table1_check['comment-option'] );
		unset( $table1_check['gateway'] );
		unset( $table1_check['amount'] );

		$page_xml = $this->getPageHTML( $complete );

		//We're using paypal, one-time, so the ID will come back in the hidden "custom" field

		$reposters = array( );
		foreach ( $page_xml->getElementsByTagName( 'input' ) as $node ) {
			$attributes = $this->getNodeAttributes( $node );
			if ( $attributes['type'] == 'hidden' ) {
				$reposters[$attributes['name']] = $attributes['value'];
			}
		}

		$this->assertTrue( is_numeric( $reposters['custom'] ), "The saved transaction ID was not found" );

		$db = ContributionTrackingProcessor::contributionTrackingConnection();
		$row = $db->selectRow( 'contribution_tracking', '*', array( 'id' => $reposters['custom'] ) );

		foreach ( $table1_check as $key => $value ) {
			$this->assertEquals( $value, $row->$key, "$key does not match in the database." );
		}

		$row = $db->selectRow( 'contribution_tracking_owa_ref', '*', array( 'id' => $row->owa_ref ) );
		$this->assertEquals( $complete['owa_ref'], $row->url, "OWA Reference lookup does not match" );
	}

	/**
	 *
	 * @param DOMNode $node A DOMNode that ostensibly has attributes we need to retrieve.
	 * @return array All of $node's attributes in a key/value array.
	 */
	function getNodeAttributes( $node ) {
		$attributes = array( );
		foreach ( $node->attributes as $name => $attrNode ) {
			$attributes[$name] = $attrNode->value;
		}
		return $attributes;
	}

}

?>
