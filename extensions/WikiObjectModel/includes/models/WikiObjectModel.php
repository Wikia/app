<?php
/**
 * File holding abstract class WikiObjectModel, the base for all object model in WOM.
 *
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

abstract class WikiObjectModel {
	protected $m_objid;

	protected $m_typeid;

	protected $m_parent = null;

	/**
	 * Array of error text messages. Private to allow us to track error insertion
	 * (PHP's count() is too slow when called often) by using $mHasErrors.
	 * @var array
	 */
	protected $mErrors = array();

	/**
	 * Boolean indicating if there where any errors.
	 * Should be modified accordingly when modifying $mErrors.
	 * @var boolean
	 */
	protected $mHasErrors = false;

	/**
	 * Constructor.
	 *
	 * @param string $typeid
	 */
	public function __construct( $typeid ) {
		$this->m_typeid = $typeid;
	}

// /// Set methods /////
	public function setObjectID( $id ) {
		$this->m_objid = $id;
	}

	public function setParent( $parent ) {
		$this->m_parent = $parent;
	}

// /// Get methods /////
	public function getParent() {
		return $this->m_parent;
	}

	public abstract function getWikiText();

	public function isCollection() {
		return false;
	}

	public function getObjectID() {
		return $this->m_objid;
	}

	public function getTypeID() {
		return $this->m_typeid;
	}

	public function getPreviousObject() {
		$p = $this->getParent();
		if ( $p == null ) return $p;

		$previous = null;
		foreach ( $p->getObjects() as $v ) {
			if ( $this->getObjectID() == $v->getObjectID() ) {
				return $previous;
			}
			$previous = $v;
		}
		return null;
	}

	protected function isLastLF() {
		$pre = $this->getPreviousObject();
		if ( $pre != null ) {
			$wiki = $pre->getWikiText();
			$len = strlen( $wiki );
			return ( $len == 0 || $wiki { $len - 1 } == "\n" );
		}
		return true;
	}

	/**
	 * Return TRUE if a value was defined and understood by the given type,
	 * and false if parsing errors occured or no value was given.
	 */
	public function isValid() {
		return ( ( !$this->mHasErrors ) );
	}

	/**
	 * Return a string that displays all error messages as a tooltip, or
	 * an empty string if no errors happened.
	 */
	public function getErrorText() {
		if ( defined( 'SMW_VERSION' ) )
			return smwfEncodeMessages( $this->mErrors );

		return $this->mErrors;
	}

	/**
	 * Return an array of error messages, or an empty array
	 * if no errors occurred.
	 */
	public function getErrors() {
		return $this->mErrors;
	}

	public function setXMLAttribute( $key, $value ) {
		throw new MWException( __METHOD__ . ": invalid key=value pair: no attribute required" );
	}
	protected function getXMLAttributes() {
		return "";
	}
	protected function getXMLContent() {
		return "";
	}
	public function toXML() {
		return "<{$this->m_typeid} id=\"{$this->m_objid}\" {$this->getXMLAttributes()}>{$this->getXMLContent()}</{$this->m_typeid}>";
	}

	public function objectUpdate( WikiObjectModel $obj ) { }

	static function xml_entity_decode( $text, $charset = 'Windows-1252' ) {
		// Double decode, so if the value was &amp;trade; it will become Trademark
		$text = html_entity_decode( $text, ENT_COMPAT, $charset );
		$text = html_entity_decode( $text, ENT_COMPAT, $charset );

		return $text;
	}

	static function xml_entities( $text, $charset = 'Windows-1252' ) {
		// First we encode html characters that are also invalid in xml
		$text = htmlentities( $text, ENT_COMPAT, $charset, false );
		// XML character entity array from Wiki
		// Note: &apos; is useless in UTF-8 or in UTF-16
		$arr_xml_special_char = array( "&quot;", "&amp;", "&apos;", "&lt;", "&gt;" );
		// Building the regex string to exclude all strings with xml special char
		$arr_xml_special_char_regex = "(?";

		foreach ( $arr_xml_special_char as $key => $value ) {
			$arr_xml_special_char_regex .= "(?!$value)";
		}
		$arr_xml_special_char_regex .= ")";

		// Scan the array for &something_not_xml; syntax
		$pattern = "/$arr_xml_special_char_regex&([a-zA-Z0-9]+;)/";

		// Replace the &something_not_xml; with &amp;something_not_xml;
		$replacement = '&amp;${1}';

		return preg_replace( $pattern, $replacement, $text );
	}
	static function xml_attribute_entities( $text, $charset = 'Windows-1252' ) {
		$ret = self::xml_entities( $text, $charset );
		return str_replace( "\n", '&#10;', $ret );
	}
}
