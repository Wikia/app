<?php
/**
 * This model implements ListItem models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMListItemModel extends WikiObjectModelCollection {
	protected $m_header;

	public function __construct( $header ) {
		parent::__construct( WOM_TYPE_LISTITEM );

		$this->m_header = $header;
	}

	public function getHeader() {
		return $this->m_header;
	}

	public function getWikiText() {
		return ( $this->isLastLF() ? '' : "\n" ) .
			$this->m_header . parent::getWikiText();
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

		if ( $key == 'header' ) {
			$this->m_header = $value;
		} else {
			throw new MWException( __METHOD__ . ": invalid key/value pair: header=list_header (*/#)" );
		}
	}
	protected function getXMLAttributes() {
		return "header=\"{$this->m_header}\"";
	}
}
