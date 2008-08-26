<?

/* 	class Silent Article that extends Article - mostly for non-agressive presentation of multiple actions,
	like delete, rebuild, cleanup etc.

*/

require_once ("$IP/includes/Article.php") ;

class SilentArticle extends Article {

	/* same as in Article, but without final redirect */
	function updateArticle( $text, $summary, $minor, $watchthis, $forceBot = false, $sectionanchor = '' ) {
		$flags = EDIT_UPDATE | EDIT_DEFER_UPDATES |
			( $minor ? EDIT_MINOR : 0 ) |
			( $forceBot ? EDIT_FORCE_BOT : 0 );

		$good = $this->doEdit( $text, $summary, $flags );
		if ( $good ) {
			$dbw =& wfGetDB( DB_MASTER );
			if ($watchthis) {
				if (!$this->mTitle->userIsWatching()) {
					$dbw->begin();
					$this->doWatch();
					$dbw->commit();
				}
			} else {
				if ( $this->mTitle->userIsWatching() ) {
					$dbw->begin();
					$this->doUnwatch();
					$dbw->commit();
				}
			}
		}
		return $good;
	}

	function doDelete( $reason ) {
		global $wgOut, $wgUser;
		wfDebug( __METHOD__."\n" );

		if (wfRunHooks('ArticleDelete', array(&$this, &$wgUser, &$reason))) {
			if ( $this->doDeleteArticle( $reason ) ) {
				$deleted = $this->mTitle->getPrefixedText();
				$loglink = '[[Special:Log/delete|' . wfMsg( 'deletionlog' ) . ']]';
				$text = wfMsg( 'deletedtext', "'''$deleted'''", $loglink );
				$wgOut->addWikiText( $text );
				wfRunHooks('ArticleDeleteComplete', array(&$this, &$wgUser, $reason));
			} else {
				$wgOut->showFatalError( wfMsg( 'cannotdelete' ) );
			}
		}
	}
}

?>
