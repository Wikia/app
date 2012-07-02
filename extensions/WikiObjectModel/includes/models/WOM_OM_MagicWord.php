<?php
/**
 * This model implements magicword models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMMagicWordModel extends WikiObjectModel {
	protected $m_magicword;
	protected $m_doubleUnderscore;

	public function __construct( $magicword, $doubleUnderscore = false ) {
		parent::__construct( WOM_TYPE_MAGICWORD );
		$this->m_magicword = $magicword;
		$this->m_doubleUnderscore = $doubleUnderscore;
	}

	public function getMagicWord() {
		return $this->m_magicword;
	}

	public function setMagicWord( $magicword ) {
		$this->m_magicword = $magicword;
	}

	public function getWikiText() {
		return $this->m_doubleUnderscore ? $this->m_magicword : "{{{$this->m_magicword}}}";
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

		if ( $key == 'magicword' ) {
			$this->m_magicword = $value;
			return;
		}
		throw new MWException( __METHOD__ . ": invalid key/value pair: magicword=reserve_magicword" );
	}
	protected function getXMLAttributes() {
		return "magicword=\"{$this->m_magicword}\"";
	}
}
