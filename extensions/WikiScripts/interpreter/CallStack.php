<?php

abstract class WSCallStackEntry {
	abstract function toString();
}

abstract class WSCallStackFunctionEntry extends WSCallStackEntry {
	public $module;
	public $function;
}

class WSCallStackFunctionFromModuleEntry extends WSCallStackFunctionEntry {
	public $invokingModule;
	public $line;
	
	public function toString() {
		return wfMsg( 'wikiscripts-call-frommodule', $this->module, $this->function,
			$this->invokingModule, $this->line );
	}
}

class WSCallStackFunctionFromWikitextEntry extends WSCallStackFunctionEntry {
	public function toString() {
		return wfMsg( 'wikiscripts-call-frommodule', $this->module, $this->function );
	}
}

class WSCallStackParseEntry extends WSCallStackEntry {
	public $text;

	public function toString() {
		return wfMsg( 'wikiscripts-call-parse', $this->text );
	}
}

class WSCallStack {
	var $mInterpreter, $mStack;

	public function __construct( $interpreter ) {
		$this->mInterpreter = $interpreter;
		$this->mStack = array();
	}

	public function pop() {
		array_pop( $this->mStack );
	}

	public function isFull() {
		global $wgScriptsMaxCallStackDepth;
		
		return count( $this->mStack ) >= $wgScriptsMaxCallStackDepth;
	}

	public function contains( $module, $name ) {
		foreach( $this->mStack as $entry ) {
			if( $entry instanceof WSCallStackFunctionEntry ) {
				if( $entry->module == $module && $entry->function == $name ) {
					return true;
				}
			}
		}
		return false;
	}

	public function addFunctionFromModule( $module, $name, $invokingModule, $line ) {
		$entry = new WSCallStackFunctionFromModuleEntry();
		$entry->module = $module;
		$entry->function = $name;
		$entry->invokingModule = $invokingModule;
		$entry->line = $line;
		$this->mStack[] = $entry;
	}

	public function addFunctionFromWikitext( $module, $name ) {
		$entry = new WSCallStackFunctionFromWikitextEntry();
		$entry->module = $module;
		$entry->function = $name;
		$this->mStack[] = $entry;
	}

	public function addParse( $wikitext ) {
		if( strlen( $wikitext ) > 64 ) {
			$wikitext = substr( $wikitext, 0, 64 ) . "...";
		}

		$entry = new WSCallStackParseEntry();
		$entry->text = $wikitext;
		$this->mStack[] = $entry;
	}
}
