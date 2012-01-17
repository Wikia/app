<?php
/**
 * Lite Semantics collections
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

abstract class LiteSemanticsCollection{
	protected $items = null;

	function __construct(){
		$this->items = array();
	}

	public function exists( $which ){
		return $this->items !== null && array_key_exists( $which, $this->items );
	}

	public function getItem( $which ){
		return ( $this->exists( $which ) ) ? $this->items[$which] : null;
	}

	public function setItem( $name, LiteSemanticsEntity $item ){
		$this->items[$name] = $item;
	}

	public function removeItem( $which ){
		if ( $this->exists( $which ) ) {
			unset( $this->items[$which] );
		}
	}

	public function count(){
		return ( $this->items !== null ) ? count( $this->items ) : 0;
	}

	public function rewind(){
		reset( $this->items );
    }

    public function current(){
		return current( $this->items );
    }

    public function key(){
		return key( $this->items );
    }

    public function next(){
		return next( $this->items );
    }

    public function valid(){
        $key = key( $this->items );
		return ( $key !== NULL && $key !== FALSE );
    }
}

class LiteSemanticsHashCollection extends LiteSemanticsCollection{
	protected $items = null;

	function __construct(){
		parent::__construct();
	}

	public function storeItem( $name, LiteSemanticsEntity $item ){
		$this->items->setItem( $name, $item );
	}
}

class LiteSemanticsListCollection extends LiteSemanticsCollection{
	protected $items = null;

	function __construct(){
		parent::__construct();
	}

	public function addItem( LiteSemanticsEntity $item ){
		$this->items[] = $item;
	}
}