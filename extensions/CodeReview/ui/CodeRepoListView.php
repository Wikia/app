<?php

/**
 * Class for showing the list of repositories, if none was specified
 */
class CodeRepoListView {
	public function execute() {
		global $wgOut;
		$repos = CodeRepository::getRepoList();
		if ( !count( $repos ) ) {
			global $wgUser;
			$wgOut->addWikiMsg( 'code-no-repo' );

			if ( $wgUser->isAllowed( 'repoadmin' ) ) {
				$wgOut->addWikiMsg( 'code-create-repo' );
			} else {
				$wgOut->addWikiMsg( 'code-need-repoadmin-rights' );

				if ( !count( User::getGroupsWithPermission( 'repoadmin' ) ) ) {
					$wgOut->addWikiMsg( 'code-need-group-with-rights' );
				}
			}
			return;
		}
		$text = '';
		foreach ( $repos as $repo ) {
			$text .= "* " . self::getNavItem( $repo ) . "\n";
		}
		$wgOut->addWikiText( $text );
	}

	/**
	 * @static
	 * @param  $repo CodeRepository
	 * @return string
	 */
	public static function getNavItem( $repo ) {
		global $wgLang, $wgUser;
		$name = $repo->getName();

		$code = SpecialPage::getTitleFor( 'Code', $name );
		$links[] = "[[$code/comments|" . wfMsgHtml( 'code-notes' ) . "]]";
		$links[] = "[[$code/statuschanges|" . wfMsgHtml( 'code-statuschanges' ) . "]]";
		if ( $wgUser->getId() ) {
			$author = $repo->wikiUserAuthor( $wgUser->getName() );
			if ( $author !== false ) {
				$links[] = "[[$code/author/$author|" . wfMsgHtml( 'code-mycommits' ) . "]]";
			}
		}

		if ( $wgUser->isAllowed( 'codereview-post-comment' ) ) {
			$userName = $wgUser->getName();
			$links[] = "[[$code/comments/author/$userName|" . wfMsgHtml( 'code-mycomments' ) . "]]";
		}

		$links[] = "[[$code/tag|" . wfMsgHtml( 'code-tags' ) . "]]";
		$links[] = "[[$code/author|" . wfMsgHtml( 'code-authors' ) . "]]";
		$links[] = "[[$code/status|" . wfMsgHtml( 'code-status' ) . "]]";
		$links[] = "[[$code/releasenotes|" . wfMsgHtml( 'code-releasenotes' ) . "]]";
		$links[] = "[[$code/stats|" . wfMsgHtml( 'code-stats' ) . "]]";
		if( $wgUser->isAllowed( 'repoadmin' ) ) {
			$links[] = "[[Special:RepoAdmin/$name|" . wfMsgHtml( 'repoadmin-nav' ) . "]]";
		}
		$text = "'''[[$code|$name]]''' " . wfMsg( 'parentheses', $wgLang->pipeList( $links ) );
		return $text;
	}
}
