<?php
/**
 * DataTransclusion Source base class
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
 * Baseclass representing a source of data transclusion. All logic for addressing, fetching, decoding and filtering
 * data is encapsulated by a subclass of DataTransclusionSource. Instances of DataTransclusionSource are instantiated
 * by DataTransclusionHandler, and initialized by passing an associative array of options to the constructor. This array
 * is taken from the $wgDataTransclusionSources configuration variable.
 *
 * Below is a list of options for the $spec array, as handled by the DataTransclusionSource
 * base class (sublcasses may handle additional options):
 *
 *	 * $spec['name']: the source's name, used to specify it in wiki text.
 *		Set automatically by DataTransclusionHandler. REQUIRED.
 *	 * $spec['keyFields']: list of fields that can be used as the key
 *		for fetching a record. REQUIRED.
 *	 * $spec['optionNames']: names of option that can be specified in addition
 *		to a key, to refine the output. Optional.
 *	 * $spec['fieldNames']: names of all fields present in each record.
 *		Fields not listed here will not be available on the wiki,
 *		even if they are returned by the data source. If not given, this defaults to
 *		$spec['keyFields'] + array_keys( $spec['fieldInfo'] ).
 *	 * $spec['fieldInfo']: Assiciative array mapping logical field names to additional
 *		information for using and interpreting these fields. Different data sources
 *		may allow different hints for each field. The following hints are known per
 *		default:
 *	     * $spec['fieldInfo'][$field]['type']: specifies the data types for the field:
 *		'int' for integers, 'float' or 'decimal' for decimals, or 'string' for
 *		string fields. Serialization types 'json', 'wddx' and 'php' are also
 *		supported. Defaults to 'string'.
 *	     * $spec['fieldInfo'][$field]['normalization']: normalization to be applied for
 *		this field, when used as a query key. This may be a callable, or an object
 *		that supports the function normalize(), or a regular expression for patterns
 *		to be removed from the value.
 *	 * $spec['cacheDuration']: the number of seconds a result from this source
 *		may be cached for. If not set, results are assumed to be cacheable
 *		indefinitely. This setting determines the expiry time of the parser
 *		cache entry for pages that show data from this source. If $spec['cache'],
 *		i.e. if this DataTransclusionSource is wrapped by an instance of
 *		CachingDataTransclusionSource, $spec['cacheDuration'] also determines
 *		the expiry time of ObjectCache entries for records from this source.
 *	 * $spec['sourceInfo']: associative array of information about the data source
 *		that should be made available on the wiki. This information will be
 *		present in the record arrays as passed to the template.
 *		This is intended to allow information about source, license, etc to be
 *		shown on the wiki. Note that DataTransclusionSource implementations may
 *		provide extra information in the source info on their own: This base
 *		class forces $spec['sourceInfo']['source-name'] = $spec['name'].
 *	 * $spec['transformer']: a record transformer specification. This may be an
 *		instance of RecordTransformer, or an associative array specifying a
 *		record transformer which can then be created using
 *		RecordTransformer::newRecordTransformer. In that case,
 *		$spec['transformer']['class'] must be the class name of the desired
 *		RecordTransformer implementation. Other entries in that array are
 *		specific to the individual transformers.
 *
 * Options used by DataTransclusionHandler but ignored by DataTransclusionSource:
 *	 * $spec['class']: see documentation if $wgDataTransclusionSources in DataTransclusion.
 *	 * $spec['cache']: see documentation if $wgDataTransclusionSources in DataTransclusion.
 *
 * Lists may be given as arrays or strings with items separated by [,;|].
 */
abstract class DataTransclusionSource {
	static function splitList( $s, $chars = ',;|' ) {
		if ( $s === null || $s === false ) {
			return $s;
		}

		if ( !is_string( $s ) ) {
			return $s;
		}

		$list = preg_split( '!\s*[' . $chars . ']\s*!', $s );

		return $list;
	}

