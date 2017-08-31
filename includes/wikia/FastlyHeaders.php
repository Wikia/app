<?php

/**
 * Contains definitions of fastly custom headers that we may use
 *
 * @author jcellary
 */
class FastlyHeaders {

    const
		GEO_LONGITUDE = "X-GeoIP-Longitude",
		GEO_LATITUDE = "X-GeoIP-Latitude",
		GEO_CITY = "X-GeoIP-City",
		GEO_CONTINENT = "X-GeoIP-Continent-Code",
		GEO_COUNTRY_CODE = "X-GeoIP-Country-Code",
		GEO_COUNTRY_NAME = "X-GeoIP-Country-Name",
		GEO_POSTAL_CODE = "X-GeoIP-Postal-Code",
		GEO_REGION = "X-GeoIP-Region",
		GEO_AREA_CODE = "X-GeoIP-Area-Code",
		GEO_METRO_CODE = "X-GeoIP-Metro-Code";
}
