<?php
namespace Wikia\PortableInfobox\Parser;

use Wikia\Logger\WikiaLogger;

class XmlParser {
	/**
	 * @param string $xmlString XML to parse
	 *
	 * @param array $errors this array will be filled with errors if any found
	 *
	 * @return \SimpleXMLElement
	 * @throws XmlMarkupParseErrorException
	 */
	public static function parseXmlString( $xmlString, &$errors = [ ] ) {
		$global_libxml_setting = libxml_use_internal_errors();
		libxml_use_internal_errors( true );
		// support for html entities and single & char
		$decoded = str_replace( '&', '&amp;', html_entity_decode( $xmlString ) );
		$xml = simplexml_load_string( $decoded );
		$errors = libxml_get_errors();
		libxml_use_internal_errors( $global_libxml_setting );

		if ( $xml === false ) {
			foreach ( $errors as $xmlerror ) {
				self::logXmlParseError( $xmlerror->level, $xmlerror->code, trim( $xmlerror->message ) );
			}
			libxml_clear_errors();
			throw new XmlMarkupParseErrorException( $errors );
		}

		return $xml;
	}

	protected static function logXmlParseError( $level, $code, $message ) {
		WikiaLogger::instance()->info( "PortableInfobox XML Parser problem", [
			"level" => $level,
			"code" => $code,
			"message" => $message ] );
	}

}

class XmlMarkupParseErrorException extends \Exception {
	private $errors;

	public function __construct( $errors ) {
		$this->errors = $errors;

		return parent::__construct();
	}

	public function getErrors() {
		return $this->errors;
	}
}
