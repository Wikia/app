<?php

abstract class TMessage {
	protected $key;
	protected $definition;

	/**
	 * Creates new message object.
	 *
	 * @param $key Unique key identifying this message.
	 * @param $definition The authoritave definition of this message.
	 */
	public function __construct( $key, $definition ) {
		$this->key = $key;
		$this->definition = $definition;
	}

	public function key() { return $this->key; }
	public function definition() { return $this->definition; }
	abstract public function translation();
	abstract public function author();
}

class ThinMessage extends TMessage {
	private $infile;
	private $row;
	private $tags = array();

	public function setInfile( $text ) {
		$this->infile = $text;
	}

	public function setRow( $row ) {
		$this->row = $row;
	}

	public function setTag( $tag ) {
		$this->tags[] = $tag;
	}


	public function key() {
		return $this->key;
	}
	public function definition() {
		return $this->definition;
	}
	public function translation() {
		if ( !isset( $this->row ) ) return $this->infile();
		return Revision::getRevisionText( $this->row );
	}
	public function author() {
		if ( !isset( $this->row ) ) return null;
		return $this->row->rev_user_text;
	}

	public function infile() {
		if ( !isset( $this->infile ) ) return null;
		return $this->infile;
	}

	public function hasTag( $tag ) {
		return in_array( $tag, $this->tags, true );
	}
}

class FatMessage extends TMessage {
	protected $translation = null;
	protected $infile = null;
	public function setTranslation( $text ) {
		$this->translation = $text;
	}

	public function translation() {
		if ( $this->translation === null ) return $this->infile;
		return $this->translation;
	}

	public function author() { }

	public function setInfile( $text ) {
		$this->infile = $text;
	}

	public function infile() {
		return $this->infile;
	}
}