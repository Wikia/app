<?php
/**
 * Provides a special page to look up user language and test wiki
 * This can be useful e.g. when a user has a problem with the preference system,
 * so the test wiki/language information can be easily looked up
 *
 * Based on code from extension LookupUser made by Tim Starling
 *
 * @file
 */

class SpecialViewUserLang extends SpecialPage
{
	public function __construct() {
		parent::__construct( 'ViewUserLang', 'viewuserlang' );
	}

	function getDescription() { return wfMsg( 'wminc-viewuserlang' ); }

	/**
	 * Show the special page
	 * @param $subpage Mixed: parameter passed to the page or null
	 */
	public function execute( $subpage ) {
		global $wgRequest, $wgUser;
		wfLoadExtensionMessages( 'WikimediaIncubator' );

		$this->setHeaders();

		if ( !$wgUser->isAllowed( 'viewuserlang' ) ) {
			$this->displayRestrictionError();
			return;
		}

		if ( $subpage ) {
			$target = $subpage;
		} else {
			$target = $wgRequest->getText( 'target' );
		}

		$this->showForm( $target );

		if ( $target ) {
			$this->showInfo( $target );
		}
	}

	/**
	 * Show the ViewUserLang form
	 * @param $target Mixed: user whose language and test wiki we're about to look up
	 */
	function showForm( $target ) {
		global $wgScript, $wgOut;
		$title = htmlspecialchars( $this->getTitle()->getPrefixedText() );
		$action = htmlspecialchars( $wgScript );
		$target = htmlspecialchars( $target );
		$ok = wfMsgHtml( 'go' );
		$username = wfMsgHtml( 'username' );
		$inputformtop = wfMsgHtml( 'wminc-viewuserlang' );

		$wgOut->addHTML( <<<EOT
<fieldset>
<legend>$inputformtop</legend>
<form method="get" action="$action">
<input type="hidden" name="title" value="{$title}" />
<table border="0">
<tr>
<td align="right">$username</td>
<td align="left"><input type="text" size="50" name="target" value="$target" />
<td colspan="2" align="center"><input type="submit" name="submit" value="$ok" /></td>
</tr>
</table>
</form>
</fieldset>
EOT
		);
	}

	/**
	 * Retrieves and shows the user language and test wiki
	 * @param $target Mixed: user whose language and test wiki we're looking up
	 */
	function showInfo( $target ) {
		global $wgOut, $wgLang, $wgLanguageNames, $wmincPref;
		$user = User::newFromName( $target );
		if ( $user == null || $user->getId() == 0 ) {
			$wgOut->addWikiText( '<span class="error">' . wfMsgNoTrans( 'wminc-viewuserlang-unexisting', $target ) . '</span>' );
		} else {
			$name = $user->getName();
			$wgOut->addWikiText( '*' . wfMsg( 'username' ) . ' [[User:' . $name . '|' . $name . ']] (' .
				$wgLang->pipeList( array(
					'[[User talk:' . $name . '|' . wfMsg( 'talkpagelinktext' ) . ']]',
					'[[Special:Contributions/' . $name . '|' . wfMsg( 'contribslink' ) . ']])'
				) ) );
			$wgOut->addWikiText(
				'*' . wfMsg( 'loginlanguagelabel',
				$wgLanguageNames[$user->mOptions['language']] . ' (' . $user->mOptions['language'] . ')'
				)
			);
			if ( IncubatorTest::isNormalPrefix() == true ) {
				$testwiki = '[[W' . $user->mOptions[$wmincPref . '-project'] . '/' . $user->mOptions[$wmincPref . '-code'] . ']]';
			} elseif ( IncubatorTest::displayPrefix() == 'inc' ) {
				$testwiki = 'Incubator';
			} else {
				$testwiki = wfMsg( 'wminc-testwiki-none' );
			}
				$wgOut->addWikiText( '*' . wfMsg( 'wminc-testwiki' ) . ' ' . $testwiki );
		}
	}
}
