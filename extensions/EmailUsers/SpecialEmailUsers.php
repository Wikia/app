<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

class SpecialEmailUsers extends SpecialPage {
	function __construct() {
		parent::__construct( 'EmailUsers', 'sendbatchemail' );
	}

	function execute( $par ) {
		global $wgOut, $wgUser, $wgEmailAuthentication;

		$this->setHeaders();

		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$error = SpecialEmailUser::getPermissionsError( $wgUser, $wgUser->editToken() );

		if ( $error ) {
			switch ( $error ) {
			case 'blockedemailuser':
				$wgOut->blockedPage();
				return;
			case 'actionthrottledtext':
				$wgOut->rateLimited();
				return;
			case 'mailnologin':
				$wgOut->showErrorPage( 'mailnologin', 'mailnologintext' );
				return;
			default:
				list( $title, $msg, $params ) = $error;
				$wgOut->showErrorPage( $title, $msg, $params );
				return;
			}
		}

		$dbr = wfGetDB( DB_SLAVE );

		# $conds can be not that strict but cannot be too strict.
		$conds = array( "user_email <> ''" );
		if ( $wgEmailAuthentication ) {
			$conds[] = 'user_email_authenticated IS NOT NULL';
		}

		$res = $dbr->select( 'user', '*', $conds );
		$users = UserArray::newFromResult( $res );

		$usernames = array();

		foreach ( $users as $user ) {
			if ( $user->canReceiveEmail() && $user->getId() != $wgUser->getId() ) {
				$usernames[$user->getName()] = $user->getId();
			}
		}

		$this->userIds = array_values( $usernames );

		if ( empty( $usernames ) ) {
			# No one to send mail to
			$wgOut->addWikiMsg( 'emailusers-norecipient' );
			$wgOut->returnToMain();
			return;
		}

		$form = array(
			'target' => array(
				'type' => 'multiselect',
				'label-message' => 'emailto',
				'options' => $usernames,
				'validation-callback' => array( $this, 'validateTarget' ),
			),
			'target-reverse' => array(
				'type' => 'check',
				'default' => true,
				'label-message' => 'emailusers-target-reverse',
			),
			'subject' => array(
				'type' => 'text',
				'default' => wfMsg( 'defemailsubject' ),
				'label-message' => 'emailsubject',
			),
			'text' => array(
				'type' => 'textarea',
				'label-message' => 'emailmessage',
			),
			'ccme' => array(
				'type' => 'check',
				'default' => $wgUser->getOption( 'ccmeonemails' ),
				'label-message' => 'emailccme',
			),
		);

		$htmlForm = new HTMLForm( $form );
		$htmlForm->setTitle( $this->getTitle( $par ) );
		$htmlForm->setSubmitCallback( array( $this, 'submit' ) );

		$this->outputHeader();

		if ( $htmlForm->show() ) {
			$wgOut->addWikiMsg( 'emailsenttext' );
			$htmlForm->displayForm( false );
		}
	}

	function validateTarget( $value, $alldata ) {
		global $wgLang, $wgEmailUsersMaxRecipients;

		if ( $alldata['target-reverse'] ) {
			$recipients = count( $this->userIds ) - count( $value );
		} else {
			$recipients = count( $value );
		}

		if ( $recipients <= 0 ) {
			return wfMsgExt( 'emailusers-norecipientselected', 'parse' );
		} elseif ( $wgEmailUsersMaxRecipients > 0 && $recipients > $wgEmailUsersMaxRecipients ) {
			return wfMsgExt(
				'emailusers-toomanyrecipientsselected', 'parse',
				$wgLang->formatNum( $wgEmailUsersMaxRecipients )
			);
		}

		return true;
	}

	function submit( $data ) {
		global $wgUserEmailUseReplyTo, $wgEmailUsersUseJobQueue, $wgPasswordSender, $wgUser;

		if ( $data['target-reverse'] ) {
			$targets = array_diff( $this->userIds, $data['target'] );
		} else {
			$targets = $data['target'];
		}

		if ( $data['ccme'] ) {
			$targets[] = $wgUser->getId();
		}

		$text = rtrim( $data['text'] ) . "\n\n-- \n";

		$params = array(
			'subj' => $data['subject'],
			'replyto' => new MailAddress( $wgUser ),
		);

		if ( $wgUserEmailUseReplyTo ) {
			$params['from'] = new MailAddress( $wgPasswordSender );
		} else {
			$params['from'] = new MailAddress( $wgUser );
		}

		foreach ( $targets as $userId ) {
			$user = User::newFromId( $userId );

			$params['to'] = new MailAddress( $user );

			# Or use the recipient's language instead of content?
			$params['body'] = $text . wfMsgExt( 'emailuserfooter',
				array( 'content', 'parsemag' ), array( $wgUser->getName(), $user->getName() )
			);

			$job = new EmaillingJob( $this->getTitle(), $params );
			if ( $wgEmailUsersUseJobQueue ) {
				$job->insert();
			} else {
				$job->run();
			}
		}

		return true;
	}
}
