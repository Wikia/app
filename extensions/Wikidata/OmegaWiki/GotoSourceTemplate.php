<?php

global
	$swissProtGotoSourceTemplate;
	
interface GotoSourceTemplate {
	public function getURL($sourceIdentifier);
}

class PrefixGotoSourceTemplate implements GotoSourceTemplate {
	protected $prefix;
	
	public function __construct($prefix) {
		$this->prefix = $prefix;
	}
	
	public function getURL($sourceIdentifier) {
		return $this->prefix . $sourceIdentifier;
	}
}

$swissProtGotoSourceTemplate = new PrefixGotoSourceTemplate("http://www.expasy.org/uniprot/");



