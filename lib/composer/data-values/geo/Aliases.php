<?php

// This is a IDE helper to understand class aliasing.
// It should not be included anywhere.
// Actual aliasing happens in the entry point using class_alias.

namespace {

	throw new Exception( 'This code is not meant to be executed' );

}

namespace DataValues {

	/**
	 * @since 0.1
	 * @deprecated since 1.0, use the base class instead.
	 */
	class LatLongValue extends \DataValues\Geo\Values\LatLongValue {
	}

	/**
	 * @since 0.1
	 * @deprecated since 1.0, use the base class instead.
	 * @codingStandardsIgnoreStart
	 */
	class GlobeCoordinateValue extends \DataValues\Geo\Values\GlobeCoordinateValue {
	}

}

namespace DataValues\Geo\Formatters {

	/**
	 * @since 1.0
	 * @deprecated since 2.0, use the base class instead.
	 */
	class GeoCoordinateFormatter extends \DataValues\Geo\Formatters\LatLongFormatter {
	}

}

namespace DataValues\Geo\Parsers {

	/**
	 * @since 1.0
	 * @deprecated since 2.0, use the base class instead.
	 */
	class GeoCoordinateParser extends \DataValues\Geo\Parsers\LatLongParser {
	}

}
