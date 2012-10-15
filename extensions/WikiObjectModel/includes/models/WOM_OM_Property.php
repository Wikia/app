<?php
/**
 * This model implements Property models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMPropertyModel extends WikiObjectModel {
	protected $m_property; // name
	protected $m_value;
	protected $m_caption;
	protected $m_user_property; // name
	protected $m_smwdatavalue; // value, caption, type
	protected $m_visible;

	public function __construct( $property, $value, $caption = '' ) {
		parent::__construct( WOM_TYPE_PROPERTY );

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
		$smwdatavalue = null;
		// FIXME: property should be collection object according to templates
		// if template/field used
		if ( preg_match ( '/\{\{.+\}\}/s', $value . $caption ) ) {
			$value = $value . ( $caption == '' ? '' : "|{$caption}" );
			$caption = '';
		} else {
			if ( version_compare ( SMW_VERSION, '1.6', '>=' ) ) {
				$smwdatavalue = SMWDataValueFactory::newPropertyObjectValue( $user_property->getDataItem(), $value, $caption );
			} else {
				$smwdatavalue = SMWDataValueFactory::newPropertyObjectValue( $user_property, $value, $caption );
			}
			if ( count ( $smwdatavalue->getErrors() ) > 0 ) {
				$smwdatavalue = null;
			}
		}

		$this->m_user_property = $user_property;
		$this->m_smwdatavalue = $smwdatavalue;
		$this->m_property = $property;
		$this->m_value = $value;
		$this->m_caption = $caption;
		$this->m_visible = !preg_match( '/^\s+$/', $caption );
	}

	public function getProperty() {
		return $this->m_user_property;
	}

	public function setProperty( $property ) {
		$this->m_user_property = $property;
	}

	public function getSMWDataValue() {
		return $this->m_smwdatavalue;
	}

	public function setSMWDataValue( $smwdatavalue ) {
		$this->m_smwdatavalue = $smwdatavalue;
	}

	public function getWikiText() {
		$res = "[[{$this->getPropertyName()}::{$this->getPropertyValue()}";
		if ( $this->getPropertyValue() != $this->getCaption()
			&& $this->getCaption() != '' ) {
				$res .= "|{$this->getCaption()}";
		} elseif ( !$this->m_visible ) {
			$res .= "| ";
		}
		$res .= "]]";

		return $res;
	}

	public function getPropertyName() {
		return ( $this->m_property ) ? $this->m_property : $this->m_user_property->getWikiValue();
	}

	public function getPropertyValue() {
		return $this->m_smwdatavalue == null ? $this->m_value : $this->m_smwdatavalue->getWikiValue();
	}

	public function getCaption() {
		$caption = $this->m_smwdatavalue == null ? $this->m_caption : $this->m_smwdatavalue->getShortWikiText();
		return ( $caption == $this->getPropertyValue() ) ? '' : $caption;
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
	protected function getXMLContent() {
		return "
<value><![CDATA[{$this->getPropertyValue()}]]></value>
<caption><![CDATA[{$this->getCaption()}]]></caption>
";
	}
}
