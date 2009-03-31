<?php

// Special:Code/MediaWiki/author
class CodeAuthorListView extends CodeView {
	function __construct( $repoName ) {
		parent::__construct();
		$this->mRepo = CodeRepository::newFromName( $repoName );
	}

	function execute() {
		global $wgOut;
		$authors = $this->mRepo->getAuthorList();
		$name = $this->mRepo->getName();
		$text = wfMsg( 'code-authors-text' ) . "\n";
		foreach( $authors as $user ) {
			if( $user )
				$text .= "* [[Special:Code/$name/author/$user|$user]]\n";
		}
		$wgOut->addWikiText( $text );
	}
}

