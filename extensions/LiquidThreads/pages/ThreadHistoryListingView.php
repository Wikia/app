<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class ThreadHistoryListingView extends ThreadPermalinkView {

	private function rowForThread( $t ) {
		global $wgLang, $wgOut; // TODO global.
		wfLoadExtensionMessages( 'LiquidThreads' );
		/* TODO: best not to refer to LqtView class directly. */
		/* We don't use oldid because that has side-effects. */
		$result = array();
		$change_names = array(	Threads::CHANGE_EDITED_ROOT => wfMsg( 'lqt_hist_comment_edited' ),
		Threads::CHANGE_EDITED_SUMMARY => wfMsg( 'lqt_hist_summary_changed' ),
		Threads::CHANGE_REPLY_CREATED => wfMsg( 'lqt_hist_reply_created' ),
		Threads::CHANGE_NEW_THREAD => wfMsg( 'lqt_hist_thread_created' ),
		Threads::CHANGE_DELETED => wfMsg( 'lqt_hist_deleted' ),
		Threads::CHANGE_UNDELETED => wfMsg( 'lqt_hist_undeleted' ),
		Threads::CHANGE_MOVED_TALKPAGE => wfMsg( 'lqt_hist_moved_talkpage' ) );
		$change_label = array_key_exists( $t->changeType(), $change_names ) ? $change_names[$t->changeType()] : "";

		$url = LqtView::permalinkUrlWithQuery( $this->thread, 'lqt_oldid=' . $t->revisionNumber() );

		$user_id = $t->changeUser()->getID(); # ever heard of a User object?
		$user_text = $t->changeUser()->getName();
		$sig = $this->user->getSkin()->userLink( $user_id, $user_text ) .
		$this->user->getSkin()->userToolLinks( $user_id, $user_text );

		$change_comment = $t->changeComment();
		if ( !empty( $change_comment ) )
		$change_comment = "<em>($change_comment)</em>";

		$result[] = "<tr>";
		$result[] = "<td><a href=\"$url\">" . $wgLang->timeanddate( $t->modified() ) . "</a></td>";
		$result[] = "<td>" . $sig . "</td>";
		$result[] = "<td>$change_label</td>";
		$result[] = "<td>$change_comment</td>";
		$result[] = "</tr>";
		return implode( '', $result );
	}

	function showHistoryListing( $t ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$revisions = new ThreadHistoryIterator( $t, $this->perPage, $this->perPage * ( $this->page - 1 ) );

		$this->output->addHTML( '<table>' );
		foreach ( $revisions as $ht ) {
			$this->output->addHTML( $this->rowForThread( $ht ) );
		}
		$this->output->addHTML( '</table>' );

		if ( count( $revisions ) == 0 && $this->page == 1 ) {
			$this->output->addHTML( '<p>' . wfMsg( 'lqt_hist_no_revisions_error' ) );
		}
		else if ( count( $revisions ) == 0 ) {
			// we could redirect to the previous page... yow.
			$this->output->addHTML( '<p>' . wfMsg( 'lqt_hist_past_last_page_error' ) );
		}

		if ( $this->page > 1 ) {
			$this->output->addHTML( '<a class="lqt_newer_older" href="' . $this->queryReplace( array( 'lqt_hist_page' => $this->page - 1 ) ) . '">' . wfMsg( 'lqt_newer' ) . '</a>' );
		} else {
			$this->output->addHTML( '<span class="lqt_newer_older_disabled" title="' . wfMsg( 'lqt_hist_tooltip_newer_disabled' ) . '">' . wfMsg( 'lqt_newer' ) . '</span>' );
		}

		$is_last_page = false;
		foreach ( $revisions as $r )
		if ( $r->changeType() == Threads::CHANGE_NEW_THREAD )
		$is_last_page = true;
		if ( $is_last_page ) {
			$this->output->addHTML( '<span class="lqt_newer_older_disabled" title="' . wfMsg( 'lqt_hist_tooltip_older_disabled' ) . '">' . wfMsg( 'lqt_older' ) . '</span>' );
		} else {
			$this->output->addHTML( '<a class="lqt_newer_older" href="' . $this->queryReplace( array( 'lqt_hist_page' => $this->page + 1 ) ) . '">' . wfMsg( 'lqt_older' ) . '</a>' );
		}
	}

	function __construct( &$output, &$article, &$title, &$user, &$request ) {
		parent::__construct( $output, $article, $title, $user, $request );
		$this->loadParametersFromRequest();
	}

	function loadParametersFromRequest() {
		$this->perPage = $this->request->getInt( 'lqt_hist_per_page', 10 );
		$this->page = $this->request->getInt( 'lqt_hist_page', 1 );
	}

	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array( $this, 'customizeTabs' );

		if ( ! $this->thread ) {
			$this->showMissingThreadPage();
			return false;
		}
		self::addJSandCSS();
		wfLoadExtensionMessages( 'LiquidThreads' );

		$this->output->setSubtitle( $this->getSubtitle() . '<br />' . wfMsg( 'lqt_hist_listing_subtitle' ) );

		$this->showThreadHeading( $this->thread );
		$this->showHistoryListing( $this->thread );

		$this->showThread( $this->thread );

		return false;
	}
}
