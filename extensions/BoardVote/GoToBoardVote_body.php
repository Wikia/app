<?php
if (!defined('MEDIAWIKI')) {
	die( "Not a valid entry point\n" );
}

class GoToBoardVotePage extends SpecialPage {
	function __construct() {
		parent::__construct( "Boardvote" );
	}

	function execute( $par ) {
		global $wgOut, $wgDBname, $site, $lang, $wgLang, $wgUser;
		global $wgBoardVoteEditCount, $wgBoardVoteRecentEditCount, $wgBoardVoteCountDate;
		global $wgBoardVoteRecentFirstCountDate, $wgBoardVoteRecentCountDate;

		wfLoadExtensionMessages( 'BoardVote' );

		$this->setHeaders();

		$centralSessionId = '';
		if ( class_exists( 'CentralAuthUser' ) ) {
			global $wgCentralAuthCookiePrefix;
			if ( isset( $wgCentralAuthCookiePrefix )
				&& isset( $_COOKIE[$wgCentralAuthCookiePrefix . 'Session'] ) )
			{
				$centralSessionId = $_COOKIE[$wgCentralAuthCookiePrefix . 'Session'];
			} elseif ( isset( $_COOKIE[$wgCentralAuthCookiePrefix . 'Token'] ) )  {
				$centralUser = CentralAuthUser::getInstance( $wgUser );
				$centralSessionId = $centralUser->setGlobalCookies( true );
			}
		}

		if ( $wgUser->isLoggedIn() ) {
			#$url = 'http://shimmer/farm/frwiki/index.php?' . wfArrayToCGI( array(
			$url = 'https://wikimedia.spi-inc.org/index.php?' . wfArrayToCGI( array(
				'title' => 'Special:Boardvote' . ( $par ? "/$par" : '' ),
				'sid' => session_id(),
				'casid' => $centralSessionId,
				'db' => $wgDBname,
				'site' => $site,
				'lang' => $lang,
				'uselang' => $wgLang->getCode()
			) );

			$wgOut->addWikiText( wfMsg( "boardvote_redirecting", $url ) );
			$wgOut->addMeta( 'http:Refresh', '20;url=' . htmlspecialchars( $url ) );
		} else {
			$wgOut->addWikiText( wfMsgExt( 'boardvote_notloggedin', array( 'parsemag' ), $wgBoardVoteEditCount,
				$wgLang->timeanddate( $wgBoardVoteCountDate ), $wgBoardVoteRecentEditCount,
				$wgLang->timeanddate( $wgBoardVoteRecentFirstCountDate ),
				$wgLang->timeanddate( $wgBoardVoteRecentCountDate )
			) );
		}
	}
}
