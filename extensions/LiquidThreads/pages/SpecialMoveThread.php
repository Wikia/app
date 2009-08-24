<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class SpecialMoveThread extends UnlistedSpecialPage {
	private $user, $output, $request, $title, $thread;

	function __construct() {
		parent::__construct( 'Movethread' );
		$this->includable( false );
	}

	/**
	* @see SpecialPage::getDescription
	*/
	function getDescription() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		return wfMsg( 'lqt_movethread' );
	}

	function handleGet() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$form_action = $this->title->getLocalURL() . '/' . $this->thread->title()->getPrefixedURL();
		$thread_name = $this->thread->title()->getPrefixedText();
		$article_name = $this->thread->article()->getTitle()->getTalkPage()->getPrefixedText();
		$edit_url = LqtView::permalinkUrl( $this->thread, 'edit', $this->thread );
		$wfMsg = 'wfMsg'; // functions can only be called within string expansion by variable name.
		// FIXME: awkward message usage and fixed parameter formatting. Would be nicer if all formatting
		//        was done in the message itself, and the below code would be deweirded.
		$this->output->addHTML( <<<HTML
<p>{$wfMsg('lqt_move_movingthread', "<b>$thread_name</b>", "<b>$article_name</b>")}</p>
<p>{$wfMsg('lqt_move_torename', "<a href=\"$edit_url\">{$wfMsg('lqt_move_torename_edit')}</a>")}</p>
<form id="lqt_move_thread_form" action="$form_action" method="POST">
<table>
<tr>
<td><label for="lqt_move_thread_target_title">{$wfMsg('lqt_move_destinationtitle')}</label></td>
<td><input id="lqt_move_thread_target_title" name="lqt_move_thread_target_title" tabindex="100" size="40" /></td>
</tr><tr>
<td><label for="lqt_move_thread_reason">{$wfMsg('movereason')}</label></td>
<td><input id="lqt_move_thread_reason" name="lqt_move_thread_reason" tabindex="200" size="40" /></td>
</tr><tr>
<td>&nbsp;</td>
<td><input type="submit" value="{$wfMsg('lqt_move_move')}" style="float:right;" tabindex="300" /></td>
</tr>
</table>
</form>
HTML
		);

	}

	function checkUserRights() {
		if ( !$this->user->isAllowed( 'move' ) ) {
			$this->output->showErrorPage( 'movenologin', 'movenologintext' );
			return false;
		}
		if ( $this->user->isBlocked() ) {
			$this->output->blockedPage();
			return false;
		}
		if ( wfReadOnly() ) {
			$this->output->readOnlyPage();
			return false;
		}
		if ( $this->user->pingLimiter( 'move' ) ) {
			$this->output->rateLimited();
			return false;
		}
		/* Am I forgetting anything? */
		return true;
	}

	function redisplayForm( $problem_fields, $message ) {
		$this->output->addHTML( $message );
		$this->handleGet();
	}

	function handlePost() {
		if ( !$this->checkUserRights() ) return;
		wfLoadExtensionMessages( 'LiquidThreads' );

		$tmp = $this->request->getVal( 'lqt_move_thread_target_title' );
		if ( $tmp === "" ) {
			$this->redisplayForm( array( 'lqt_move_thread_target_title' ), wfMsg( 'lqt_move_nodestination' ) );
			return;
		}
		$newtitle = Title::newFromText( $tmp )->getSubjectPage();

		$reason = $this->request->getVal( 'lqt_move_thread_reason', wfMsg( 'lqt_noreason' ) );

		// TODO no status code from this method.
		$this->thread->moveToSubjectPage( $newtitle, $reason, true );

		$this->showSuccessMessage( $newtitle->getTalkPage() );
	}

	function showSuccessMessage( $target_title ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$this->output->addHTML( wfMsg( 'lqt_move_success',
			'<a href="' . $target_title->getFullURL() . '">' . $target_title->getPrefixedText() . '</a>' ) );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgTitle, $wgUser;
		$this->user = $wgUser;
		$this->output = $wgOut;
		$this->request = $wgRequest;
		$this->title = $wgTitle;

		$this->setHeaders();

		if ( $par === null || $par === "" ) {
			wfLoadExtensionMessages( 'LiquidThreads' );
			$this->output->addHTML( wfMsg( 'lqt_threadrequired' ) );
			return;
		}
		// TODO should implement Threads::withTitle(...).
		$thread = Threads::withRoot( new Article( Title::newFromURL( $par ) ) );
		if ( !$thread ) {
			wfLoadExtensionMessages( 'LiquidThreads' );
			$this->output->addHTML( wfMsg( 'lqt_nosuchthread' ) );
			return;
		}

		$this->thread = $thread;

		if ( $this->request->wasPosted() ) {
			$this->handlePost();
		} else {
			$this->handleGet();
		}

	}
}
