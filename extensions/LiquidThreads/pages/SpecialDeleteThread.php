<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class SpecialDeleteThread extends UnlistedSpecialPage {
	private $user, $output, $request, $title, $thread;

	function __construct() {
		parent::__construct( 'Deletethread' );
		$this->includable( false );
	}

	/**
	* @see SpecialPage::getDescription
	*/
	function getDescription() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		return wfMsg( 'lqt_deletethread' );
	}

	function handleGet() {
		if ( !$this->checkUserRights() )
			return;
		wfLoadExtensionMessages( 'LiquidThreads' );

		$form_action = $this->title->getLocalURL() . '/' . $this->thread->title()->getPrefixedURL();
		$thread_name = $this->thread->title()->getPrefixedText();
		$article_name = $this->thread->article()->getTitle()->getTalkPage()->getPrefixedText();

		$deleting = $this->thread->type() != Threads::TYPE_DELETED;

		$operation_message = $deleting ?
			wfMsg( 'lqt_delete_deleting', $thread_name )
			: wfMsg( 'lqt_delete_undeleting', $thread_name );
		$button_label = $deleting ?
			wfMsg( 'lqt_delete_deletethread' )
			: wfMsg( 'lqt_delete_undeletethread' );
		$part_of = wfMsg( 'lqt_delete_partof', $article_name );
		$reason = wfMsg( 'movereason' ); // XXX arguably wrong to use movereason.

		$this->output->addHTML( <<<HTML
<p>$operation_message
$part_of</p>
<form id="lqt_delete_thread_form" action="{$form_action}" method="POST">
<table>
<tr>
<td><label for="lqt_delete_thread_reason">$reason</label></td>
<td><input id="lqt_delete_thread_reason" name="lqt_delete_thread_reason" tabindex="200" size="40" /></td>
</tr><tr>
<td>&nbsp;</td>
<td><input type="submit" value="$button_label" style="float:right;" tabindex="300" /></td>
</tr>
</table>
</form>
HTML
		);

	}

	function checkUserRights() {
		if ( in_array( 'delete', $this->user->getRights() ) ) {
			return true;
		} else {
			wfLoadExtensionMessages( 'LiquidThreads' );
			$this->output->addHTML( wfMsg( 'lqt_delete_unallowed' ) );
			return false;
		}
	}

	function redisplayForm( $problem_fields, $message ) {
		$this->output->addHTML( $message );
		$this->handleGet();
	}

	function handlePost() {
		// in theory the model should check rights...
		if ( !$this->checkUserRights() ) return;
		wfLoadExtensionMessages( 'LiquidThreads' );

		$reason = $this->request->getVal( 'lqt_delete_thread_reason', wfMsg( 'lqt_noreason' ) );

		// TODO: in theory, two fast-acting sysops could undo each others' work.
		$is_deleted_already = $this->thread->type() == Threads::TYPE_DELETED;
		if ( $is_deleted_already ) {
			$this->thread->undelete( $reason );
		} else {
			$this->thread->delete( $reason );
		}
		$this->showSuccessMessage( $is_deleted_already );
	}

	function showSuccessMessage( $is_deleted_already ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		// TODO talkpageUrl should accept threads, and look up their talk pages.
		$talkpage_url = LqtView::talkpageUrl( $this->thread->article()->getTitle()->getTalkpage() );
		$message = $is_deleted_already ? wfMsg( 'lqt_delete_undeleted' ) : wfMsg( 'lqt_delete_deleted' );
		$message .= wfMsg( 'word-separator' );
		$message .= wfMsg( 'lqt_delete_return', '<a href="' . $talkpage_url . '">' . wfMsg( 'lqt_delete_return_link' ) . '</a>' );
		$this->output->addHTML( $message );
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