	/**
	 * Initializes the DataTransclusionSource from the given parameter array.
	 * @param $spec associative array of options. See class-level documentation for details.
	 */
	function __construct( $spec ) {
		$this->name = $spec[ 'name' ];

		wfDebugLog( 'DataTransclusion', "constructing " . get_class( $this ) . " \"{$this->name}\"\n" );

		$this->keyFields = self::splitList( $spec[ 'keyFields' ] );
		$this->optionNames = self::splitList( @$spec[ 'optionNames' ] );

		if ( isset( $spec[ 'fieldInfo' ] ) ) {
			$this->fieldInfo = $spec[ 'fieldInfo' ];
		} else {
			$this->fieldInfo = null;
		}

		if ( isset( $spec[ 'fieldNames' ] ) ) {
			$this->fieldNames = self::splitList( $spec[ 'fieldNames' ] );
		} elseif ( isset( $spec[ 'fieldInfo' ] ) ) {
			$this->fieldNames = array_keys( $spec[ 'fieldInfo' ] );
		} else {
			$this->fieldNames = $this->keyFields;

			if ( !empty( $this->fieldInfo ) ) {
				$this->fieldNames = array_merge( $this->fieldNames, array_keys( $this->fieldInfo ) );
			}

			$this->fieldNames = array_unique( $this->fieldNames );
		}

		if ( !empty( $spec[ 'cacheDuration' ] ) ) {
			$this->cacheDuration = (int)$spec[ 'cacheDuration' ];
		} else {
			$this->cacheDuration = null;
		}

		if ( !empty( $spec[ 'transformer' ] ) ) {
			if ( is_array( $spec[ 'transformer' ] ) ) {
				$this->transformer = RecordTransformer::newRecordTransformer( $spec[ 'transformer' ] );
			} else {
				$this->transformer = $spec[ 'transformer' ];
			}
		} else {
			$this->transformer = null;
		}

		$this->sourceInfo = array();

		if ( !empty( $spec[ 'sourceInfo' ] ) ) {
			foreach ( $spec[ 'sourceInfo' ] as $k => $v ) {
				$this->sourceInfo[ $k ] = $v;
			}
		}

		$this->sourceInfo[ 'source-name' ] = $this->name; // force this one
	}

	public function normalize( $key, $value, $norm = null ) {
		if ( $norm );
		elseif ( isset( $this->fieldInfo[ $key ]['normalization'] ) ) {
			$norm = trim( $this->fieldInfo[ $key ]['normalization'] );
		} else {
			return $value;
		}

		if ( is_object( $norm ) ) {
			return $norm->normalize( $value );
		} elseif ( is_callable( $norm ) || preg_match( '/^(\w[\w\d]*::)?(\w[\w\d]*)$/', $norm ) ) {
			return call_user_func( $norm, $value );
		} elseif ( is_array( $norm ) ) {
			return preg_replace( $norm[0], $norm[1], $value );
		} else {
			return preg_replace( $norm, '', $value );
		}
	}

	public function convert( $key, $value, $format = null ) {
		if ( $format );
		elseif ( isset( $this->fieldInfo[ $key ]['type'] ) ) {
			$format = strtolower( trim( $this->fieldInfo[ $key ]['type'] ) );
		} else {
			return (string)$value;
		}

		if ( $format == 'int' ) {
			return (int)$value;
		} elseif ( $format == 'decimal' || $format == 'float' ) {
			return (float)$value;
		} elseif ( $format == 'json' || $format == 'js' ) {
			return DataTransclusionSource::decodeJson( $value );
		} elseif ( $format == 'wddx' ) {
			return DataTransclusionSource::decodeWddx( $value );
		} elseif ( $format == 'xml' ) {
			return DataTransclusionSource::parseXml( $value ); #WARNING: returns DOM
		} elseif ( $format == 'php' || $format == 'pser' ) {
			return DataTransclusionSource::decodeSerialized( $value );
		} else {
			return (string)$value;
		}
	}


	public function getName() {
		return $this->name;
	}

	public function getSourceInfo() {
		return $this->sourceInfo;
	}

	public function getKeyFields() {
		return $this->keyFields;
	}

	public function getOptionNames() {
		return $this->optionNames;
	}

	public function getFieldNames() {
		return $this->fieldNames;
	}

	public function getCacheDuration() {
		return $this->cacheDuration;
	}

	public abstract function fetchRawRecord( $field, $value, $options = null );

	public function fetchRecord( $field, $value, $options = null ) {
		$value = $this->normalize( $field, $value );
		$value = $this->convert( $field, $value );

		$rec = $this->fetchRawRecord( $field, $value, $options );

		if ( $this->transformer ) {
			$rec = $this->transformer->transform( $rec );
		}

		return $rec;
	}

