<?php
/**
 * Provides a special page to look up user language and test wiki
 * This can be useful e.g. when a user has a problem with the preference system,
 * so the test wiki/language information can be easily looked up
 *
 * Based on code from extension LookupUser made by Tim Starling
 *
 * @file
 * @ingroup SpecialPage
 * @author Robin Pepermans (SPQRobin)
 */

class SpecialViewUserLang extends SpecialPage {
	public function __construct() {
		parent::__construct( 'ViewUserLang', 'viewuserlang' );
	}

	/**
	 * @return String
	 */
	function getDescription() { return wfMsg( 'wminc-viewuserlang' ); }

	/**
	 * Show the special page
	 * @param $subpage Mixed: parameter passed to the page or null
	 */
	public function execute( $subpage ) {
		global $wgRequest, $wgUser;

		$this->setHeaders();

		if ( !$wgUser->isAllowed( 'viewuserlang' ) ) {
			$this->displayRestrictionError();
			return;
		}

		$target = $wgRequest->getText( 'target', $subpage );

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

		$wgOut->addHTML(
			Xml::fieldset( wfMsgHtml( 'wminc-viewuserlang' ) ) .
			Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) ) .
			Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			"<p>" .
				Xml::inputLabel( wfMsgHtml( 'wminc-viewuserlang-user' ), 'target', 'viewuserlang-username', 40, $target ) .
				' ' .
				Xml::submitButton( wfMsgHtml( 'wminc-viewuserlang-go' ) ) .
			"</p>" .
			Xml::closeElement( 'form' ) .
			Xml::closeElement( 'fieldset' )
		);
	}

	/**
	 * Retrieves and shows the user language and test wiki
	 * @param $target Mixed: user whose language and test wiki we're looking up
	 */
	function showInfo( $target ) {
		global $wgOut, $wmincPref, $wmincProjectSite;
		if( User::isIP( $target ) ) {
			# show error if it is an IP address
			$wgOut->addHTML( Xml::span( wfMsg( 'wminc-ip', $target ), 'error' ) );
			return;
		}
		$user = User::newFromName( $target );
		$name = $user->getName();
		$id = $user->getId();
		$langNames = Language::getLanguageNames();
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker : new Linker;
		if ( $user == null || $id == 0 ) {
			# show error if a user with that name does not exist
			$wgOut->addHTML( Xml::span( wfMsg( 'wminc-userdoesnotexist', $target ), 'error' ) );
			return;
		}
		$userproject = $user->getOption( $wmincPref . '-project' );
		$userproject = ( $userproject ? $userproject : 'none' );
		$usercode = $user->getOption( $wmincPref . '-code' );
		$prefix = IncubatorTest::displayPrefix( $userproject, $usercode ? $usercode : 'none' );
		if ( IncubatorTest::isContentProject( $userproject ) ) {
			$testwiki = $linker->link( Title::newFromText( $prefix ) );
		} elseif ( $prefix == $wmincProjectSite['short'] ) {
			$testwiki = htmlspecialchars( $wmincProjectSite['name'] );
		} else {
			$testwiki = wfMsgHtml( 'wminc-testwiki-none' );
		}
		$wgOut->addHtml(
			Xml::openElement( 'ul' ) .
			'<li>' . wfMsgHtml( 'username' ) . ' ' .
				$linker->userLink( $id, $name ) . $linker->userToolLinks( $id, $name, true ) . '</li>' .
			'<li>' . wfMsgHtml( 'loginlanguagelabel', $langNames[$user->getOption( 'language' )] .
				' (' . $user->getOption( 'language' ) . ')' ) . '</li>' .
			'<li>' . wfMsgHtml( 'wminc-testwiki' ) . ' ' . $testwiki . '</li>' .
			Xml::closeElement( 'ul' )
		);
	}
}
