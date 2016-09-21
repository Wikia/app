<?php

class Custom404PageTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/Custom404Page/Custom404Page.setup.php";
		parent::setUp();
	}

	public function dataProviderSuggestedTitles() {
		return [
			// One page only
			['Page 1', ['Page 2'], false],

			// More pages with no easy match
			['Page 1', ['Page 2', 'Page 3'], false],
			['Page 1', ['Page 10', 'Page 11'], false],
			['Page 1', ['Page 1/a', 'Page 1/b'], false],

			// Upper/lowercase
			['miss piggy', ['A page', 'Miss Piggy', 'Other page'], 'Miss Piggy'],
			['Miss piggy', ['A page', 'Miss Piggy', 'Other page'], 'Miss Piggy'],

			// Multiple choices for upper/lowercase
			['Miss piggy', ['A page', 'Miss Piggy', 'Miss PIGGY', 'Other page'], false],

			// Missing character (prefix matches)
			['Miss Pigg', ['A page', 'Miss Piggy', 'Other page'], 'Miss Piggy'],
			['Miss Piggy', ['A page', 'Miss Piggy!', 'Other page'], 'Miss Piggy!'],

			// Missing character vs mismatching case
			['Miss piggy', ['A page', 'Miss Piggy', 'Miss piggy!', 'Other page'], 'Miss Piggy'],

			// Extra/missing non-alphanumerical characters mismatch
			['John Fitzgerald Kennedy', ['A page', 'John (Fitzgerald) Kennedy', 'Other page'], 'John (Fitzgerald) Kennedy'],
			['John (Fitzgerald) Kennedy', ['A page', 'John Fitzgerald Kennedy', 'Other page'], 'John Fitzgerald Kennedy'],

			// Subpages -- chose the page that doesn't contain a "/" in the reminder
			['Miss Pig', ['A page', 'Miss Piggy', 'Miss Piggy/Page 1', 'Miss Piggy/Page 2', 'Miss Piggy/Page 1/Page 2', 'Other page'], 'Miss Piggy'],
			['Miss Piggy/Page', ['A page', 'Miss Piggy/Page 1', 'Miss Piggy/Page 1/Page 2', 'Miss Piggy/Page 1/Page 3', 'Other page'], 'Miss Piggy/Page 1'],

			// ... Unless it's the only match
			['Miss Piggy/Page', ['A page', 'Miss Piggy/Page 1/Page 2', 'Other page'], 'Miss Piggy/Page 1/Page 2'],
		];
	}

	/**
	 * Test findTheBestMatchingTitleText
	 *
	 * @covers Custom404PageBestMatchingPageFinder::findTheBestMatchingTitleText
	 * @dataProvider dataProviderSuggestedTitles
	 *
	 * @param $originalTitle   string the original title
	 * @param $suggestedTitles array  array of titles matching according to the Solr search
	 * @param $expectedOut     mixed  the expected title selected
	 */
	public function testFindTheBestMatchingTitleText( $originalTitle, $suggestedTitles, $expectedOut ) {
		$pageFinder = new Custom404PageBestMatchingPageFinder();
		$actualOut = $pageFinder->findTheBestMatchingTitleText( $originalTitle, $suggestedTitles );
		$this->assertEquals( $expectedOut, $actualOut );
	}
}
