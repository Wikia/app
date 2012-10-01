<?php 

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchTest extends WikiaSearchBaseTest {
	
	public function testFieldMethods() {
		
		// this is a supported language code
		$supportedLanguageCode = 'en';
		$this->mockGlobalVariable( 'wgLanguageCode', 					$supportedLanguageCode );
		$this->mockGlobalVariable( 'wgWikiaSearchSupportedLanguages',	array( 'en' ) );
		
		// The following rules apply only to supported languages
		
		// A field that is not dynamic should default to its field name
		$nonDynamicField	= 'backlinks'; // integer value of number of backlinks
		$nonDynamicOutput	= WikiaSearch::field( $nonDynamicField );
		$this->assertEquals( $nonDynamicField, $nonDynamicOutput, 
							'A non-dynamic field was mutated during WikiaSearch::field()' );
		
		// A field that is dynamic should have the language code appended
		$dynamicField			= 'html';
		$dynamicOutput			= WikiaSearch::field( $dynamicField );
		$expectedDynamicOutput	= 'html_en';
		$this->assertEquals( $dynamicOutput, $expectedDynamicOutput, 
							'A basic dynamic field did not have its language code appended during WikiaSearch::field()' );
		
		
		// A field that is dynamic unstored should have '_us' and the language code appended
		$dynamicUnstoredField			= 'first500';
		$dynamicUnstoredOutput			= WikiaSearch::field( $dynamicUnstoredField );
		$expectedDynamicUnstoredOutput	= 'first500_us_en';
		$this->assertEquals( $dynamicUnstoredOutput, $expectedDynamicUnstoredOutput, 
							'An unstored dynamic field did not have the appropriate suffixes appended during WikiaSearch::field()' );
		
		// A field that is dynamic and multivalued should have '_mv' and the language code appended
		$dynamicMultiValuedField			= 'categories';
		$dynamicMultiValuedOutput			= WikiaSearch::field( $dynamicMultiValuedField );
		$expectedDynamicMultiValuedOutput	= 'categories_mv_en';
		$this->assertEquals( $dynamicMultiValuedOutput, $expectedDynamicMultiValuedOutput,
		        			'An dynamic multivalued field did not have the appropriate suffixes appended during WikiaSearch::field()' );
		
		// A field that is dynamic, unstored, and multivalued should have '_us_mv' and the language code appended
		$dynamicMultiValuedUnstoredField			= 'headings';
		$dynamicMultiValuedUnstoredOutput			= WikiaSearch::field( $dynamicMultiValuedUnstoredField );
		$expectedDynamicMultiValuedUnstoredOutput	= 'headings_us_mv_en';
		$this->assertEquals( $dynamicMultiValuedOutput, $expectedDynamicMultiValuedOutput,
		        			'An dynamic unstored multivalued field did not have the appropriate suffixes appended during WikiaSearch::field()' );
		
		// I just made this language code up.
		global $wgLanguageCode;
		$wgLanguageCode = 'zz';
		// When a language isn't supported, all of the above cases should return the actual name of the field
		foreach ( array( 'backlinks', 'html', 'first500', 'categories', 'headings') as $field ) {
			$this->assertEquals( $field, WikiaSearch::field( $field ), 'An unsupported language returned mutated fields from WikiaSearch::field()' );
		}
		
	}
	
}