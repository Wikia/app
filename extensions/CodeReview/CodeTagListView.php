<?php

// Special:Code/MediaWiki/tag
class CodeTagListView extends CodeView {
	function __construct( $repoName ) {
		parent::__construct();
		$this->mRepo = CodeRepository::newFromName( $repoName );
	}

	function execute() {
		global $wgOut;
		$tags = $this->mRepo->getTagList();
		$name = $this->mRepo->getName();
		$text = '';
		foreach( $tags as $tag ) {
			$text .= "* [[Special:Code/$name/tag/$tag|$tag]]\n";
		}
		$wgOut->addWikiText( $text );
	}
}

