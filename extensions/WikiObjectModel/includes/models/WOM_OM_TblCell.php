<?php
/**
 * This model implements Table models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMTableCellModel extends WikiObjectModelCollection {
	// including table header and table row
	protected $m_prefix = '';

	public function __construct( $prefix ) {
		parent::__construct( WOM_TYPE_TBL_CELL );

		$this->m_prefix = $prefix;
	}

	public function getPrefix() {
		return $this->m_prefix;
	}

	public function setPrefix( $prefix ) {
		$this->m_prefix = $prefix;
	}

	public function getWikiText() {
		return "{$this->m_prefix}" . parent::getWikiText();
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

//		$value = str_replace( '\n', "\n", $value );
		if ( $key == 'prefix' ) {
			$this->m_prefix = $value;
			return;
		}
		throw new MWException( __METHOD__ . ": invalid key/value pair: prefix=table_cell_prefix (! / | / ||)" );
	}

	protected function getXMLAttributes() {
//		$prefix = str_replace( "\n", '\n', $this->m_prefix );
		$prefix = str_replace( '"', "'", $prefix );
		return 'prefix="' . self::xml_entities( $prefix ) . '"';
	}
}
