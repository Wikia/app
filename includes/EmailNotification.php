<?php

/**
 * This module processes the email notifications when the current page is
 * changed. It looks up the table watchlist to find out which users are watching
 * that page.
 *
 * The current implementation sends independent emails to each watching user for
 * the following reason:
 *
 * - Each watching user will be notified about the page edit time expressed in
 * his/her local time (UTC is shown additionally). To achieve this, we need to
 * find the individual timeoffset of each watching user from the preferences..
 *
 * Suggested improvement to slack down the number of sent emails: We could think
 * of sending out bulk mails (bcc:user1,user2...) for all these users having the
 * same timeoffset in their preferences.
 *
 * Visit the documentation pages under http://meta.wikipedia.com/Enotif
 *
 *
 */
class EmailNotification {

	/**
	 * @var User
	 */
	private $editor;

	/**
	 * @var Title
	 */
	private $title;

	private $timestamp;

	private $summary;

	private $minorEdit;

	private $currentRevId;

	private $previousRevId;

	private $action;

	private $otherParam;

	private $subject;

	private $body;

	private $replyto;

	private $from;

	private $bodyHTML;

	private $composedCommon = false;

	/**
	 * @param User $editor
	 * @param Title $title
	 * @param string $timestamp : Edit timestamp
	 * @param string $summary : Edit summary
	 * @param bool $minorEdit
	 * @param int $currentRevId : Revision ID
	 * @param int $previousRevId : Revision ID
	 * @param string $action
	 * @param array $otherParam
	 */
	public function __construct( $editor, $title, $timestamp, $summary, $minorEdit, $currentRevId = 0, $previousRevId = 0, $action = '', $otherParam = [] ) {
		$this->editor = $editor;
		$this->title = $title;
		$this->timestamp = $timestamp;
		$this->summary = $summary;
		$this->minorEdit = $minorEdit;
		$this->currentRevId = $currentRevId;
		$this->previousRevId = $previousRevId;
		$this->action = $action;
		$this->otherParam = $otherParam;
	}

	/**
	 * Send emails corresponding to the user $editor editing the page $title.
	 * Also updates wl_notificationtimestamp.
	 *
	 * May be deferred via the job queue.
	 *
	 * @param array $watchers If a list of watchers is passed, use these rather than querying the DB
	 */
	public function notifyOnPageChange( array $watchers = [] ) {

		if ( $this->title->getNamespace() < 0 ) {
			return;
		}

		if ( !wfRunHooks( 'AllowNotifyOnPageChange', [ $this->editor, $this->title ] ) ) {
			return;
		}

		if ( ( $this->isArticleComment() || $this->isBlogComment() ) && $this->previousRevId !== 0 ) {
			// Ignore edited or deleted comments
			return;
		}

		// Build a list of users to notify
		if ( F::app()->wg->EnotifWatchlist || F::app()->wg->ShowUpdatedMarker ) {
			$notificationTimeoutSql = $this->getTimeOutSql();

			if ( empty( $watchers ) ) {
				$watchers = $this->getWatchersToNotify( $notificationTimeoutSql );
			}

			if ( $watchers ) {
				$this->updateWatchedItem( $watchers );
			}
			wfRunHooks( 'NotifyOnSubPageChange', [ $watchers, $this->title, $this->editor, $notificationTimeoutSql ] );
		}

		if ( $this->shouldSendEmail( $watchers ) ) {
			$this->actuallyNotifyOnPageChange( $watchers );
		}
	}

	/**
	 * Add a timeout to the watchlist email block
	 */
	private function getTimeOutSql() {
		if ( !empty( $this->otherParam['notisnull'] ) ) {
			$notificationTimeoutSql = "1";
		} elseif ( !empty( F::app()->wg->EnableWatchlistNotificationTimeout ) && isset( F::app()->wg->WatchlistNotificationTimeout ) ) {
			$blockTimeout = wfTimestamp( TS_MW, wfTimestamp( TS_UNIX, $this->timestamp ) - intval( F::app()->wg->WatchlistNotificationTimeout ) );
			$notificationTimeoutSql = "wl_notificationtimestamp IS NULL OR wl_notificationtimestamp < '$blockTimeout'";
		} else {
			$notificationTimeoutSql = 'wl_notificationtimestamp IS NULL';
		}

		return $notificationTimeoutSql;
	}

