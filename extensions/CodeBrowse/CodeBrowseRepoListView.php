<?php

class CodeBrowseRepoListView extends CodeBrowseView { 
	function getContent() {
		global $wgOut;
		return $wgOut->parse( self::reallyGetContent() );
		
	}
	static function reallyGetContent() {
		$repos = CodeRepository::getRepoList();
		if( !count( $repos ) )
			return wfMsg( 'code-no-repo' );
		
		$text = '';
		foreach( $repos as $repo ){
			$name = $repo->getName();
			$text .= "* '''[[Special:CodeBrowse/$name|$name]]''' (";
			$text .= "[[Special:Code/$name|".wfMsgHtml( 'code-log' )."]]";
			$text .= " | [[Special:Code/$name/comments|".wfMsgHtml( 'code-notes' )."]]";
			$text .= " | [[Special:Code/$name/tag|".wfMsgHtml( 'code-tags' )."]]";
			$text .= " | [[Special:Code/$name/author|".wfMsgHtml( 'code-authors' )."]]";
			$text .= ")\n";
		}
		
		return $text;
		
	}
	
	
}

class CodeRepoListView {
	function execute() {
		global $wgOut;
		$wgOut->addWikiText( CodeBrowseRepoListView::reallyGetContent() );
	}
}
