<?php
/**
 * Contains logic for special page Special:FirstSteps to guide users through
 * the process of becoming a translator.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Implements a special page which assists users to become translators.
 * Currently it is tailored for the needs of translatewiki.net
 *
 * @ingroup SpecialPage TranslateSpecialPage
 */
class SpecialFirstSteps extends UnlistedSpecialPage {
	protected $skin, $user, $out;

	public function __construct() {
		parent::__construct( 'FirstSteps' );
	}

	public function execute( $params ) {
		global $wgOut, $wgUser;
		$this->out = $wgOut;
		$this->user = $wgUser;
		$this->skin = $wgUser->getSkin();

		$this->out->addWikiMsg( 'translate-fs-intro' );
		$step = false;

		$step = $this->showSignup( $step );
		$step = $this->showSettings( $step );
		$step = $this->showUserpage( $step );
		$step = $this->showPermissions( $step );
		$step = $this->showTarget( $step );
		$step = $this->showEmail( $step );

		$this->out->setPageTitle( htmlspecialchars( wfMsg( 'translate-fs-pagetitle', wfMsg( $step ) ) ) );
	}

	protected function showSignup( $step ) {
		$header = new HtmlTag( 'h2' );
		$step_message = 'translate-fs-signup-title';
		$header->style( 'opacity', 0.4 )->content( wfMsg( $step_message ) );

		if ( $step ) {
			$this->out->addHtml( $header );
			return $step;
		}

		if (  $this->user->isLoggedIn() ) {
			$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-done' ) );
			$this->out->addHtml( $header );
			return $step;
		}

		$this->out->addHtml( $header->style( 'opacity', false ) );

		$login_page = SpecialPage::getTitleFor( 'Userlogin' );
		$query = array( 'returnto' => $this->getTitle() );

		$li_href = $login_page->getFullUrl( $query );
		$tag = new HtmlTag( 'span', "[$li_href |||]" );
		$tag->param( 'class', 'plainlinks' );
		list( $li_before, $li_after ) =  explode( '|||', $tag, 2 );

		$su_href = $login_page->getFullUrl( $query + array( 'type' => 'signup' ) );
		$tag->content( "[$su_href |||]" );
		$tag->id( 'translate-fs-signup' );
		list( $su_before, $su_after ) =  explode( '|||', $tag, 2 );

		$this->out->addWikiMsg( 'translate-fs-signup-text', $li_before, $li_after, $su_before, $su_after );

		return $step_message;
	}

	protected function showSettings( $step ) {
		global $wgRequest;

		$header = new HtmlTag( 'h2' );
		$step_message = 'translate-fs-settings-title';
		$header->style( 'opacity', 0.4 )->content( wfMsg( $step_message ) );

		if ( $step ) {
			$this->out->addHtml( $header );
			return $step;
		}

		if ( $this->user->getOption( 'language' ) !== 'en' || $wgRequest->getText( 'step' ) === 'settings' ) {
			$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-done' ) );
			$this->out->addHtml( $header );
			return $step;
		}

		$this->out->addHtml( $header->style( 'opacity', false ) );
		$this->out->addWikiMsg( 'translate-fs-settings-text' );

		$form = new HtmlTag( 'form' );
		$items = new TagContainer();
		$form->param( 'method', 'post' )->content( $items );
		$items[] = new RawHtml( Html::hidden( 'step', 'settings' ) );
		$items[] = new RawHtml( Xml::submitButton( wfMsg( 'translate-fs-settings-skip' ) ) );

		$this->out->addHtml( $form );

		return $step_message;
	}