	private function getWatchersToNotify( $notificationTimeoutSql ) {
		$watchers = [];
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			[ 'watchlist' ],
			[ 'wl_user' ],
			[
				'wl_title' => $this->title->getDBkey(),
				'wl_namespace' => $this->title->getNamespace(),
				'wl_user != ' . intval( $this->editor->getID() ),
				$notificationTimeoutSql
			],
			__METHOD__
		);

		foreach ( $res as $row ) {
			/** @var stdClass $row */
			$watchers[] = $row->wl_user;
		}

		return $watchers;
	}

	/**
	 * Update wl_notificationtimestamp for all watching users except the editor
	 */
	private function updateWatchedItem( array $watchers ) {
		$wl = WatchedItem::fromUserTitle( $this->editor, $this->title );
		$wl->updateWatch( $watchers, $this->timestamp );
	}

	/**
	 * Check if there are either 1.) users watching the page, or 2.) the page which was
	 * edited is a User Talk page and the owner of that page wants to receive notifications
	 * when their User Talk page is changed.
	 * @param array $watchers
	 * @return bool
	 */
	private function shouldSendEmail( array $watchers ) {
		if ( $this->thereAreUsersWatchingPage( $watchers ) ) {
			return true;
		}

		if ( $this->isUserTalkPage() && $this->canSendUserTalkEmail() ) {
			return true;
		}

		return false;
	}

	/**
	 * @param array $watchers
	 * @return bool
	 */
	private function thereAreUsersWatchingPage( array $watchers ) {
		return count( $watchers ) || count( F::app()->wg->UsersNotifiedOnAllChanges );
	}

	/**
	 * @return bool
	 */
	private function canSendUserTalkEmail() {
		// Should we notify users when their user talk page is changed?
		if ( empty( F::app()->wg->EnotifUserTalk ) ) {
			return false;
		}

		$targetUser = User::newFromName( $this->title->getText() );

		// Does the user whose talk page was edited exist?
		if ( !$targetUser instanceof User ) {
			return false;
		}

		// Is that user anonymous?
		if ( $targetUser->isAnon() ) {
			return false;
		}

		// Is that user the same user who made the edit?
		if ( $targetUser->getId() === $this->editor->getId() ) {
			return false;
		}

		// Is it a minor edit?
		if ( $this->isMinorEdit() ) {
			// Do we want to notify users about minor edits?
			if ( !F::app()->wg->EnotifMinorEdits ) {
				return false;
			}

			// Does the editor does want users to be notified when they make minor edits on a discussion page?
			if ( $this->editor->isAllowed( 'nominornewtalk' ) ) {
				return false;
			}

			// Does that user want to know about minor edits?
			if ( !$targetUser->getGlobalPreference( 'enotifminoredits' ) ) {
				return false;
			}
		}

		// Does that user want to be notified about changes to their talk page?
		if ( !$targetUser->getGlobalPreference( 'enotifusertalkpages' ) ) {
			return false;
		}

		// Does that user have a confirmed email?
		if ( !$targetUser->isEmailConfirmed() ) {
			return false;
		}

		return true;
	}

	/**
	 * Immediate version of notifyOnPageChange().
	 *
	 * Send emails corresponding to the user $editor editing the page $title.
	 * Also updates wl_notificationtimestamp.
	 *
	 * @param array $watchers
	 */
	private function actuallyNotifyOnPageChange( $watchers ) {

		$this->setReplyToAndFromAddresses();

		# The following code is only run, if several conditions are met:
		# 1. EmailNotification for pages (other than user_talk pages) must be enabled
		# 2. minor edits (changes) are only regarded if the global flag indicates so
		if ( !$this->isMinorEdit() || ( $this->notifyUsersOnMinorEdits() && $this->editorWantsToNotifyOnMinorEdits() ) ) {

			$userTalkId = 0;
			if ( $this->isUserTalkPage() && $this->canSendUserTalkEmail() ) {
				$targetUser = User::newFromName( $this->title->getText() );
				$this->compose( $targetUser );
				$userTalkId = $targetUser->getId();

				// Send mail to user when comment on his user talk has been added
				$fakeUser = null;
				wfRunHooks( 'UserMailer::NotifyUser', [ $this->title, &$fakeUser ] );
				if ( $fakeUser instanceof User && $fakeUser->getGlobalPreference( 'enotifusertalkpages' ) && $fakeUser->isEmailConfirmed() ) {
					$this->compose( $fakeUser );
				}
			}

			if ( F::app()->wg->EnotifWatchlist ) {
				// Send updates to watchers other than the current editor
				$userArray = UserArray::newFromIDs( $watchers );

				/* @var $watchingUser User */
				foreach ( $userArray as $watchingUser ) {
					if ( $watchingUser->getGlobalPreference( 'enotifwatchlistpages' ) &&
						( !$this->isMinorEdit() || $watchingUser->getGlobalPreference( 'enotifminoredits' ) ) &&
						$watchingUser->isEmailConfirmed() &&
						$watchingUser->getID() != $userTalkId &&
						!(bool)$watchingUser->getGlobalPreference( 'unsubscribed' ) )
					{
						$this->compose( $watchingUser );
					}
				}
			}
		}
		$this->emailUsersNotifiedOnAllChanges();
	}

	private function setReplyToAndFromAddresses() {
		# Reveal the page editor's address as REPLY-TO address only if
		# the user has not opted-out and the option is enabled at the
		# global configuration level.
		$adminAddress = new MailAddress( F::app()->wg->PasswordSender, F::app()->wg->PasswordSenderName );
		if ( F::app()->wg->EnotifRevealEditorAddress
			&& ( $this->editor->getEmail() != '' )
			&& $this->editor->getGlobalPreference( 'enotifrevealaddr' ) )
		{
			$editorAddress = new MailAddress( $this->editor );
			if ( F::app()->wg->EnotifFromEditor ) {
				$this->from    = $editorAddress;
			} else {
				$this->from    = $adminAddress;
				$this->replyto = $editorAddress;
			}
		} else {
			$this->from    = $adminAddress;
			$this->replyto = new MailAddress( F::app()->wg->NoReplyAddress );
		}
	}

	private function emailUsersNotifiedOnAllChanges() {
		foreach ( F::app()->wg->UsersNotifiedOnAllChanges as $name ) {
			// No point notifying the user that actually made the change!
			if ( $this->editor->getName() == $name ) {
				continue;
			}
			$user = User::newFromName( $name );
			$this->compose( $user );
		}
	}

	/**
	 * Generate the generic "this page has been changed" e-mail text.
	 */
	private function composeCommonMailtext() {

		$this->composedCommon = true;

		$action = strtolower( $this->action );
		$subject = wfMessage( 'enotif_subject_' . $action )->inContentLanguage()->text();
		if ( wfEmptyMsg( 'enotif_subject_' . $action, $subject ) ) {
			$subject = wfMessage( 'enotif_subject' )->inContentLanguage()->text();
		}
		list ( $body, $bodyHTML ) = wfMsgHTMLwithLanguageAndAlternative(
			'enotif_body' . ( $action == '' ? '' : ( '_' . $action ) ),
			'enotif_body',
			F::app()->wg->LanguageCode
		);

		# You as the WikiAdmin and Sysops can make use of plenty of
		# named variables when composing your notification emails while
		# simply editing the Meta pages

		$keys = [];
		$postTransformKeys = [];

		if ( $action == '' ) {
			// no previousRevId + empty action = create edit, ok to use newpagetext
			$keys['$NEWPAGEHTML'] = $keys['$NEWPAGE'] = wfMessage( 'enotif_newpagetext' )->inContentLanguage()->plain();
		} else {
			// no previousRevId + action = event, dont show anything, confuses users
			$keys['$NEWPAGEHTML'] = $keys['$NEWPAGE'] = '';
		}
		# clear $OLDID placeholder in the message template
		$keys['$OLDID']   = '';
		$keys['$CHANGEDORCREATED'] = wfMessage( 'created' )->inContentLanguage()->plain();

		$keys['$PAGETITLE'] = $this->title->getPrefixedText();
		$keys['$PAGETITLE_URL'] = $this->title->getCanonicalUrl( 's=wl' );
		$keys['$PAGEMINOREDIT'] = $this->minorEdit ? wfMessage( 'minoredit' )->inContentLanguage()->plain() : '';
		$keys['$UNWATCHURL'] = $this->title->getCanonicalUrl( 'action=unwatch' );

		$keys['$ACTION'] = $this->action;
		// Hook registered in FollowHelper -- used for blogposts and categoryAdd
		wfRunHooks( 'MailNotifyBuildKeys', [ &$keys, $this->action, $this->otherParam ] );

		if ( $this->editor->isAnon() ) {
			# real anon (user:xxx.xxx.xxx.xxx)
			$keys['$PAGEEDITOR'] = wfMessage( 'enotif_anon_editor', $this->editor->getName() )->inContentLanguage()->plain();
			$keys['$PAGEEDITOR_EMAIL'] = wfMessage( 'noemailtitle' )->inContentLanguage()->plain();
		} else {
			$keys['$PAGEEDITOR'] = F::app()->wg->EnotifUseRealName ? $this->editor->getRealName() : $this->editor->getName();
			$emailPage = SpecialPage::getSafeTitleFor( 'Emailuser', $this->editor->getName() );
			$keys['$PAGEEDITOR_EMAIL'] = $emailPage->getCanonicalUrl();
		}

		$keys['$PAGEEDITOR_WIKI'] = $this->editor->getUserPage()->getCanonicalUrl();

		$summary = $this->summary == '' ? wfMessage( 'enotif_no_summary' )->inContentLanguage()->plain() : '"' . $this->summary . '"';

		$postTransformKeys['$PAGESUMMARY'] = $summary;

		// Now build message's subject and body
		// ArticleComment -- updates subject and $keys['$PAGEEDITOR'] if anon editor
		// EmailTemplatesHooksHelper -- updates subject if blogpost
		// TopListHelper -- updates subject if title is toplist
		wfRunHooks( 'ComposeCommonSubjectMail', [ $this->title, &$keys, &$subject, $this->editor ] );
		$subject = strtr( $subject, $keys );
		$subject = MessageCache::singleton()->transform( $subject, false, null, $this->title );
		$this->subject = strtr( $subject, $postTransformKeys );

		// ArticleComment -- updates body and $keys['$PAGEEDITOR'] if anon editor
		// EmailTemplatesHooksHelper -- changes body to blog post. EmailTemplates only enabled on community and messaging so this tranforms
		//     any watched page email coming from Community to a blog post (I think)
		// TopListHelper -- updates body if title is toplist
		wfRunHooks( 'ComposeCommonBodyMail', [ $this->title, &$keys, &$body, $this->editor, &$bodyHTML, &$postTransformKeys ] );
		$body = strtr( $body, $keys );
		$body = MessageCache::singleton()->transform( $body, false, null, $this->title );
		$this->body = wordwrap( strtr( $body, $postTransformKeys ), 72 );

		if ( $bodyHTML ) {
			$bodyHTML = strtr( $bodyHTML, $keys );
			$bodyHTML = MessageCache::singleton()->transform( $bodyHTML, false, null, $this->title );
			$this->bodyHTML = strtr( $bodyHTML, $postTransformKeys );
		}
	}

	/**
	 * Compose a mail to a given user and either queue it for sending, or send it now,
	 * depending on settings.
	 *
	 * Call sendMails() to send any mails that were queued.
	 * @param $user User
	 */
	private function compose( \User $user ) {
		if ( $this->getEmailExtensionController() !== false ) {
			$this->sendUsingEmailExtension( $user );
		} else {
			$logger = \Wikia\Logger\WikiaLogger::instance();
			$emailContext = [
				'page' => $this->title->getDBkey(),
				'summary' => $this->summary,
				'action' => $this->action,
				'subject' => $this->subject,
			];

			if ( \F::app()->wg->DisableOldStyleEmail ) {
				$emailContext['issue'] = 'SOC-2290';
				$logger->info( 'Skipped sending old style email', $emailContext );
			} else {
				$logger->notice( 'Sending via UserMailer', $emailContext );
				$this->sendUsingUserMailer( $user );
			}
		}

		wfRunHooks( 'NotifyOnPageChangeComplete', [ $this->title, $this->timestamp, &$user ] );
	}

	private function getEmailExtensionController() {
		// Definitely can't send if the extension isn't enabled
		if ( empty( F::app()->wg->EnableEmailExt ) ) {
			return false;
		}

		$controller = false;

		if ( $this->isArticlePageEditOrCreatedPage() ) {
			$controller = 'Email\Controller\WatchedPageEditedOrCreated';
		} elseif ( $this->isArticlePageRenamed() ) {
			$controller = 'Email\Controller\WatchedPageRenamed';
		} elseif ( $this->isArticlePageProtected() ) {
			$controller = 'Email\Controller\WatchedPageProtected';
		} elseif ( $this->isArticlePageUnprotected() ) {
			$controller = 'Email\Controller\WatchedPageUnprotected';
		} elseif ( $this->isArticlePageDeleted() ) {
			$controller = 'Email\Controller\WatchedPageDeleted';
		} elseif ( $this->isArticlePageRestored() ) {
			$controller = 'Email\Controller\WatchedPageRestored';
		} elseif ( $this->isArticleComment() ) {
			$controller = 'Email\Controller\ArticleComment';
		} elseif ( $this->isBlogComment() ) {
			$controller = 'Email\Controller\BlogComment';
		} elseif ( $this->isListBlogPost() ) {
			$controller = 'Email\Controller\ListBlogPost';
		} elseif ( $this->isUserBlogPost() ) {
			$controller = 'Email\Controller\UserBlogPost';
		} elseif ( $this->isCategoryAdd() ) {
			$controller = 'Email\Controller\CategoryAdd';
		} elseif ( $this->isUserRightsChange() ) {
			$controller = 'Email\Controller\UserRightsChanged';
		}

		return $controller;
	}

	/**
	 * Send a watched page edit email using the new Email extension.

	 * @param User $user
	 */
	private function sendUsingEmailExtension( \User $user ) {
		$controller = $this->getEmailExtensionController();

		if ( !empty( $controller ) ) {
			$childArticleID = '';
			if ( !empty( $this->otherParam['childTitle'] ) ) {
				/** @var Title $childTitleObj */
				$childTitleObj = $this->otherParam['childTitle'];
				$childArticleID = $childTitleObj->getArticleID();
			}

			$params = [
				'targetUser' => $user->getName(),
				'pageTitle' => $this->title->getText(),
				'namespace' => $this->title->getNamespace(),
				'summary' => $this->summary,
				'currentRevId' => $this->currentRevId,
				'previousRevId' => $this->previousRevId,
				'replyToAddress' => $this->replyto,
				'fromAddress' => $this->from->address,
				'fromName' => $this->from->name,
				'childArticleID' => $childArticleID,
			];

			F::app()->sendRequest( $controller, 'handle', $params );
		}
	}
	/**
	 * Returns whether the email notification is for a watched article page which has been edited,
	 * or for a newly created page. The other possible values for action are categoryadd, blogpost,
	 * and article_comment.
	 *
	 * @return bool
	 */
	private function isArticlePageEditOrCreatedPage() {
		return empty( $this->action );
	}

	/**
	 * Check if performed action is page rename
	 *
	 * @return bool
	 */
	private function isArticlePageRenamed() {
		return in_array( $this->action, [ 'move_redir', 'move' ] );
	}

	/**
	 * Check if performed action is adding page protection
	 *
	 * @return bool
	 */
	private function isArticlePageProtected() {
		return in_array( $this->action, [ 'protect', 'modify' ] );
	}

	/**
	 * Check if performed action is removal of page protection
	 *
	 * @return bool
	 */
	private function isArticlePageUnprotected() {
		return in_array( $this->action, [ 'unprotect' ] );
	}

	/**
	 * Check if performed action is page deletion
	 *
	 * @return bool
	 */
	private function isArticlePageDeleted() {
		return in_array( $this->action, [ 'delete' ] );
	}

	/**
	 * Check if the performed action is page restoration
	 *
	 * @return bool
	 */
	private function isArticlePageRestored() {
		return $this->action == "restore";
	}

	private function isArticleComment() {
		// A blog has a specific namespace while an article could have a number of
		// different namespaces.  To decide if this is an article, just make sure
		// its not a blog.
		return (
			( $this->action === ArticleComment::LOG_ACTION_COMMENT ) &&
			( $this->title->getNamespace() != NS_BLOG_ARTICLE )
		);
	}

	private function isBlogComment() {
		return (
			( $this->action === ArticleComment::LOG_ACTION_COMMENT ) &&
			( $this->title->getNamespace() == NS_BLOG_ARTICLE )
		);
	}

	private function isUserBlogPost() {
		$ns = $this->title->getNamespace();
		return (
			( $this->action === FollowHelper::LOG_ACTION_BLOG_POST ) &&
			( $ns == NS_BLOG_ARTICLE )
		);
	}

	private function isListBlogPost() {
		$ns = $this->title->getNamespace();
		return (
			( $this->action === FollowHelper::LOG_ACTION_BLOG_POST ) &&
			( $ns == NS_BLOG_LISTING )
		);
	}

	private function isCategoryAdd() {
		return $this->action == FollowHelper::LOG_ACTION_CATEGORY_ADD;
	}

	private function isUserRightsChange() {
		return $this->action == 'rights';
	}

	private function sendUsingUserMailer( \User $user ) {
		if ( !$this->composedCommon ) {
			$this->composeCommonMailtext();
		}
		$this->sendPersonalised( $user );
	}

	/**
	 * Does the per-user customizations to a notification e-mail (name,
	 * timestamp in proper timezone, etc) and sends it out.
	 * Returns true if the mail was sent successfully.
	 *
	 * @param User $watchingUser User object
	 * @return Boolean
	 * @private
	 */
	private function sendPersonalised( $watchingUser ) {
		$to = new MailAddress( $watchingUser );
		$body = $this->expandBodyVariables( $watchingUser, $this->body );

		if ( $watchingUser->getGlobalPreference( 'htmlemails' ) && !empty( $this->bodyHTML ) ) {
			$bodyHTML = $this->expandBodyVariables( $watchingUser, $this->bodyHTML );
			# now body is array with text and html version of email
			$body = [ 'text' => $body, 'html' => $bodyHTML ];
		}

		UserMailer::send( $to, $this->from, $this->subject, $body, $this->replyto );
	}

	private function expandBodyVariables( User $watchingUser, $content ) {
		$name = F::app()->wg->EnotifUseRealName
			? $watchingUser->getRealName()
			: $watchingUser->getName();

		// $PAGEEDITDATE is the time and date of the page change expressed in terms
		// of individual local time of the notification recipient, i.e. watching user
		return str_replace(
			[
				'$WATCHINGUSERNAME',
				'$PAGEEDITDATE',
				'$PAGEEDITTIME'
			],
			[
				$name,
				F::app()->wg->ContLang->userDate( $this->timestamp, $watchingUser ),
				F::app()->wg->ContLang->userTime( $this->timestamp, $watchingUser )
			],
			$content
		);
	}

	/**
	 * Returns whether the edited page is a User Talk page.
	 * @return bool
	 */
	private function isUserTalkPage() {
		return $this->title->getNamespace() == NS_USER_TALK;
	}

	/**
	 * Returns whether the edit was minor or not.
	 * @return bool
	 */
	private function isMinorEdit() {
		return $this->minorEdit;
	}

	/**
	 * Returns whether this Wikia is configured to notify users on minor edits.
	 * @return bool
	 */
	private function notifyUsersOnMinorEdits() {
		return !empty( F::app()->wg->EnotifMinorEdits );
	}

	/**
	 * Returns whether the page editor wants to notify users if the edit was minor.
	 * @return bool
	 */
	private function editorWantsToNotifyOnMinorEdits() {
		return !$this->editor->isAllowed( 'nominornewtalk' );
	}
}
