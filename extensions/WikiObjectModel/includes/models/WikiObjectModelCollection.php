<?php
/**
 * File holding abstract class WikiObjectModelCollection, the base for all object model in WOM.
 *
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

abstract class WikiObjectModelCollection extends WikiObjectModel {
	protected $m_objects = array();

	public function isCollection() {
		return true;
	}

	public function reset() {
		$this->m_objects = array();
	}

	public function getObjects() {
		return $this->m_objects;
	}

	public function getLastObject() {
		$i = count( $this->m_objects );
		if ( $i > 0 ) {
			return end( $this->m_objects );
		}
		return null;
	}

	public function getWikiText() {
		$text = '';
		foreach ( $this->m_objects as $obj ) {
			$text .= $obj->getWikiText();
		}
		return $text;
	}

	/**
	 * Hook here, value updates on collection complete
	 */
	public function updateOnNodeClosed() { }

	function insertObject( WikiObjectModel $obj, $id = '' ) {
		if ( $id == '' ) {
			$this->m_objects[] = $obj;
		} else {
			// insert object right before id
			$objs = array();
			foreach ( $this->m_objects as $o ) {
				if ( $id == $o->getObjectID() ) $objs[] = $obj;
				$objs[] = $o;
			}
			$this->m_objects = $objs;
		}
		$obj->setParent( $this );
	}

	function removeObject( $id ) {
		foreach ( $this->m_objects as $k => $o ) {
			if ( $id == $o->getObjectID() ) unset( $this->m_objects[$k] );
		}
	}

	function rollback() {
		array_pop( $this->m_objects );
	}

	function updateObject( WikiObjectModel $obj, $id ) {
		$obj->setObjectID( $id );
		$obj->setParent( $this );

		$objs = array();
		foreach ( $this->m_objects as $o ) {
			if ( $id == $o->getObjectID() ) {
				$objs[] = $obj;
			} else {
				$objs[] = $o;
			}
		}
		$this->m_objects = $objs;
	}

	protected function getSubXML() {
		$text = '';
		foreach ( $this->m_objects as $obj ) {
			$text .= $obj->toXML();
		}
		return $text;
//		return "<subs>{$text}</subs>";
	}

	protected function getXMLContent() {
		return $this->getSubXML();
	}
}
