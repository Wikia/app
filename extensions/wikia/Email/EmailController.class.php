<?php

namespace Email;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Wikia\Logger\WikiaLogger;

abstract class EmailController extends \WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	const AVATAR_SIZE = 50;

	/** CSS used for the main content section of each email. Used by getContent()
	 * and intended to be overridden by child classes. */
	const LAYOUT_CSS = 'avatarLayout.css';

	/** @var \User The user associated with the current request */
	protected $currentUser;

	/** @var \User The user this email will be sent to */
	protected $targetUser;

	protected $hasErrorResponse = false;

	/** @var bool Whether to show the icons over the hubs links */
	protected $marketingFooter;

	/** @var bool Whether or not to actually send an email */
	protected $test;

	/** @var string The language to send the email in */
	protected $targetLang;

	/** @var  \MailAddress */
	protected $replyToAddress;

	/** @var  \MailAddress */
	protected $fromAddress;

	/**
	 * Since the children of this class are located in the 'Controller' directory, the default
	 * location for the template directory would be 'Controller/templates'.  Redefine it to be
	 * at the root of this extension instead.
	 *
	 * @return string
	 */
	public static function getTemplateDir() {
		return dirname( __FILE__ ) . '/templates';
	}

	public function init() {
		try {
			$this->assertCanAccessController();

			$this->currentUser = $this->findUserFromRequest( 'currentUser', $this->wg->User );
			$this->targetUser = $this->findUserFromRequest( 'targetUser', $this->wg->User );
			$this->targetLang = $this->getVal( 'targetLang', $this->targetUser->getOption( 'language' ) );
			$this->test = $this->getVal( 'test', false );
			$this->marketingFooter = $this->request->getBool( 'marketingFooter' );

			$noReplyName = wfMessage( 'emailext-no-reply-name' )->escaped();

			$this->replyToAddress = new \MailAddress(
				$this->getVal( 'replyToAddress', $this->wg->NoReplyAddress ),
				$this->getVal( 'replyToName', $noReplyName )
			);

			$fromAddress = $this->getVal( 'fromAddress', '' );
			$this->assertValidFromAddress( $fromAddress );

			$this->fromAddress = new \MailAddress(
				$fromAddress,
				$this->getVal( 'fromName', '' )
			);

			$this->initEmail();
		} catch ( ControllerException $e ) {
			$this->setErrorResponse( $e );
		}
	}

	/**
	 * Make sure to only allow authorized use of this extension.
	 *
	 * @throws \Email\Fatal
	 */
	public function assertCanAccessController() {
		if ( $this->wg->User->isStaff() ) {
			return;
		}

		if ( $this->request->isInternal() ) {
			return;
		}

		throw new Fatal( 'Access to this controller is restricted' );
	}

	protected function assertValidFromAddress( $email ) {
		if ( !\Sanitizer::validateEmail( $email ) ) {
			throw new Check( "Invalid from address" );
		}

		return true;
	}

	/**
	 * Allow child classes to set some initial values.  Added here so its always defined
	 * but is kept blank so does not need to be called via parent::initEmail()
	 */
	public function initEmail() {
		// Can be overridden in child class
	}

	/**
	 * This is the main entry point for the email extension.  The template set for this
	 * method is used for testing only, to preview the email that will be sent.
	 *
	 * @template emailPreview
	 *
	 * @throws \MWException
	 */
	public function handle() {
		// If something previously has thrown an error (likely 'init') don't continue
		if ( $this->hasErrorResponse ) {
			return;
		}

		try {
			$this->assertCanEmail();

			$toAddress = $this->getToAddress();
			$fromAddress = $this->getFromAddress();
			$replyToAddress = $this->getReplyToAddress();
			$subject = $this->getSubject();

			$bodyHTML = $this->getBody();
			$bodyText = $this->bodyHtmlToText( $bodyHTML );

			$body = [
				'html' => $bodyHTML,
				'text' => $bodyText
			];

			if ( !$this->test ) {
				$status = \UserMailer::send(
					$toAddress,
					$fromAddress,
					$subject,
					$body,
					$replyToAddress
				);
				$this->assertGoodStatus( $status );
			}
		} catch ( \Exception $e ) {
			$this->setErrorResponse( $e );
			return;
		}

		$this->response->setData( [
			'result' => 'ok',
			'subject' => $subject,
			'body' => $body['html'],
		] );
	}

	/**
	 * Render the main layout file
	 *
	 * @template main
	 */
	public function main() {
		$this->response->setValues( $this->request->getParams() );
	}

	/**
	 * Create an error response for any exception thrown while creating this email
	 *
	 * @param \Exception $e
	 *
	 */
	protected function setErrorResponse( \Exception $e ) {
		if ( $e instanceof ControllerException ) {
			$result = $e->getErrorType();
		} else {
			$result = 'genericError';
		}

		WikiaLogger::instance()->error( 'Error while sending email', [
			'result' => $result,
			'msg' => $e->getMessage(),
		] );

		$this->hasErrorResponse = true;
		$this->response->setData( [
			'result' => $result,
			'msg' => $e->getMessage(),
		] );
	}

	/**
	 * Whether to show a TM next to the tagline in this country
	 * At some point we may want to return the symbol instead of a bool
	 */
	protected function getUseTrademark() {
		return $this->targetLang == 'en';
	}

	/**
	 * Returns the address for the recipient of this email
	 *
	 * @return \MailAddress
	 */
	protected function getToAddress() {
		$to = new \MailAddress( $this->targetUser->getEmail(), $this->targetUser->getName() );
		return $to;
	}

	/**
	 * Returns the address for the sender of this email
	 *
	 * @return \MailAddress
	 */
	protected function getFromAddress() {
		return $this->fromAddress;
	}

	/**
	 * Get the 'reply-to' address for the send of this email, if different than the 'from' address.
	 *
	 * @return \MailAddress|null
	 */
	protected function getReplyToAddress() {
		return $this->replyToAddress;
	}

	/**
	 * Return the subject used for this email
	 */
	abstract function getSubject();

	/**
	 * Renders the 'body' view of the current email controller
	 *
	 * @return string
	 */
	protected function getBody() {
		$css = file_get_contents( __DIR__ . '/styles/main.css' );

		$html = $this->app->renderView(
			get_class( $this ),
			'main',
			[
				'content' => $this->getContent(),
				'footerMessages' => $this->getFooterMessages(),
				'marketingFooter' => $this->marketingFooter,
				'tagline' => $this->getTagline(),
				'useTrademark' => $this->getUseTrademark(),
				'hubsMessages' => $this->getHubsMessages(),
				'socialMessages' => $this->getSocialMessages(),
				'icons' => ImageHelper::getIconInfo(),
			]
		);

		$html = $this->inlineStyles( $html, $css );

		return $html;
	}

	/**
	 * Create a plain text version of the body HTML
	 *
	 * @param string $html The HTML for the email body
	 *
	 * @return string
	 */
	protected function bodyHtmlToText( $html ) {
		$bodyText = strip_tags( $html );

		// Get rid of multiple blank white lines
		$bodyText = preg_replace( '/^\h*\v+/m', '', $bodyText );

		// Get rid of leading spacing/indenting
		$bodyText = preg_replace( '/^[\t ]+/m', '', $bodyText );
		return $bodyText;
	}

	/**
	 * Renders the content unique to each email.
	 */
	protected function getContent() {
		$css = file_get_contents( __DIR__ . '/styles/' . static::LAYOUT_CSS );
		$html = $this->app->renderView(
			get_class( $this ),
			'body',
			$this->request->getParams()
		);

		$html = $this->inlineStyles( $html, $css );

		return $html;
	}

	/**
	 * Inline all css into style attributes
	 *
	 * @param string $html
	 * @param string $css
	 * @return string
	 * @throws \TijsVerkoyen\CssToInlineStyles\Exception
	 * @see https://github.com/tijsverkoyen/CssToInlineStyles
	 */
	protected function inlineStyles( $html, $css ) {
		// fix known issue in library with character encoding.
		$charsetMeta = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$html = $charsetMeta . $html;

		// add default css to every template
		$css .= file_get_contents( __DIR__ . '/styles/common.css' );

		$inliner = new CssToInlineStyles( $html, $css );
		$inliner->setUseInlineStylesBlock();
		$html = $inliner->convert();

		return $html;
	}

	protected function getFooterMessages() {
		return [
			wfMessage( 'emailext-recipient-notice', $this->targetUser->getEmail() )
				->inLanguage( $this->targetLang )->parse(),
			wfMessage( 'emailext-update-frequency' )
				->inLanguage( $this->targetLang )->parse(),
			wfMessage( 'emailext-unsubscribe', $this->getUnsubscribeLink() )
				->inLanguage( $this->targetLang )->parse(),
		];
	}

	/**
	 * Tagline text that appears in the email footer
	 * @return String
	 */
	protected function getTagline() {
		return wfMessage( 'emailext-fans-tagline' )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * Get localized strings for hubs names and their URLs
	 * @return array
	 * @throws \MWException
	 */
	protected function getHubsMessages() {
		return [
			'tv' => wfMessage( 'oasis-label-wiki-vertical-id-1' )->inLanguage( $this->targetLang )->text(),
			'tvURL' => wfMessage( 'oasis-label-wiki-vertical-id-1-link' )->inLanguage( $this->targetLang )->text(),
			'videoGames' => wfMessage( 'oasis-label-wiki-vertical-id-2' )->inLanguage( $this->targetLang )->text(),
			'videoGamesURL' => wfMessage( 'oasis-label-wiki-vertical-id-2-link' )->inLanguage( $this->targetLang )->text(),
			'books' => wfMessage( 'oasis-label-wiki-vertical-id-3' )->inLanguage( $this->targetLang )->text(),
			'booksURL' => wfMessage( 'oasis-label-wiki-vertical-id-3-link' )->inLanguage( $this->targetLang )->text(),
			'comics' => wfMessage( 'oasis-label-wiki-vertical-id-4' )->inLanguage( $this->targetLang )->text(),
			'comicsURL' => wfMessage( 'oasis-label-wiki-vertical-id-4-link' )->inLanguage( $this->targetLang )->text(),
			'lifestyle' => wfMessage( 'oasis-label-wiki-vertical-id-5' )->inLanguage( $this->targetLang )->text(),
			'lifestyleURL' => wfMessage( 'oasis-label-wiki-vertical-id-5-link' )->inLanguage( $this->targetLang )->text(),
			'music' => wfMessage( 'oasis-label-wiki-vertical-id-6' )->inLanguage( $this->targetLang )->text(),
			'musicURL' => wfMessage( 'oasis-label-wiki-vertical-id-6-link' )->inLanguage( $this->targetLang )->text(),
			'movies' => wfMessage( 'oasis-label-wiki-vertical-id-7' )->inLanguage( $this->targetLang )->text(),
			'moviesURL' => wfMessage( 'oasis-label-wiki-vertical-id-7-link' )->inLanguage( $this->targetLang )->text(),
		];
	}

	/**
	 * Get localized strings for social networks and their URLs
	 * @return array
	 * @throws \MWException
	 */
	protected function getSocialMessages() {
		return [
			'facebook' => wfMessage( 'oasis-social-facebook' )->inLanguage( $this->targetLang )->text(),
			'facebook-link' => wfMessage( 'oasis-social-facebook-link' )->inLanguage( $this->targetLang )->text(),
			'twitter' => wfMessage( 'oasis-social-twitter' )->inLanguage( $this->targetLang )->text(),
			'twitter-link' => wfMessage( 'oasis-social-twitter-link' )->inLanguage( $this->targetLang )->text(),
			'youtube' => wfMessage( 'oasis-social-youtube' )->inLanguage( $this->targetLang )->text(),
			'youtube-link' => wfMessage( 'oasis-social-youtube-link' )->inLanguage( $this->targetLang )->text(),
		];
	}

	/**
	 * TODO Move this into unsubscribe extension?
	 * @return string
	 */
	private function getUnsubscribeLink() {
		$params = [
			'email' => $this->targetUser->getEmail(),
			'timestamp' => time()
		];
		$params['token'] = wfGenerateUnsubToken( $params['email'], $params['timestamp'] );
		$unsubscribeTitle = \GlobalTitle::newFromText( 'Unsubscribe', NS_SPECIAL, \Wikia::COMMUNITY_WIKI_ID );
		return $unsubscribeTitle->getFullURL( $params );
	}


	/**
	 * @return String
	 */
	protected function getCurrentProfilePage() {
		if ( $this->currentUser->isLoggedIn() ) {
			return $this->currentUser->getUserPage()->getFullURL();
		}
		return "";
	}

	/**
	 * @return String
	 */
	protected function getCurrentUserName() {
		if ( $this->currentUser->isLoggedIn() )	 {
			return $this->currentUser->getName();
		}
		return wfMessage( "emailext-anonymous-editor" )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * @return String
	 */
	protected function getCurrentAvatarURL() {
		return \AvatarService::getAvatarUrl( $this->currentUser, self::AVATAR_SIZE );
	}


	protected function findUserFromRequest( $paramName, \User $default = null ) {
		$userName = $this->getRequest()->getVal( $paramName );
		if ( empty( $userName ) ) {
			return $default;
		}

		return $this->getUserFromName( $userName );
	}

	/**
	 * Return a user object from a username
	 *
	 * @param string $username
	 *
	 * @return \User
	 * @throws \Email\Fatal
	 */
	protected function getUserFromName( $username ) {
		if ( !$username ) {
			throw new Fatal( 'Required username has been left empty' );
		}

		$user = \User::newFromName( $username );
		$this->assertValidUser( $user );

		return $user;
	}

	/**
	 * @return string
	 */
	protected function getSalutation() {
		return wfMessage( 'emailext-salutation',
			$this->targetUser->getName() )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * A basic check to see if we should send this email or not
	 *
	 * @throws \Email\Check
	 */
	public function assertCanEmail() {
		$this->assertUserHasEmail();
		$this->assertUserWantsEmail();
		$this->assertUserNotBlocked();
	}

	public function assertGoodStatus( \Status $status ) {
		if ( !$status->isGood() ) {
			$msg = wfMessage( "email-error-bad-status", $status->getMessage() )->escaped();
			throw new Fatal( $msg );
		}
	}

	/**
	 * @param $user
	 *
	 * @throws \Email\Fatal
	 */
	public function assertValidUser( $user ) {
		if ( !$user instanceof \User ) {
			throw new Fatal( 'Unable to create user object');
		}

		if ( $user->getId() == 0 ) {
			throw new Fatal( 'Unable to find user' );
		}
	}

	/**
	 * @throws \Email\Fatal
	 */
	public function assertUserHasEmail() {
		$email = $this->targetUser->getEmail();
		if ( empty( $email ) ) {
			throw new Fatal( 'User has no email address' );
		}
	}

	/**
	 * @throws \Email\Fatal
	 */
	public function assertHasIP() {
		$ip = $this->getContext()->getRequest()->getIP();
		if ( !$ip ) {
			throw new Fatal( wfMessage( 'badipaddress' )->escaped() );
		}
	}

	/**
	 * This checks the 'unsubscribed' user option which is linked to the 'Disable all emails from Wikia'
	 * email preference
	 *
	 * @throws \Email\Check
	 */
	public function assertUserWantsEmail() {
		if ( $this->targetUser->getBoolOption( 'unsubscribed' ) ) {
			throw new Check( 'User does not wish to receive email' );
		}
	}

	/**
	 * This checks to see if the current user is blocked
	 *
	 * @throws \Email\Check
	 */
	public function assertUserNotBlocked() {
		if ( $this->currentUser->isBlocked() ) {
			throw new Check( 'User is blocked from taking this action' );
		}
	}
}
