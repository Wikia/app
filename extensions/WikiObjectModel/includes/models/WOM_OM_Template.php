<?php
/**
 * This model implements Template models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMTemplateModel extends WikiObjectModelCollection {
	protected $m_name;
	protected $m_title;

	public function __construct( $name ) {
		parent::__construct( WOM_TYPE_TEMPLATE );
		$this->m_name = $name;

		$this->m_title = Title::newFromText( $this->m_name );

		if ( $this->m_title->getNamespace() == NS_MAIN ) {
			// http://www.mediawiki.org/wiki/Help:Transclusion
			// If the source is in the Main article namespace (e.g., "Cat"),
			// you must put a colon (:) in front of the name, thus: {{:Cat}}

			// If the source is in the Template namespace (e.g., "Template:Villagepumppages"),
			// just use the name itself, alone, thus: {{Villagepumppages}}
			if ( $this->m_name { 0 } != ':' ) {
				$this->m_title = Title::makeTitleSafe( NS_TEMPLATE, $this->m_name );
			}
		}
	}

	public function getName() {
		return $this->m_name;
	}

	public function setName( $name ) {
		$this->m_name = $name;
	}

	public function getWikiText() {
		return "{{{$this->m_name}\n|" . parent::getWikiText() . "}}";
	}

	public function updateOnNodeClosed() {
		// use SemanticForms to bind properties to fields
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

		if ( $key == 'name' ) {
			$this->m_name = $value;
		} else {
			throw new MWException( __METHOD__ . ": invalid key/value pair: name=template_name" );
		}
	}
	protected function getXMLAttributes() {
		return 'name="' . self::xml_entities( $this->m_name ) . '"';
	}
}
