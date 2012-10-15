<?php
/**
 * This model implements Category models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMCategoryModel extends WikiObjectModel {
	protected $m_name;

	public function __construct( $name ) {
		parent::__construct( WOM_TYPE_CATEGORY );
		$title = Title::newFromText( $name, NS_CATEGORY );
		if ( $title == null ) {
			// no idea why, just leave it
			$this->m_name = $name;
		} else {
			$this->m_name = $title->getText();
		}
	}

	public function getName() {
		return $this->m_name;
	}

	public function setName( $name ) {
		$this->m_name = $name;
	}

	public function getWikiText() {
		global $wgContLang;
		$namespace = $wgContLang->getNsText( NS_CATEGORY );

		return "[[{$namespace}:{$this->m_name}]]";
	}

	protected function getXMLContent() {
		return self::xml_entities( $this->m_name );
	}
}
