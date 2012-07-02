<?php
/**
 * This model implements Section models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMSectionModel extends WikiObjectModelCollection {
	protected $m_name;
	protected $m_level;

	static $heading = '======';

	public function __construct( $name, $level ) {
		parent::__construct( WOM_TYPE_SECTION );
		$this->m_name = $name;
		$this->m_level = $level;
	}

	public function getName() {
		return $this->m_name;
	}

	public function setName( $name ) {
		$this->m_name = $name;
	}

	public function getLevel() {
		return $this->m_level;
	}

	public function setLevel( $level ) {
		$this->m_level = $level;
	}

	public function getHeaderText() {
		return ( $this->isLastLF() ? '' : "\n" ) .
			substr( WOMSectionModel::$heading, 0, $this->m_level ) .
			$this->m_name .
			substr( WOMSectionModel::$heading, 0, $this->m_level ) .
			"\n";
	}

	public function getWikiText() {
		return $this->getHeaderText() . parent::getWikiText();
	}

	public function getContent() {
		return parent::getWikiText();
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

		if ( $key == 'name' ) {
			$this->m_name = $value;
			return;
		} elseif ( $key == 'level' ) {
			$i = intval( $value );
			if ( $i > 0 && $i <= strlen( WOMSectionModel::$heading ) ) {
				$this->m_level = $i;
				return;
			}
		}
		throw new MWException( __METHOD__ . ": invalid key/value pair: name=section_name; level=section_level (0-" . strlen( WOMSectionModel::$heading ) . ")" );
	}

	protected function getXMLAttributes() {
		return 'name="' . self::xml_entities( $this->m_name ) . '" level="' . $this->m_level . '"';
	}
}
