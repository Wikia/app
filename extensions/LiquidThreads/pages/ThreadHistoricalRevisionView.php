<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class ThreadHistoricalRevisionView extends ThreadPermalinkView {

	/* TOOD: customize tabs so that History is highlighted. */

	function postDivClass( $thread ) {
		$is_changed_thread = $thread->changeObject() &&
		$thread->changeObject()->id() == $thread->id();
		if ( $is_changed_thread )
		return 'lqt_post_changed_by_history';
		else
		return 'lqt_post';
	}

	function showHistoryInfo() {
		global $wgLang; // TODO global.
		wfLoadExtensionMessages( 'LiquidThreads' );
		$this->openDiv( 'lqt_history_info' );
		$this->output->addHTML( wfMsg( 'lqt_revision_as_of',
			$wgLang->timeanddate( $this->thread->modified() ),
			$wgLang->date( $this->thread->modified() ),
			$wgLang->time( $this->thread->modified() ) ) . '<br />' );

		$ct = $this->thread->changeType();
		if ( $ct == Threads::CHANGE_NEW_THREAD ) {
			$msg = wfMsg( 'lqt_change_new_thread' );
		} else if ( $ct == Threads::CHANGE_REPLY_CREATED ) {
			$msg = wfMsg( 'lqt_change_reply_created' );
		} else if ( $ct == Threads::CHANGE_EDITED_ROOT ) {
			$diff_url = $this->permalinkUrlWithDiff( $this->thread );
			$msg = wfMsg( 'lqt_change_edited_root' ) . " [<a href=\"$diff_url\">" . wfMsg( 'diff' ) . '</a>]';
		}
		$this->output->addHTML( $msg );
		$this->closeDiv();
	}

	function show() {
		if ( ! $this->thread ) {
			$this->showMissingThreadPage();
			return false;
		}
		$this->showHistoryInfo();
		parent::show();
		return false;
	}
}
