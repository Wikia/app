<?php
/**
 * This model implements Page models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMPageModel extends WikiObjectModelCollection {
	protected $m_page_objs = array(); // no hierarchy info
	protected $m_title;
	protected $m_revisionId = 0;
	protected $m_nextId = 0;

	public function __construct() {
		parent::__construct( WOM_TYPE_PAGE );
	}

	public function setTitle( $title ) {
		$this->m_title = $title;
	}

	public function setRevisionID( $revisionId ) {
		$this->m_revisionId = $revisionId;
	}

	public function getNextId() {
		// use string instead of number, array functions may remove numbers
		return 'id' . $this->m_nextId ++;
	}

	public function getTitle() {
		return $this->m_title;
	}

	public function getRevisionID() {
		return $this->m_revisionId;
	}

	public function getObjectSet() {
		return $this->m_page_objs;
	}

	public function getObject( $id ) {
		return $this->m_page_objs[$id];
	}

	public function addToPageObjectSet( WikiObjectModel $obj ) {
		$this->m_page_objs[$obj->getObjectID()] = $obj;
	}

	public function insertPageObject( WikiObjectModel $obj, $id = '' ) {
		$obj->setObjectID( $this->getNextId() );

		$o = $this->m_page_objs[$id];
		if ( $o == null ) {
			$p = $this;
		} else {
			$p = $o->getParent();
		}
		$p->insertObject( $obj, $id );

		$this->addToPageObjectSet( $obj );
	}

	public function appendChildObject( WikiObjectModel $obj, $id = '' ) {
		if ( $id == '' ) {
			$p = $this;
		} else {
			$p = $this->m_page_objs[$id];
			if ( !( $p instanceof WikiObjectModelCollection ) ) {
				return;
			}
		}
		$obj->setObjectID( $this->getNextId() );
		$p->insertObject( $obj );

		$this->addToPageObjectSet( $obj );
	}

	public function removePageObject( $id ) {
		$old_obj = $this->m_page_objs[$id];
		if ( $old_obj == null ) return;

		$p = $old_obj->getParent();
		$p->removeObject( $id );

		$this->removeChildren( $old_obj );

		// remove from page object set
		unset( $this->m_page_objs[$id] );
	}

	public function updatePageObject( WikiObjectModel $obj, $id ) {
		$old_obj = $this->m_page_objs[$id];
		if ( $old_obj == null ) return;

		$this->removeChildren( $old_obj );

		$p = $old_obj->getParent();
		$p->updateObject( $obj, $id );

		$this->addToPageObjectSet( $obj );
	}

	private function removeChildren( $p ) {
		if ( !( $p instanceof WikiObjectModelCollection ) )
			return;
		foreach ( $p->getObjects() as $o ) {
			unset( $this->m_page_objs[$o->getObjectID()] );
			$this->removeChildren( $o );
		}
	}

	public function getObjectsByTypeID( $type_id ) {
		$result = array();
		foreach ( $this->m_page_objs as $id => $obj ) {
			if ( $obj->getTypeID() == $type_id ) {
				$result[$id] = $obj;
			}
		}

		return $result;
	}
}