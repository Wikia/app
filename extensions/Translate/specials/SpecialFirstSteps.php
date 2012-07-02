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

	/**
	 * @var Skin
	 */
	protected $skin;

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var OutputPage
	 */
	protected $out;

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

		if ( $step === 'translate-fs-target-title' ) {
			global $wgLang;
			$this->out->redirect( SpecialPage::getTitleFor( 'LanguageStats', $wgLang->getCode() )->getLocalUrl() );
		}

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

		if ( $this->user->isLoggedIn() ) {
			$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-done' ) );
			$this->out->addHtml( $header );
			return $step;
		} else {
			// Go straight to create account (or login) page
			$create = SpecialPage::getTitleFor( 'Userlogin' );
			$returnto = $this->getTitle()->getPrefixedText();
			$this->out->redirect( $create->getLocalUrl( array( 'returnto' => $returnto , 'type' => 'signup' ) ) );
		}
	}

	protected function showSettings( $step ) {
		global $wgRequest, $wgLang;

		$header = new HtmlTag( 'h2' );
		$step_message = 'translate-fs-settings-title';
		$header->style( 'opacity', 0.4 )->content( wfMsg( $step_message ) );

		if ( $step ) {
			$this->out->addHtml( $header );
			return $step;
		}

		if ( $wgRequest->wasPosted() &&
			$this->user->matchEditToken( $wgRequest->getVal( 'token' ) ) &&
			$wgRequest->getText( 'step' ) === 'settings' )
		{
			$this->user->setOption( 'language', $wgRequest->getVal( 'primary-language' ) );
			$this->user->setOption( 'translate-firststeps', '1' );

			$assistant = array();
			for ( $i = 0; $i < 10; $i++ ) {
				$language = $wgRequest->getText( "assistant-language-$i", '-' );
				if ( $language === '-' ) continue;
				$assistant[] = $language;
			}

			if ( count( $assistant ) ) {
				$this->user->setOption( 'translate-editlangs', implode( ',', $assistant ) );
			}
			$this->user->saveSettings();
			// Reload the page if language changed, just in case and this is the easieast way
			$this->out->redirect( $this->getTitle()->getLocalUrl() );
		}

		if ( $this->user->getOption( 'translate-firststeps' ) === '1' ) {
			$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-done' ) );
			$this->out->addHtml( $header );
			return $step;
		}

		$this->out->addHtml( $header->style( 'opacity', false ) );

		$code = $wgLang->getCode();

		$languages = $this->languages( $code );
		$selector = new XmlSelect();
		$selector->addOptions( $languages );
		$selector->setDefault( $code );

		$output = Html::openElement( 'form', array( 'method' => 'post' ) );
		$output .= Html::hidden( 'step', 'settings' );
		$output .= Html::hidden( 'token', $this->user->editToken() );
		$output .= Html::hidden( 'title', $this->getTitle() );
		$output .= Html::openElement( 'table' );

		$name = $id = 'primary-language';
		$selector->setAttribute( 'id', $id );
		$selector->setAttribute( 'name', $name );
		$text = wfMessage( 'translate-fs-settings-planguage' )->text();
		$row  = self::wrap( 'td', Xml::label( $text, $id ) );
		$row .= self::wrap( 'td', $selector->getHtml() );
		$output .= self::wrap( 'tr', $row );

		$row = Html::rawElement( 'td', array( 'colspan' => 2 ), wfMessage( 'translate-fs-settings-planguage-desc' )->parse() );
		$output .= self::wrap( 'tr', $row );

		$helpers = $this->getHelpers( $this->user, $code );

		$selector = new XmlSelect();
		$selector->addOption( wfMessage( 'translate-fs-selectlanguage' )->text(), '-' );
		$selector->addOptions( $languages );

		$num = max( 2, count( $helpers ) );
		for ( $i = 0; $i < $num; $i++ ) {
			$id = $name = "assistant-language-$i";
			$text = wfMessage( 'translate-fs-settings-slanguage' )->numParams( $i + 1 )->text();
			$selector->setDefault( isset( $helpers[$i] ) ? $helpers[$i] : false );
			$selector->setAttribute( 'id', $id );
			$selector->setAttribute( 'name', $name );

			$row  = self::wrap( 'td', Xml::label( $text, $id ) );
			$row .= self::wrap( 'td', $selector->getHtml() );
			$output .= self::wrap( 'tr', $row );
		}

		$output .= Html::openElement( 'tr' );
		$output .= Html::rawElement( 'td', array( 'colspan' => 2 ), wfMessage( 'translate-fs-settings-slanguage-desc' )->parse() );
		$output .= Html::closeElement( 'tr' );
		$output .= Html::openElement( 'tr' );
		$output .= Html::rawElement( 'td', array( 'colspan' => 2 ), Xml::submitButton( wfMsg( 'translate-fs-settings-submit' ) ) );
		$output .= Html::closeElement( 'tr' );
		$output .= Html::closeElement( 'table' );
		$output .= Html::closeElement( 'form' );

		$this->out->addHtml( $output );

		return $step_message;
	}

	protected static function wrap( /*string*/ $tag, /*string*/ $content ) {
		return Html::rawElement( $tag, array(), $content );
	}

	protected function getHelpers( User $user, /*string*/ $code ) {
		global $wgTranslateLanguageFallbacks;
		$helpers = $user->getOption( 'translate-editlangs' );
		if ( $helpers === 'default' ) {
			if ( isset( $wgTranslateLanguageFallbacks[$code] ) ) {
				$helpers = $wgTranslateLanguageFallbacks[$code];
			} else {
				$helpers = array();
			}
		} else {
			$helpers = array_map( 'trim', explode( ',', $helpers ) );
		}
		return $helpers;
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
		$preload = "I am My Name and....";

		if ( $wgRequest->wasPosted() &&
			$this->user->matchEditToken( $wgRequest->getVal( 'token' ) ) &&
			$wgRequest->getText( 'step' ) === 'userpage' )
		{
			$babel = array();
			for ( $i = 0; $i < 5; $i++ ) {
				$language = $wgRequest->getText( "babel-$i-language", '-' );
				if ( $language === '-' ) continue;
				$level = $wgRequest->getText( "babel-$i-level", '-' );
				$babel[$language] = $level;
			}

			arsort( $babel );
			$babeltext = '{{#babel:';
			foreach ( $babel as $language => $level ) {
				if ( $level === 'N' ) $level = '';
				else $level = "-$level";
				$babeltext .= "$language$level|";
			}
			$babeltext = trim( $babeltext, '|' );
			$babeltext .= "}}\n";

			$article = new Article( $userpage, 0 );
			$status = $article->doEdit( $babeltext . $wgRequest->getText( $textareaId ), $this->getTitle() );

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

		$this->out->addWikiMsg( 'translate-fs-userpage-help' );
		global $wgLang;

		$form = new HtmlTag( 'form' );
		$items = new TagContainer();
		$form->param( 'method', 'post' )->content( $items );

		$items[] = new RawHtml( Html::hidden( 'step', 'userpage' ) );
		$items[] = new RawHtml( Html::hidden( 'token', $this->user->editToken() ) );
		$items[] = new RawHtml( Html::hidden( 'title', $this->getTitle() ) );

		$languages = $this->languages( $wgLang->getCode() );
		$selector = new XmlSelect();
		$selector->addOption( wfMessage( 'translate-fs-selectlanguage' )->text(), '-' );
		$selector->addOptions( $languages );

		// Building a skill selector
		$skill = new XmlSelect();
		$levels = 'N,5,4,3,2,1';
		foreach ( explode( ',', $levels ) as $level ) {
			$skill->addOption( wfMessage( "translate-fs-userpage-level-$level" )->text(), $level );
		}
		for ( $i = 0; $i < 5; $i++ ) {
			// Prefill en-2 and [wgLang]-N if [wgLang] != en
			if ( $i === 0 ) {
				$skill->setDefault( '2' );
				$selector->setDefault( 'en' );
			} elseif ( $i === 1 && $wgLang->getCode() !== 'en' ) {
				$skill->setDefault( 'N' );
				$selector->setDefault( $wgLang->getCode() );
			} else {
				$skill->setDefault( false );
				$selector->setDefault( false );
			}

			// [skill level selector][language selector]
			$skill->setAttribute( 'name', "babel-$i-level" );
			$selector->setAttribute( 'name', "babel-$i-language" );
			$items[] = New RawHtml( $skill->getHtml() . $selector->getHtml() . '<br />' );
		}

		$textarea = new HtmlTag( 'textarea', $preload );
		$items[] = $textarea->param( 'rows' , 5 )->id( $textareaId )->param( 'name', $textareaId );
		$items[] = new RawHtml( Xml::submitButton( wfMsg( 'translate-fs-userpage-submit' ) ) );

		$this->out->addHtml( $form );

		return $step_message;
	}

	protected function showPermissions( $step ) {
		global $wgLang, $wgRequest;
		$header = new HtmlTag( 'h2' );
		$step_message = 'translate-fs-permissions-title';
		$header->content( wfMsg( $step_message ) )->style( 'opacity', 0.4 );

		if ( $step ) {
			$this->out->addHtml( $header );
			return $step;
		}

		if ( $wgRequest->wasPosted() &&
			$this->user->matchEditToken( $wgRequest->getVal( 'token' ) ) &&
			$wgRequest->getText( 'step' ) === 'permissions' )
		{
			// This is ridiculous
			global $wgCaptchaTriggers;
			$captcha = $wgCaptchaTriggers;
			$wgCaptchaTriggers = null;

			$language = $wgRequest->getVal( 'primary-language' );
			$message = $wgRequest->getText( 'message', '...' );
			$params = array(
				'action' => 'threadaction',
				'threadaction' => 'newthread',
				'token' => $this->user->editToken(),
				'talkpage' => 'Project:Translator',
				'subject' => "{{LanguageHeader|$language}}",
				'reason' => 'Using Special:FirstSteps',
				'text' => $message,
			);
			$request = new FauxRequest( $params, true, $_SESSION );
			$api = new ApiMain( $request, true );
			$api->execute();
			$result = $api->getResultData();
			$wgCaptchaTriggers = $captcha;
			$page = $result['threadaction']['thread']['thread-title'];
			$this->user->setOption( 'translate-firststeps-request', $page );
			$this->user->saveSettings();
		}

		$page = $this->user->getOption( 'translate-firststeps-request' );
		if ( $this->user->isAllowed( 'translate' ) ) {
			$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-done' ) );
			$this->out->addHtml( $header );
			return $step;
		} elseif ( $page ) {
			$header->content( $header->content . wfMsg( 'translate-fs-pagetitle-pending' ) );
			$this->out->addHtml( $header->style( 'opacity', false ) );
			$this->out->addWikiMsg( 'translate-fs-permissions-pending', $page );
			return $step_message;
		}

		$this->out->addHtml( $header->style( 'opacity', false ) );
		$this->out->addWikiMsg( 'translate-fs-permissions-help' );

		$output = Html::openElement( 'form', array( 'method' => 'post' ) );
		$output .= Html::hidden( 'step', 'permissions' );
		$output .= Html::hidden( 'token', $this->user->editToken() );
		$output .= Html::hidden( 'title', $this->getTitle() );
		$name = $id = 'primary-language';
		$selector = new XmlSelect();
		$selector->addOptions( $this->languages( $wgLang->getCode() ) );
		$selector->setAttribute( 'id', $id );
		$selector->setAttribute( 'name', $name );
		$selector->setDefault( $wgLang->getCode() );
		$text = wfMessage( 'translate-fs-permissions-planguage' )->text();
		$output .= Xml::label( $text, $id ) . "&#160;" . $selector->getHtml() . '<br />';
		$output .= Html::element( 'textarea', array( 'rows' => 5, 'name' => 'message' ), '' );
		$output .= Xml::submitButton( wfMsg( 'translate-fs-permissions-submit' ) );
		$output .= Html::closeElement( 'form' );

		$this->out->addHtml( $output );
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

		if ( $step && ( $step !== 'translate-fs-target-title' && $step !== 'translate-fs-permissions-title' ) ) {
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

	protected function languages( $language ) {
		if ( is_callable( array( 'LanguageNames', 'getNames' ) ) ) {
			$languages = LanguageNames::getNames( $language,
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW
			);
		} else {
			$languages = Language::getLanguageNames( false );
		}

		ksort( $languages );

		$options = array();
		foreach ( $languages as $code => $name ) {
			$options["$code - $name"] = $code;
		}
		return $options;
	}
}
