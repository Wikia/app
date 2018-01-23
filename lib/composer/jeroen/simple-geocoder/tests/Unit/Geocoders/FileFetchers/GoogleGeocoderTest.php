<?php

declare( strict_types = 1 );

namespace Jeroen\SimpleGeocoder\Tests\Unit\Geocoders\FileFetchers;

use FileFetcher\FileFetcher;
use FileFetcher\InMemoryFileFetcher;
use Jeroen\SimpleGeocoder\Geocoders\FileFetchers\GoogleGeocoder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jeroen\SimpleGeocoder\Geocoders\FileFetchers\GoogleGeocoder
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GoogleGeocoderTest extends TestCase {

	const API_KEY = 'TestApiKey';
	const NEW_YORK_FETCH_URL = 'https://maps.googleapis.com/maps/api/geocode/json?address=New+York&key=TestApiKey';

	public function testHappyPath() {
		$fileFetcher = new InMemoryFileFetcher(
			[
				self::NEW_YORK_FETCH_URL
				=> '{
   "results" : [
      {
         "address_components" : [
            {
               "long_name" : "New York",
               "short_name" : "New York",
               "types" : [ "locality", "political" ]
            },
            {
               "long_name" : "New York",
               "short_name" : "NY",
               "types" : [ "administrative_area_level_1", "political" ]
            },
            {
               "long_name" : "United States",
               "short_name" : "US",
               "types" : [ "country", "political" ]
            }
         ],
         "formatted_address" : "New York, NY, USA",
         "geometry" : {
            "bounds" : {
               "northeast" : {
                  "lat" : 40.9175771,
                  "lng" : -73.70027209999999
               },
               "southwest" : {
                  "lat" : 40.4773991,
                  "lng" : -74.25908989999999
               }
            },
            "location" : {
               "lat" : 40.7127837,
               "lng" : -74.0059413
            },
            "location_type" : "APPROXIMATE",
            "viewport" : {
               "northeast" : {
                  "lat" : 40.9175771,
                  "lng" : -73.70027209999999
               },
               "southwest" : {
                  "lat" : 40.4773991,
                  "lng" : -74.25908989999999
               }
            }
         },
         "place_id" : "ChIJOwg_06VPwokRYv534QaPC8g",
         "types" : [ "locality", "political" ]
      }
   ],
   "status" : "OK"
}'
			]
		);

		$geocoder = $this->newGeocoder( $fileFetcher );

		$this->assertSame( 40.7127837, $geocoder->geocode( 'New York' )->getLatitude() );
		$this->assertSame( -74.0059413, $geocoder->geocode( 'New York' )->getLongitude() );
	}

	private function newGeocoder( FileFetcher $fileFetcher ) {
		return new GoogleGeocoder( $fileFetcher, self::API_KEY, '' );
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
		yield 'Not JSON' => [ '~=[,,_,,]:3' ];
		yield 'Empty JSON' => [ '{}' ];
		yield 'Empty results section' => [ '{"results":[]}' ];
		yield 'Result without expected keys' => [ '{"results":[ {} ]}' ];
		yield 'Location without expected keys' => [ '{"results":[ {"geometry": {"location": {}}} ]}' ];
	}

}
