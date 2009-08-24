<?php

// Special:Code
class CodeRepoListView {

	function execute() {
		global $wgOut;
		$repos = CodeRepository::getRepoList();
		if ( !count( $repos ) ) {
			$wgOut->addWikiMsg( 'code-no-repo' );
			return;
		}
		$text = '';
		foreach ( $repos as $repo ) {
			$name = $repo->getName();
			$text .= "* " . self::getNavItem( $name ) . "\n";
		}
		$wgOut->addWikiText( $text );
	}

	public static function getNavItem( $name ) {
		global $wgLang;
		$text = "'''[[Special:Code/$name|$name]]''' (";
		$links[] = "[[Special:Code/$name/comments|" . wfMsgHtml( 'code-notes' ) . "]]";
		$links[] = "[[Special:Code/$name/status|" . wfMsgHtml( 'code-status' ) . "]]";
		$links[] = "[[Special:Code/$name/tag|" . wfMsgHtml( 'code-tags' ) . "]]";
		$links[] = "[[Special:Code/$name/author|" . wfMsgHtml( 'code-authors' ) . "]]";
		$links[] = "[[Special:Code/$name/releasenotes|" . wfMsgHtml( 'code-releasenotes' ) . "]]";
		$text .= $wgLang->pipeList( $links );
		$text .= ")";
		return $text;
	}
}