	protected function showUserpage( $step ) {
		global $wgRequest;

		$textareaId = 'userpagetext';

		$header = new HtmlTag( 'h2' );
		$step_message = 'translate-fs-userpage-title';
		$header->style( 'opacity', 0.4 )->content( wfMsg( $step_message ) );

		if ( $step ) {
			$this->out->addHtml( $header );
			return $step;
		}

		$userpage = $this->user->getUserPage();
		$preload = "{{#babel:en-2}}\nI am My Name and....";

		if ( $wgRequest->wasPosted() &&
			$this->user->matchEditToken( $wgRequest->getVal( 'token' ) ) &&
			$wgRequest->getText( 'step' ) === 'userpage' )
		{
			$article = new Article( $userpage );
			$status = $article->doEdit( $wgRequest->getText( $textareaId ), $this->getTitle() );

			if ( $status->isOK() ) {
				$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-done' ) );
				$this->out->addHtml( $header );
				$this->out->addWikiMsg( 'translate-fs-userpage-done' );

				return false;
			} else {
				$this->out->addWikiText( $status->getWikiText() );
				$preload = $wgRequest->getText( 'userpagetext' );
			}
		}

		if ( $userpage->exists() ) {
			$revision = Revision::newFromTitle( $userpage );
			$text = $revision->getText();
			$preload = $text;

			if ( preg_match( '/{{#babel:/i', $text ) ) {
				$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-done' ) );
				$this->out->addHtml( $header );

				return false;
			}
		}

		$this->out->addHtml( $header->style( 'opacity', false ) );

		$this->out->addWikiMsg( 'translate-fs-userpage-text' );
		global $wgLang;
		$this->out->addHtml(
			TranslateUtils::languageSelector( $wgLang->getCode(), $wgLang->getCode() )
		);

		$form = new HtmlTag( 'form' );
		$items = new TagContainer();
		$form->param( 'method', 'post' )->content( $items );

		$items[] = new RawHtml( Html::hidden( 'step', 'userpage' ) );
		$items[] = new RawHtml( Html::hidden( 'token', $this->user->editToken() ) );
		$items[] = new RawHtml( Html::hidden( 'title', $this->getTitle() ) );
		$textarea = new HtmlTag( 'textarea', $preload );
		$items[] = $textarea->param( 'rows' , 5 )->id( $textareaId )->param( 'name', $textareaId );
		$items[] = new RawHtml( Xml::submitButton( wfMsg( 'translate-fs-userpage-submit' ) ) );

		$this->out->addHtml( $form );

		return $step_message;
	}

	protected function showPermissions( $step ) {
		$header = new HtmlTag( 'h2' );
		$step_message = 'translate-fs-permissions-title';
		$header->content( wfMsg( $step_message ) )->style( 'opacity', 0.4 );

		if ( $step ) {
			$this->out->addHtml( $header );
			return $step;
		}

		if ( $this->user->isAllowed( 'translate' ) ) {
			$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-done' ) );
			$this->out->addHtml( $header );
			return $step;
		}

		$this->out->addHtml( $header->style( 'opacity', false ) );
		$this->out->addWikiMsg( 'translate-fs-permissions-text' );

		return $step_message;
	}

	protected function showTarget( $step ) {
		$header = new HtmlTag( 'h2' );
		$step_message = 'translate-fs-target-title';
		$header->content( wfMsg( $step_message ) );

		if ( $step ) {
			$header->style( 'opacity', 0.4 );
			$this->out->addHtml( $header );

			return $step;
		}

		global $wgLang;
		$this->out->addHtml( $header );
		$this->out->addWikiMsg( 'translate-fs-target-text', $wgLang->getCode() );

		return $step_message;
	}

	protected function showEmail( $step ) {
		$header = new HtmlTag( 'h2' );
		$step_message = 'translate-fs-email-title';
		$header->style( 'opacity', 0.4 )->content( wfMsg( $step_message ) );

		if ( $step && $step !== 'translate-fs-target-title' ) {
			$this->out->addHtml( $header );
			return $step;
		}

		if ( $this->user->isEmailConfirmed() ) {
			$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-done' ) );
			$this->out->addHtml( $header );

			return $step; // Start translating step
		}

		$this->out->addHtml( $header->style( 'opacity', false ) );
		$this->out->addWikiMsg( 'translate-fs-email-text' );

		return $step_message;
	}
}
