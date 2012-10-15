<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "XMLRC extension";
	exit( 1 );
}

/**
 * Class for handling the RecentChange_save hook. This is the core of XMLRC.
 */
class XMLRC {
	var $main;
	var $query;
	var $format;
	var $transport;
	var $filter;
	var $props;

	/**
	 * Creates a new instance of XMLRC.
	 *
	 * @param $transportConfig Array: associative array containing the config/spec for the transport class
	 *              to use for sending notifications. The key 'class' in this array must refer to a class
	 *              that extends XMLRC_Transport. Other entries in the array are specific to the individual
	 *              transport implementations. The $transportConfig array will be passed to the transport
	 *              instance of initialization.
	 *
	 * @param $params Array: a list of RecentChange-parameters to include in the XML output. The flags used
	 *              in the list are the once accepted by the API for the rcparams attribute. This value
	 *              may also be given as a string, where the flags are separated by pipe characters ("|").
	 */
	public function __construct( $transportConfig, $props = null ) {
		$this->transportConfig = $transportConfig;
		$this->props = $props;
	}

	/**
	 * Static handler for the RecentChange_save hook. Creates a new instance of XMLRC, using the
	 * $wgXMLRCTransport and $wgXMLRCProperties configuration variables. Once the instance is
	 * created, processRecentChange( $rc ) is called on it.
	 *
	 * @param $rc Object: an instance of RecentChange representing an event that just occurred on
	 *               the wiki.
	 * @return Boolean: always true to continue processing
	 */
	public static function RecentChange_save( $rc ) {
		global $wgXMLRCTransport, $wgXMLRCProperties;

		if ( $wgXMLRCTransport ) {
			$xmlrc = new XMLRC( $wgXMLRCTransport, $wgXMLRCProperties );
			$xmlrc->processRecentChange( $rc );
		}

		return true; // continue processing normally
	}

	/**
	 * Effective handler function for the RecentChange_save hook. It creates an XML representation
	 * of $rc using the method formatRecentChange(), and then passes it to sendRecentChangeXML(),
	 * so it may be send out.
	 *
	 * @param $rc Object: an instance of RecentChange representing an event that just occurred on
	 *               the wiki.
	 */
	public function processRecentChange( $rc ) {
		$xml = $this->formatRecentChange( $rc );
		$this->sendRecentChangeXML( $xml );
	}

	/**
	 * Returns the XMLRC_Transport instance for this XMLRC object. The transport is initialized
	 * lazily using the config array passed to the constructor of XMLRC as $transportConfig:
	 * on the first call to this funtion, it creates a transport object of the type specified by
	 * the 'class' key in the config array, and passes that array to the constructor of that class.
	 *
	 * @return object An instance of XMLRC_Transport.
	 */
	private function getTransport() {
		if ( $this->transport != null ) {
			return $this->transport;
		}

		$class = $this->transportConfig['class'];
		$this->transport = new $class( $this->transportConfig );

		return $this->transport;
	}

	/**
	 * @return an instance of ApiMain.
	 */
	private function getMainModule() {
		if ( $this->main != null ) return $this->main;

		$req = new FauxRequest( array() );
		$this->main = new ApiMain( $req );

		return $this->main;
	}

	/**
	 * @return an instance of ApiFormatXml.
	 */
	private function getFormatModule() {
		if ( $this->format != null ) {
			return $this->format;
		}

		$main = $this->getMainModule();
		$this->format = new ApiFormatXml( $main, 'xml' );

		return $this->format;
	}

	/**
	 * Returns an instance of ApiQueryRecentChanges, configured to return the properties
	 * specified in the $props argument to the constructor of XMLRC.
	 */
	private function getQueryModule() {
		if ( $this->query != null ) {
			return $this->query;
		}

		$main = $this->getMainModule();
		$this->query = new ApiQueryRecentChanges( $main, 'recentchanges' );

		$prop = $this->props;

		if ( !$prop ) {
			$prop = 'title|timestamp|ids'; // default taken from the API
		}

		if ( is_string( $prop ) ) {
			$prop = preg_split( '!\\s*[,;/|+]\\s*!', $prop );
		}

		foreach ( $prop as $k => $v ) {
			if ( is_int( $k ) ) {
				unset( $prop[$k] );
				$prop[$v] = true;
			}
		}

		unset( $prop['patrolled'] ); // restricted info, don't publish. API denies it.

		$this->query->initProperties( $prop );

		return $this->query;
	}

	/**
	 * Utility function for creating an anonymous object from an associative array.
	 */
	public static function array2object( $data ) {
		$obj = new stdClass();

		foreach ( $data as $key => $value ) {
			$obj->$key = $value;
		}

		return $obj;
	}

	/**
	 * Generates an XML representation from the RecentChange object. It uses the API modules
	 * returned by getQueryModule() and getFormatModule(), for extracting the appropriate data
	 * and turning it into XML, respectively.
	 *
	 * @param $rc Object: an instance of RecentChange
	 *
	 * @return string an XML representation of $rc
	 */
	public function formatRecentChange( $rc ) {
		$query = $this->getQueryModule();
		$format = $this->getFormatModule();

		$row = $rc->getAttributes();
		$row = XMLRC::array2object( $row );

		#wfDebugLog( 'XMLRC', 'got attribute row: ' . preg_replace( '/\s+/', ' ', var_export( $row, true ) ) . "\n" );

		$info = $query->extractRowInfo( $row );
		$info['wikiid'] = wfWikiID();

		#wfDebugLog( 'XMLRC', 'got info: ' . preg_replace( '/\s+/', ' ', var_export( $info, true ) ) . "\n" );

		$xml = $format->recXmlPrint( 'rc', $info, '' );
		$xml = trim( $xml );

		return $xml;
	}

	/**
	 * Sends a chunk of XML using the transport object returned by getTransport().
	 *
	 * @param $xml String: the XML to send out
	 */
	public function sendRecentChangeXML( $xml ) {
		wfDebugLog( 'XMLRC', "sending xml\n" );

		$transport = $this->getTransport();
		$transport->send( $xml );
	}
}

/**
 * Abstract base class for transport implementations.
 */
abstract class XMLRC_Transport {

	/**
	 * Implementations of this method shall send $xml somewhere.
	 *
	 * @param $xml String: the XML to send out
	 */
	abstract function send( $xml );
}
