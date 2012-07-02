<?php

class SpecialSQL2Wiki extends SpecialPage {
	
	public function __construct() {
		parent::__construct( 'SQL2Wiki' );
	}

	function execute($par) {
		global $wgOut, $wgParser;
		
		$this->setHeaders();
		
		$pars = explode('/', str_replace('\\', ' ', $par));
		
		$type = array_shift($pars);
		$value = array_shift($pars);
		
		$argv = array();
		foreach ($pars as $arg) {
			$subarg = explode('=', $arg);
			$argv[$subarg[0]] = $subarg[1];
		}
		$argv['cache'] = 'on';
		$argv['preexpand'] = 'false';
		$argv['expand'] = 'false';
		
		if (strtolower($type) == 'sql')
			$wgOut->addHTML(SQL2Wiki::renderSQL($value, $argv, $wgParser, null));
		elseif (strtolower($type) == 'plsql')
			$wgOut->addHTML(SQL2Wiki::renderPLSQL($value, $argv, $wgParser, null));
		else
			$wgOut->addWikiText('<b>'.wfMsg('sql2wiki-err-invalid_type').'</b>');

	}

}
