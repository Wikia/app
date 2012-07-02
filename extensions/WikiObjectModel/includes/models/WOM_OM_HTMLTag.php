<?php
/**
 * This model implements Template models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMHTMLTagModel extends WikiObjectModelCollection {
	protected $m_name;
	protected $m_attrs = array();

	public function __construct( $name, $attrs = array() ) {
		parent::__construct( WOM_TYPE_HTMLTAG );
		$this->m_name = $name;
		$this->m_attrs = $attrs;
	}

	public function getName() {
		return $this->m_name;
	}

	public function setName( $name ) {
		$this->m_name = $name;
	}

	public function getAttributes() {
		return $this->m_attrs;
	}

	public function getAttribute( $attr ) {
		$attr = strtolower( $attr );
		foreach ( $this->m_attrs as $a => $v ) {
			$a = strtolower( $a );
			$v = preg_replace( '/^[\'"](.*)[\'"]$/', '$1', $v );
			if ( $attr == $a ) return $v;
		}
	}

	public function setAttributes( $attrs ) {
		$this->m_attrs = $attrs;
	}

	public function getWikiText() {
		$attr = '';
		foreach ( $this->m_attrs as $a => $v ) {
			$attr .= " {$a}={$v}";
		}
		return "<{$this->m_name}{$attr}>" . parent::getWikiText() . "</{$this->m_name}>";
	}

	public function getInnerWikiText() {
		return parent::getWikiText();
	}

	public function updateOnNodeClosed() {
		// use SemanticForms to bind properties to fields
	}

	public function setXMLAttribute( $key, $value ) {
		if ( $value == '' ) throw new MWException( __METHOD__ . ": value cannot be empty" );

		if ( $key == 'name' ) {
			$this->m_name = $value;
		} else {
			throw new MWException( __METHOD__ . ": invalid key/value pair: name=html_tag_name" );
		}
	}
	protected function getXMLAttributes() {
		$ret = 'name="' . self::xml_entities( $this->m_name ) . '"';
		foreach ( $this->m_attrs as $a => $v ) {
			$v = preg_replace( '/^"(.*)"$/', '$1', $v );
			if ( $a == 'id' ) $a = 'tag_id';
			$v = self::xml_entities( $v );
			$ret .= " {$a}=\"{$v}\"";
		}
		return $ret;
	}
}