	public static function decodeSerialized( $raw ) {
		return unserialize( $raw );
	}

	public static function decodeJson( $raw ) {
		$raw = preg_replace( '/^\s*(var\s)?\w([\w\d]*)\s+=\s*|\s*;\s*$/sim', '', $raw);
		return FormatJson::decode( $raw, true );
	}

	public static function decodeWddx( $raw ) {
		return wddx_unserialize( $raw );
	}

	public static function parseXml( $raw ) {
		$dom = new DOMDocument();
		$dom->loadXML( $raw );

		#NOTE: returns a DOM, RecordTransformer must be aware!
		return $dom->documentElement;
	}
}

/**
 * Implementation of DataTransclusionSource that wraps another DataTransclusionSource and applies caching in an
 * ObjectCache. All methods delegate to the underlieing data source, fetchRecord adds logic for caching.
 */
class CachingDataTransclusionSource extends DataTransclusionSource {

	/**
	 * Initializes the CachingDataTransclusionSource
	 *
	 * @param $source a DataTransclusionSource instance for fetching data records.
	 * @param $cache an ObjectCache instance
	 * @param $duration number of seconds for which records may be cached
	 */
	function __construct( $source, $cache, $duration ) {
		$this->source = $source;
		$this->cache = $cache;
		$this->duration = $duration;
	}

	public function getName() {
		return $this->source->getName();
	}

	public function getSourceInfo() {
		return $this->source->getSourceInfo();
	}

	public function getKeyFields() {
		return $this->source->getKeyFields();
	}

	public function getOptionNames() {
		return $this->source->getOptionNames();
	}

	public function getFieldNames() {
		return $this->source->getFieldNames();
	}

	public function getCacheDuration() {
		return $this->source->getCacheDuration();
	}

	public function fetchRawRecord( $field, $value, $options = null ) {
		throw new MWException( "not implemented" );
	}

	public function fetchRecord( $field, $value, $options = null ) {
		global $wgDBname, $wgUser;

		$k = "$field=$value";
		if ( $options ) {
			$k .= "&" . sha1( var_export( $options, false ) );
		}

		$cacheKey = "$wgDBname:DataTransclusion(" . $this->getName() . ":$k)";

		$rec = $this->cache->get( $cacheKey );

		if ( !$rec ) {
			wfDebugLog( 'DataTransclusion', "fetching fresh record for $field=$value\n" );
			$rec = $this->source->fetchRecord( $field, $value, $options );

			if ( $rec ) { // XXX: also cache negatives??
				$duration = $this->getCacheDuration();

				wfDebugLog( 'DataTransclusion', "caching record for $field=$value for $duration sec\n" );
				$this->cache->set( $cacheKey, $rec, $duration ) ;
			}
		} else {
			wfDebugLog( 'DataTransclusion', "using cached record for $field=$value\n" );
		}

		return $rec;
	}
}

/**
 * Implementations of DataTransclusionSource which simply fetches data from an array. This is
 * intended mainly for testing and debugging.
 */
class FakeDataTransclusionSource extends DataTransclusionSource {

	/**
	 * Initializes the CachingDataTransclusionSource
	 *
	 * @param $spec an associative array of options. See class-level
	 *		documentation of DataTransclusionSource for details.
	 *
	 * @param $data an array containing a list of records. Records from
	 *		this list can be accessed via fetchRecord() using the key fields specified
	 *		by $spec['keyFields']. If $data is not given, $spec['data'] must contain the data array.
	 */
	function __construct( $spec, $data = null ) {
		DataTransclusionSource::__construct( $spec );

		if ( $data === null ) {
			$data = $spec[ 'data' ];
		}

		$this->lookup = array();

		foreach ( $data as $rec ) {
			$this->putRecord( $rec );
		}
	}

	public function putRecord( $record ) {
		$fields = $this->getKeyFields();
		foreach ( $fields as $f ) {
			$k = $record[ $f ];
			if ( !isset( $this->lookup[ $f ] ) ) {
				$this->lookup[ $f ] = array();
			}

			$this->lookup[ $f ][ $k ] = $record;
		}
	}

	public function fetchRawRecord( $field, $value, $options = null ) {
		return @$this->lookup[ $field ][ $value ];
	}
}
