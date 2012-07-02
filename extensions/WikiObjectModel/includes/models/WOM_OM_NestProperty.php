<?php
/**
 * This model implements Property models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMNestPropertyModel extends WikiObjectModelCollection {
	protected $m_property; // name
	protected $m_user_property; // name

	public function __construct( $property ) {
		parent::__construct( WOM_TYPE_NESTPROPERTY );

		if ( !defined( 'SMW_VERSION' ) ) {
			// MW hook will catch this exception
			throw new MWException( __METHOD__ . ": Property model is invalid. Please install 'SemanticMediaWiki extension' first." );
		}

		$user_property = SMWPropertyValue::makeUserProperty( $property );
		if ( count ( $user_property->getErrors() ) > 0 ) {
			$user_property = SMWPropertyValue::makeUserProperty( '///NA///' );
		} else {
			$property = '';
		}

		$this->m_user_property = $user_property;
		$this->m_property = $property;
	}

	public function getProperty() {
		return $this->m_user_property;
	}

	public function setProperty( $property ) {
		$this->m_user_property = $property;
	}

	public function getPropertyName() {
		return ( $this->m_property ) ? $this->m_property : $this->m_user_property->getWikiValue();
	}

	public function getWikiText() {
		return "[[{$this->getPropertyName()}::{$this->getValueText()}]]";
	}

	public function getValueText() {
		return parent::getWikiText();
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

		if ( $key == 'name' ) {
			$property = SMWPropertyValue::makeUserProperty( $value );
		} else {
			throw new MWException( __METHOD__ . ": invalid key/value pair: name=property_name" );
		}
	}
	protected function getXMLAttributes() {
		return 'name="' . self::xml_entities( $this->getPropertyName() ) . '"';
	}
}
