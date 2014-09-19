<?php

namespace Wikia\Swift\Operation;

use Wikia\Swift\Entity\Local;
use Wikia\Swift\Entity\Remote;

abstract class Operation {
	protected $id;
	/** @var Local */
	protected $local;
	/** @var Remote */
	protected $remote;
	protected $descriptionPrefix = '';
	protected function __construct( $local, $remote ) {
		$this->local = $local;
		$this->remote = $remote;
		$this->id =
			 ($this->local ? $this->local->getLocalPath() : '')
			. ':'
			.($this->remote ? $this->remote->getRemotePath() : '');
	}
	public function getId() { return $this->id; }
	public function getLocal() { return $this->local; }
	public function getRemote() { return $this->remote; }
	public function verify() {
		if ( $this->local ) {
			$this->local->load();
			if ( !$this->local->exists() ) {
				return false;
			}
		}
		return true;
	}
	public function getDescription() {
		return $this->descriptionPrefix . $this->remote->getRemotePath();
	}
}
class Upload extends Operation {
	protected $descriptionPrefix = 'UPL ';
	public function __construct( Local $local, Remote $remote ) {
		parent::__construct($local,$remote);
	}
}

class Delete extends Operation {
	protected $descriptionPrefix = 'DEL ';
	public function __construct( Remote $remote ) {
		parent::__construct(null,$remote);
	}
}

