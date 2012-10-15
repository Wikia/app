<?php
/**
 * DataTransclusion Source implementation
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler for Wikimedia Deutschland
 * @copyright © 2010 Wikimedia Deutschland (Author: Daniel Kinzler)
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
 * Implementations of DataTransclusionSource, fetching data records via HTTP,
 * usually from an web API.
 *
 * In addition to the options supported by the DataTransclusionSource base class,
 * WebDataTransclusionSource accepts some additional options
 *
 *	 * $spec['url']: base URL for building urls for retrieving individual records.
 *		If the URL contains placeholders of the form {xxx}, these get replaced
 *		by the respective key or option values.
 *		Otherwise, the key/value pair and options get appended to the URL as a
 *		regular URL parameter (preceeded by ? or &, as appropriate). For more
 *		complex rules for building the url, override getRecordURL(). REQUIRED.
 *	 * $spec['dataFormat']: Serialization format returned from the web service.
 *		Supported values are 'php' for PHP serialization format, 'json'
 *		for JavaScript syntax, and 'wddx' for XML-based list/dicts.
 *		'xml' is supported, but requires a transformer that can handle an XML DOM
 * 		as input. To support more formats, override decodeData(). Default is 'php'.
 *	 * $spec['dataPath']: "path" to the actual data in the structure returned from the
 *		HTTP request. This is only used if no transformer is set. The syntax of the
 *		path is the one defined for the dataPath parameter for the FlattenRecord
 *		transformer. REQUIRED if no transformer is defined.
 *	 * $spec['errorPath']: "path" to error messages in the structure returned from the
 *		HTTP request. This is only used if no transformer is set. The syntax of the
 *		path is the one defined for the dataPath parameter for the FlattenRecord
 *		transformer. REQUIRED if no transformer is defined.
 *	 * $spec['httpOptions']: array of options to pass to Http::get. For details, see Http::request.
 *	 * $spec['timeout']: seconds before the request times out. If not given,
 *		$spec['httpOptions']['timeout'] is used. If both are not givern, 5 seconds are assumed.
 *
 * For more information on options supported by DataTransclusionSource, see the class-level
 * documentation there.
 */
class WebDataTransclusionSource extends DataTransclusionSource {

	function __construct( $spec ) {
		DataTransclusionSource::__construct( $spec );

		$this->url = $spec[ 'url' ];
		$this->dataPath = @$spec[ 'dataPath' ];
		$this->errorPath = @$spec[ 'errorPath' ];
		$this->dataFormat = @$spec[ 'dataFormat' ];
		$this->fieldPathes = @$spec[ 'fieldPathes' ];
		$this->httpOptions = @$spec[ 'httpOptions' ];
		$this->timeout = @$spec[ 'timeout' ];

		if ( !$this->dataFormat ) {
			$this->dataFormat = 'php';
		}

		if ( $this->dataFormat == 'xml' ) {
			if ( !$this->transformer ) throw new MWException( "XML-Based formats require a record transformer" );
		}

		if ( !$this->timeout ) {
			$this->timeout = &$this->httpOptions[ 'timeout' ];
		}

		if ( !$this->timeout ) {
			$this->timeout = 5;
		}
	}

	public function fetchRawRecord( $field, $value, $options = null ) {
		$raw = $this->loadRecordData( $field, $value, $options );
		if ( !$raw ) {
			wfDebugLog( 'DataTransclusion', "failed to fetch data for $field=$value\n" );
			return false;
		}

		$data = $this->decodeData( $raw, $this->dataFormat );
		if ( !$data ) {
			wfDebugLog( 'DataTransclusion', "failed to decode data for $field=$value as {$this->dataFormat}\n" );
			return false;
		}

		$err = $this->extractError( $data );
		if ( $err ) {
			wfDebugLog( 'DataTransclusion', "error message when fetching $field=$value: $err\n" );
			return false;
		}

		$rec = $this->extractRecord( $data );
		if ( !$rec ) {
			wfDebugLog( 'DataTransclusion', "no record found in data for $field=$value\n" );
			return false;
		}

		wfDebugLog( 'DataTransclusion', "loaded record for $field=$value from URL\n" );
		return $rec;
	}

	public function getRecordURL( $field, $value, $options = null ) {
		$u = $this->url;

		$args = array( $field => $value );

		if ( $options ) {
			$args = array_merge( $options, $args );
		}

		foreach ( $args as $k => $v ) {
			$u = str_replace( '{'.$k.'}', urlencode( $v ), $u, $n );

			if ( $n ) { //was found and replaced
				unset( $args[ $k ] );
			}
		}

		$u = preg_replace( '/\{.*?\}/', '', $u ); //strip remaining placeholders

		foreach ( $args as $k => $v ) {
			if ( strpos( $u, '?' ) === false ) {
				$u .= '?';
			} else {
				$u .= '&';
			}

			$u .= urlencode( $k );
			$u .= '=';
			$u .= urlencode( $v );
		}

		return $u;
	}

	public function loadRecordData( $field, $value, $options ) {
		$u = $this->getRecordURL( $field, $value, $options );
		return $this->loadRecordDataFromURL( $u );
	}

	public function loadRecordDataFromURL( $u ) {
		if ( preg_match( '!^https?://!', $u ) ) {
			$raw = Http::get( $u, $this->timeout, $this->httpOptions );
		} else {
			$raw = file_get_contents( $u );
		}

		if ( $raw ) {
			wfDebugLog( 'DataTransclusion', "loaded " . strlen( $raw ) . " bytes of data from $u\n" );
		} else {
			wfDebugLog( 'DataTransclusion', "failed to load data from $u\n" );
		}

		return $raw;
	}

	public function decodeData( $raw, $format = null ) {
		if ( $format === null ) {
			$format = $this->dataFormat;
		}

		if ( $format == 'json' || $format == 'js' ) {
			return DataTransclusionSource::decodeJson( $raw );
		} elseif ( $format == 'wddx' ) {
			return DataTransclusionSource::decodeWddx( $raw );
		} elseif ( $format == 'xml' ) {
			return DataTransclusionSource::parseXml( $raw );
		} elseif ( $format == 'php' || $format == 'pser' ) {
			return DataTransclusionSource::decodeSerialized( $raw );
		}

		return false;
	}

	public function extractError( $data ) {
		if ( $this->transformer ) {
		    $err = $this->transformer->extractError( $data );
		} else {
		    $err = FlattenRecord::naiveResolvePath( $data, $this->errorPath );
		    $err = FlattenRecord::naiveAsString( $err );
		}

		return $err;
	}

	public function extractRecord( $data ) {
		if ( $this->transformer ) {
		    $rec = $this->transformer->extractRecord( $data );
		} else {
		    $rec = FlattenRecord::naiveResolvePath( $data, $this->dataPath );
		}

		return $rec;
	}

}
