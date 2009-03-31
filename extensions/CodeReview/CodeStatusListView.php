<?php

// Special:Code/MediaWiki/status
class CodeStatusListView extends CodeView {
	function __construct( $repoName ) {
		parent::__construct();
		$this->mRepo = CodeRepository::newFromName( $repoName );
	}

	function execute() {
		global $wgOut;
		$name = $this->mRepo->getName();
		$states = CodeRevision::getPossibleStates();
		$text = '';
		foreach( $states as $state ) {
			$text .= "* [[Special:Code/$name/status/$state|$state]]\n";
		}
		$wgOut->addWikiText( $text );
	}
}

