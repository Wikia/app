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
			global $wgLang;

			$name = $repo->getName();
			$text .= "* '''[[Special:CodeBrowse/$name|$name]]''' (";
			$links[] = "[[Special:Code/$name|" . wfMsgHtml( 'code-log' ) . "]]";
			$links[] = "[[Special:Code/$name/comments|" . wfMsgHtml( 'code-notes' ) . "]]";
			$links[] = "[[Special:Code/$name/tag|" . wfMsgHtml( 'code-tags' ) . "]]";
			$links[] = "[[Special:Code/$name/author|" . wfMsgHtml( 'code-authors' ) . "]]";
			$text .= $wgLang->pipeList( $links );
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
