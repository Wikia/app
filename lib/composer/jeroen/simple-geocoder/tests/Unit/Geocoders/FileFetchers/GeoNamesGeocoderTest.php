<?php

declare( strict_types = 1 );

namespace Jeroen\SimpleGeocoder\Tests\Unit\Geocoders\FileFetchers;

use FileFetcher\FileFetcher;
use FileFetcher\InMemoryFileFetcher;
use Jeroen\SimpleGeocoder\Geocoders\FileFetchers\GeoNamesGeocoder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jeroen\SimpleGeocoder\Geocoders\FileFetchers\GeoNamesGeocoder
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GeoNamesGeocoderTest extends TestCase {

	const USER_NAME = 'TestUserName';
	const NEW_YORK_FETCH_URL = 'http://api.geonames.org/search?q=New+York&maxRows=1&username=TestUserName';

	public function testHappyPath() {
		$fileFetcher = new InMemoryFileFetcher(
			[
				self::NEW_YORK_FETCH_URL
				=> '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<geonames style="MEDIUM">
<totalResultsCount>82194</totalResultsCount>
<geoname>
<toponymName>New York City</toponymName>
<name>New York</name>
<lat>40.71427</lat>
<lng>-74.00597</lng>
<geonameId>5128581</geonameId>
<countryCode>US</countryCode>
<countryName>United States</countryName>
<fcl>P</fcl>
<fcode>PPL</fcode>
</geoname>
</geonames>'
			]
		);

		$geocoder = $this->newGeocoder( $fileFetcher );

		$this->assertSame( 40.71427, $geocoder->geocode( 'New York' )->getLatitude() );
		$this->assertSame( -74.00597, $geocoder->geocode( 'New York' )->getLongitude() );
	}

	private function newGeocoder( FileFetcher $fileFetcher ) {
		return new GeoNamesGeocoder( $fileFetcher, self::USER_NAME );
	}

	public function testWhenFetcherThrowsException_nullIsReturned() {
		$geocoder = $this->newGeocoder( new InMemoryFileFetcher( [] ) );

		$this->assertNull( $geocoder->geocode( 'New York' ) );
	}

	/**
	 * @dataProvider invalidResponseProvider
	 */
	public function testWhenFetcherReturnsInvalidResponse_nullIsReturned( string $invalidResponse ) {
		$geocoder = $this->newGeocoder(
			new InMemoryFileFetcher(
				[
					self::NEW_YORK_FETCH_URL => $invalidResponse
				]
			)
		);

		$this->assertNull( $geocoder->geocode( 'New York' ) );
	}

	public function invalidResponseProvider() {
		yield 'Not XML' => [ '~=[,,_,,]:3' ];

		yield 'Missing latitude key' => [
			'<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<geonames style="MEDIUM">
<totalResultsCount>82194</totalResultsCount>
<geoname>
<toponymName>New York City</toponymName>
<name>New York</name>
<lng>-74.00597</lng>
<geonameId>5128581</geonameId>
<countryCode>US</countryCode>
<countryName>United States</countryName>
<fcl>P</fcl>
<fcode>PPL</fcode>
</geoname>
</geonames>'
		];
	}

}
