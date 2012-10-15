<?php
/**
 * This model implements Text models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMTextModel extends WikiObjectModel {
	protected $m_text;

	public function __construct( $text = '' ) {
		parent::__construct( WOM_TYPE_TEXT );
		$this->m_text = $text;
	}

	public function setText( $text ) {
		$this->m_text = $text;
	}

	public function getWikiText() {
		return $this->m_text;
	}

	public function append( $text ) {
		$this->m_text .= $text;
	}

	public function toXML() {
		return htmlspecialchars( $this->m_text );
	}
}
