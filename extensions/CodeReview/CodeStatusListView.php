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
		$text = "== " . wfMsg ( "code-field-status" ) . " ==\n";
		foreach ( $states as $state ) {
			$text .= "* [[Special:Code/$name/status/$state|" . wfMsg ( "code-status-" . $state ) . "]]\n";
		}
		$wgOut->addWikiText( $text );
	}
}
