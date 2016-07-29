<?php

namespace Email;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Wikia\Logger\WikiaLogger;

abstract class EmailController extends \WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	const TRACKED_LANGUAGES = [ 'EN', 'PL', 'DE', 'ES', 'FR', 'IT', 'JA', 'NL', 'PT', 'RU', 'ZH' ];

	const AVATAR_SIZE = 50;

	/** CSS used for the main content section of each email. Used by getContent()
	 * and intended to be overridden by child classes. */
	const LAYOUT_CSS = 'avatarLayout.css';

	/** Used by emails that don't want to apply any additional styles */
	const NO_ADDITIONAL_STYLES = '';

	/** Regular expression pattern used to find all email controller classes inside
	 * of $wgAutoLoadClasses */
	const EMAIL_CONTROLLER_REGEX = "/^Email\\\\Controller\\\\(.+)Controller$/";

	// Used when needing to specify an anonymous user from the external API
	const ANONYMOUS_USER_ID = -1;

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

			// If we're calling an internal handler, don't go through this init again
			if ( $this->getVal( 'disableInit', false ) ) {
				return;
			}

			$this->currentUser = $this->findUserFromRequest( 'currentUser',  'currentUserId' );
			$this->targetUser = $this->findUserFromRequest( 'targetUser',  'targetUserId' );
			$this->targetLang = $this->getVal( 'targetLang', $this->targetUser->getGlobalPreference( 'language' ) );
			$this->test = $this->getVal( 'test', false );
			$this->marketingFooter = $this->request->getBool( 'marketingFooter' );

			$noReplyName = $this->getMessage( 'emailext-no-reply-name' )->escaped();

			$this->replyToAddress = new \MailAddress(
				$this->getVal( 'replyToAddress', $this->wg->NoReplyAddress ),
				$this->getVal( 'replyToName', $noReplyName )
			);

			$fromAddress = $this->getVal( 'fromAddress', $this->wg->PasswordSender );
			$this->assertValidFromAddress( $fromAddress );

			$this->fromAddress = new \MailAddress(
				$fromAddress,
				$this->getVal( 'fromName', $this->wg->PasswordSenderName )
			);

			$this->initEmail();
		} catch ( \Exception $e ) {
			$this->setErrorResponse( $e );
		}
	}

	/**
	 * Make sure to only allow authorized use of this extension.
	 *
	 * @throws \Email\Fatal
	 */
	public function assertCanAccessController() {
		if ( Helper::userCanAccess() ) {
			return;
		}

		if ( $this->request->isInternal() ) {
			return;
		}

		throw new Fatal( 'Access to this controller is restricted' );
	}

	protected function assertValidFromAddress( $email ) {
		if ( !\Sanitizer::validateEmail( $email ) ) {
			throw new Check( "Invalid from address '$email'" );
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
				$this->trackEmailEvent();

				$status = \UserMailer::send(
					$toAddress,
					$fromAddress,
					$subject,
					$body,
					$replyToAddress,
					$contentType = null,
					$this->getSendGridCategory(),
					$priority = 0,
					$attachments = [],
					$sourceType = 'email-ext' // Remove when this is the only sourceType sent
				);
				$this->assertGoodStatus( $status );
				$this->afterSuccess();
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

		$this->trackEmailError( $e, $result );

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
		$to = new \MailAddress( $this->getTargetUserEmail(), $this->getTargetUserName() );
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
	abstract protected function getSubject();

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
				'disableInit' => true,
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
	 * Returns the category string we'll send to SendGrid with this email for
	 * tracking purposes.
	 *
	 * @return string
	 */
	public function getSendGridCategory() {
		$short = $this->getControllerShortName();
		$lang = $this->getLangForTracking();

		return  $short . '-' . $lang;
	}

	/**
	 * Return the language code we'll use for tracking.  If the current language is not
	 * one of our currently supported languages, use code 'xx'.
	 *
	 * @return string
	 */
	protected function getLangForTracking() {
		$lang = 'EN';
		if ( preg_match( '/^([^_-]+)/', $this->targetLang, $matches ) ) {
			$lang = strtoupper( $matches[1] );
		}

		return in_array( $lang, self::TRACKED_LANGUAGES ) ? $lang : 'XX';
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
			$this->getMessage( 'emailext-recipient-notice', $this->getTargetUserEmail() )
				->parse(),
			$this->getMessage( 'emailext-update-frequency' )
				->parse(),
			$this->getMessage( 'emailext-unsubscribe', $this->getUnsubscribeLink() )
				->parse(),
		];
	}

	/**
	 * Tagline text that appears in the email footer
	 * @return String
	 */
	protected function getTagline() {
		return $this->getMessage( 'emailext-fans-tagline' )->text();
	}

	/**
	 * Get localized strings for hubs names and their URLs
	 * @return array
	 * @throws \MWException
	 */
	protected function getHubsMessages() {
		return [
			'tv' => $this->getMessage( 'oasis-label-wiki-vertical-id-1' )->text(),
			'tvURL' => $this->getMessage( 'oasis-label-wiki-vertical-id-1-link' )->text(),
			'videoGames' => $this->getMessage( 'oasis-label-wiki-vertical-id-2' )->text(),
			'videoGamesURL' => $this->getMessage( 'oasis-label-wiki-vertical-id-2-link' )->text(),
			'books' => $this->getMessage( 'oasis-label-wiki-vertical-id-3' )->text(),
			'booksURL' => $this->getMessage( 'oasis-label-wiki-vertical-id-3-link' )->text(),
			'comics' => $this->getMessage( 'oasis-label-wiki-vertical-id-4' )->text(),
			'comicsURL' => $this->getMessage( 'oasis-label-wiki-vertical-id-4-link' )->text(),
			'lifestyle' => $this->getMessage( 'oasis-label-wiki-vertical-id-5' )->text(),
			'lifestyleURL' => $this->getMessage( 'oasis-label-wiki-vertical-id-5-link' )->text(),
			'music' => $this->getMessage( 'oasis-label-wiki-vertical-id-6' )->text(),
			'musicURL' => $this->getMessage( 'oasis-label-wiki-vertical-id-6-link' )->text(),
			'movies' => $this->getMessage( 'oasis-label-wiki-vertical-id-7' )->text(),
			'moviesURL' => $this->getMessage( 'oasis-label-wiki-vertical-id-7-link' )->text(),
		];
	}

	/**
	 * Get localized strings for social networks and their URLs
	 * @return array
	 * @throws \MWException
	 */
	protected function getSocialMessages() {
		return [
			'facebook' => $this->getMessage( 'oasis-social-facebook' )->text(),
			'facebook-link' => $this->getMessage( 'oasis-social-facebook-link' )->text(),
			'twitter' => $this->getMessage( 'oasis-social-twitter' )->text(),
			'twitter-link' => $this->getMessage( 'oasis-social-twitter-link' )->text(),
			'youtube' => $this->getMessage( 'oasis-social-youtube' )->text(),
			'youtube-link' => $this->getMessage( 'oasis-social-youtube-link' )->text(),
		];
	}

	/**
	 * TODO Move this into unsubscribe extension?
	 * @return string
	 */
	protected function getUnsubscribeLink() {
		$params = [
			'email' => $this->getTargetUserEmail(),
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
		return $this->getMessage( "emailext-anonymous-editor" )->text();
	}

	/**
	 * @return String
	 */
	protected function getCurrentAvatarURL() {
		return $this->getAvatarURL( $this->currentUser );
	}

	protected function getAvatarURL( \User $user ) {
		return \AvatarService::getAvatarUrl( $user, self::AVATAR_SIZE );
	}

	protected function findUserFromRequest( $userNameParam, $userIdParam ) {
		$userName = $this->getRequest()->getVal( $userNameParam );
		$userId = $this->getRequest()->getVal( $userIdParam );

		if ( !empty( $userName ) ) {
			return $this->getUserFromName( $userName );
		}

		if ( !empty( $userId ) ) {
			return \User::newFromId( $userId );
		}

		return $this->wg->User;
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

		// Allow an anonymous user to be specified
		if ( $username == self::ANONYMOUS_USER_ID ) {
			return \User::newFromId( 0 );
		}

		if ( $username instanceof \User ) {
			$user = $username;
		} else if ( is_object( $username ) ) {
			throw new Fatal( 'Non-user object passed when user object or username expected' );
		} else {
			$user = \User::newFromName( $username, $validate = false );
		}
		$this->assertValidUser( $user );

		return $user;
	}

	/**
	 * @return string
	 */
	protected function getSalutation() {
		return $this->getMessage( 'emailext-salutation', $this->getTargetUserName() )->text();
	}

	protected function getTargetUserName() {
		return $this->targetUser->getName();
	}

	protected function getTargetUserEmail() {
		return $this->targetUser->getEmail();
	}

	/**
	 * A basic check to see if we should send this email or not
	 *
	 * @throws \Email\Check
	 */
	public function assertCanEmail() {
		$this->assertUserHasEmail();
		$this->assertUserWantsEmail();
		$this->assertEmailIsConfirmed();
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
	}

	/**
	 * @throws \Email\Fatal
	 */
	public function assertUserHasEmail() {
		$email = $this->getTargetUserEmail();
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
		if ( (bool)$this->targetUser->getGlobalPreference( 'unsubscribed' ) ) {
			throw new Check( 'User does not wish to receive email' );
		}
	}

	/**
	 * This checks if the user has confirmed their email address
	 *
	 * @throws \Email\Check
	 */
	public function assertEmailIsConfirmed() {
		if ( !$this->targetUser->isEmailConfirmed() ) {
			throw new Check( 'User does not have a confirmed email address' );
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

	/**
	 * Allow child classes to perform actions after an email is successfully
	 * sent
	 */
	protected function afterSuccess() {}

	/**
	 * Get the form field for this email to be used on Special:SendEmail
	 * @return array
	 */
	public static function getAdminForm() {
		return array_merge_recursive(
			self::getBaseFormFields(),
			static::getEmailSpecificFormFields()
		);
	}

	/**
	 * Get the common form fields used by all emails on Special:SendEmail.
	 *
	 * @return array
	 */
	private static function getBaseFormFields() {
		$baseForm = [
			'inputs' => [
				[
					'type' => 'hidden',
					'name' => 'token',
					'value' => \F::app()->wg->User->getEditToken()
				],
				[
					'type' => 'hidden',
					'name' => 'emailController',
					'value' => get_called_class()
				],
				[
					'type' => 'text',
					'name' => 'targetUser',
					'label' => 'Target User',
					'tooltip' => 'User to send the email to',
					'value' => htmlspecialchars(  \F::app()->wg->User->getName(), ENT_QUOTES )
				],
				[
					'type' => 'select',
					'name' => 'targetLang',
					'label' => 'Language',
					'tooltip' => 'The language of the email',
					'options' => [
						[ 'value' => 'en', 'content' => 'English' ],
						[ 'value' => 'de', 'content' => 'German' ],
						[ 'value' => 'es', 'content' => 'Spanish' ],
						[ 'value' => 'fr', 'content' => 'French' ],
						[ 'value' => 'it', 'content' => 'Italian' ],
						[ 'value' => 'ja', 'content' => 'Japanese' ],
						[ 'value' => 'nl', 'content' => 'Dutch' ],
						[ 'value' => 'pl', 'content' => 'Polish' ],
						[ 'value' => 'pt', 'content' => 'Portuguese' ],
						[ 'value' => 'ru', 'content' => 'Russian' ],
						[ 'value' => 'zh-hans', 'content' => 'Chinese Simplified' ],
						[ 'value' => 'zh-tw', 'content' => 'Chinese Taiwan' ],
					]

				],
			],
			'submits' => [
				'value' => "Send Email",
			],
			'method' => 'post',
			'legend' => self::getLegendName()
		];

		return $baseForm;
	}

	/**
	 * This method is overridden by most subclasses of the EmailController. It returns a list of
	 * form fields which are specific to that email and are required for it's form found on
	 * Special:SendEmail (eg, the WatchedPage email requires a Title and 2 revision IDs, in addition
	 * to all of the fields from EmailController::getBaseFormFields).
	 *
	 * @return array
	 */
	protected static function getEmailSpecificFormFields() {
		return [];
	}

	/**
	 * Get the legend to display over this emails Special:SendEmail form. eg "WatchedPage Email" or
	 * "ForgottenPassword Email"
	 *
	 * @return string
	 */
	private static function getLegendName() {
		$legendName = self::getControllerShortName() . ' Email';
		return $legendName;
	}

	/**
	 * Get a shortened version of the controller name.  Useful for admin tool and email category
	 *
	 * @return string
	 */
	public static function getControllerShortName() {
		$name = get_called_class();
		if ( preg_match( self::EMAIL_CONTROLLER_REGEX, $name, $matches ) ) {
			$name = $matches[1];
		}

		return $name;
	}

	/**
	 * A wrapper for wfMessage() which removes the possibility of messages being overridden in the MediaWiki namespace
	 *
	 * @return \Message
	 */
	protected function getMessage() {
		return call_user_func_array( 'wfMessage', func_get_args() )
			->useDatabase( false )
			->inLanguage( $this->targetLang );
	}

	private function trackEmailEvent() {
		WikiaLogger::instance()->info( 'Submitting email via UserMailer', [
			'issue' => 'SOC-910',
			'method' => __METHOD__,
			'controller' => self::getControllerShortName(),
			'toAddress' => $this->getToAddress()->toString(),
			'fromAddress' => $this->getFromAddress()->toString(),
			'subject' => $this->getSubject(),
			'category' => $this->getSendGridCategory(),
			'currentUser' => $this->getCurrentUserName(),
			'targetUser' => $this->getTargetUserName(),
			'targetLang' => $this->targetLang,
		] );
	}

	private function trackEmailError( \Exception $e, $result ) {
		if ( $this->currentUser instanceof \User ) {
			$currentName = $this->currentUser->getName();
		} else {
			$currentName = 'unknown';
		}

		if ( $this->targetUser instanceof \User ) {
			$targetName = $this->getTargetUserName();
		} else {
			$targetName = 'unknown';
		}

		WikiaLogger::instance()->error( 'Failed to submit email via UserMailer', [
			'issue' => 'SOC-910',
			'method' => __METHOD__,
			'controller' => self::getControllerShortName(),
			'category' => $this->getSendGridCategory(),
			'errorMessage' => $e->getMessage(),
			'currentUser' => $currentName,
			'targetUser' => $targetName,
			'targetLang' => $this->targetLang,
			'result' => $result,
		] );
	}
}
