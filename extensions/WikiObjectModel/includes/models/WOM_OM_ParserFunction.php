<?php
/**
 * This model implements Parser Function models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */
class WOMParserFunctionModel extends WikiObjectModelCollection {
	protected $m_function_key;

	public function __construct( $function_key ) {
		parent::__construct( WOM_TYPE_PARSERFUNCTION );
		$this->m_function_key = $function_key;
	}

	public function getFunctionKey() {
		return $this->m_function_key;
	}

	public function getWikiText() {
		return "{{#{$this->m_function_key}:" .
			parent::getWikiText() .
			'}}';
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

		if ( $key == 'key' ) {
			$this->m_function_key = $value;
		} else {
			throw new MWException( __METHOD__ . ": invalid key/value pair: key=function_key" );
		}
	}

	protected function getXMLAttributes() {
		return 'key="' . self::xml_entities( $this->m_function_key ) . '"';
	}
}
