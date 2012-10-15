<?php
/**
 * This model implements Template Field Holder models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMTemplateFieldHolderModel extends WikiObjectModelCollection {
	protected $m_key;

	public function __construct( $key ) {
		parent::__construct( WOM_TYPE_TMPL_FIELD_HOLDER );
		$this->m_key = $key;
	}

	public function getKey() {
		return $this->m_key;
	}

	public function getWikiText() {
		return "{{{{$this->m_key}|{$this->getValueText()}}}}";
	}

	public function getValueText() {
		return parent::getWikiText();
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

		if ( $key == 'name' ) {
			$this->m_key = $value;
		} else {
			throw new MWException( __METHOD__ . ": invalid key/value pair: name|value_if_blank" );
		}
	}

	protected function getXMLAttributes() {
		return 'name="' . self::xml_entities( $this->m_key ) . '"';
	}
}
