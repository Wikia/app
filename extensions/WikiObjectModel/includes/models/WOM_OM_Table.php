<?php
/**
 * This model implements Table models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMTableModel extends WikiObjectModelCollection {
	protected $m_style = '';

	public function __construct( $style ) {
		parent::__construct( WOM_TYPE_TABLE );

		$this->m_style = $style;
	}

	public function getStyle() {
		return $this->m_style;
	}

	public function setStyle( $style ) {
		$this->m_style = $style;
	}

	public function getWikiText() {
		return ( $this->isLastLF() ? '' : "\n" ) .
			"{| {$this->m_style}" . parent::getWikiText() . "\n|}";
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $key == 'style' ) {
			$this->m_style = $value;
			return;
		}
		throw new MWException( __METHOD__ . ": invalid key/value pair: style=table_style" );
	}

	protected function getXMLAttributes() {
		return 'style="' . self::xml_entities( str_replace( '"', "'", $this->m_style ) ) . '"';
	}
}
