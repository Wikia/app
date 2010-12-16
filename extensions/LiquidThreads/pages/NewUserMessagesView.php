<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class NewUserMessagesView extends LqtView {
	protected $threads;
	protected $tops;
	protected $targets;

	protected function htmlForReadButton( $label, $title, $class, $ids ) {
		$ids_s = implode( ',', $ids );
		$html = '';
		$html .= Xml::hidden( 'lqt_method', 'mark_as_read' );
		$html .= Xml::hidden( 'lqt_operand', $ids_s );
		$html .= Xml::submitButton(
			$label,
			array(
				'name' => 'lqt_read_button',
				'title' => $title,
				'class' => 'lqt-read-button'
			)
		);
		$html = Xml::tags( 'form', array( 'method' => 'post', 'class' => $class ), $html );

		return $html;
	}

	function getReadAllButton( $threads ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$ids =  array_map( create_function( '$t', 'return $t->id();' ), $threads ); // ew
		return $this->htmlForReadButton(
			wfMsg( 'lqt-read-all' ),
			wfMsg( 'lqt-read-all-tooltip' ),
			"lqt_newmessages_read_all_button",
			$ids
		);
	}

	function getUndoButton( $ids ) {
		wfLoadExtensionMessages( 'LiquidThreads' );

		if ( count( $ids ) == 1 ) {
			$t = Threads::withId( $ids[0] );
			if ( !$t )
				return; // empty or just bogus operand.
			$msg = wfMsgExt( 'lqt-marked-read', 'parseinline', array( $t->subject() )  );
		} else {
			$count = count( $ids );
			$msg =  wfMsgExt( 'lqt-count-marked-read', 'parseinline', array( $count ) );
		}
		$operand = implode( ',', $ids );

		$html = '';
		$html .= $msg;
		$html .= Xml::hidden( 'lqt_method', 'mark_as_unread' );
		$html .= Xml::hidden( 'lqt_operand', $operand );
		$html .= Xml::submitButton(
			wfMsg( 'lqt-email-undo' ),
			array(
				'name' => 'lqt_read_button',
				'title' => wfMsg( 'lqt-email-info-undo' )
			)
		);

		$html = Xml::tags(
			'form',
			array( 'method' => 'post', 'class' => 'lqt_undo_mark_as_read' ),
			$html
		);

		return $html;
	}

	function postDivClass( $thread ) {
		$origClass = parent::postDivClass( $thread );

		$topid = $thread->topmostThread()->id();

		if ( isset( $this->targets[$topid] ) && is_array( $this->targets[$topid] ) &&
				in_array( $thread->id(), $this->targets[$topid] ) )
			return "$origClass lqt_post_new_message";

		return $origClass;
	}

	function showOnce() {
		self::addJSandCSS();

		static $scriptDone = false;

		if ( !$scriptDone ) {
			global $wgOut, $wgScriptPath, $wgLiquidThreadsExtensionName;
			$prefix = "{$wgScriptPath}/extensions/{$wgLiquidThreadsExtensionName}";
			$wgOut->addScriptFile( "$prefix/newmessages.js" );
		}

		$this->user->setNewtalk( false );

		if ( $this->methodApplies( 'mark_as_unread' ) ) {
			$ids = explode( ',', $this->request->getVal( 'lqt_operand', '' ) );

			if ( $ids !== false ) {
				foreach ( $ids as $id ) {
					$tmp_thread = Threads::withId( $id );	if ( $tmp_thread )
					NewMessages::markThreadAsUnReadByUser( $tmp_thread, $this->user );
				}
				$this->output->redirect( $this->title->getFullURL() );
			}
		} elseif ( $this->methodApplies( 'mark_as_read' ) ) {
			$ids = explode( ',', $this->request->getVal( 'lqt_operand' ) );
			if ( $ids !== false ) {
				foreach ( $ids as $id ) {
					$tmp_thread = Threads::withId( $id );
					if ( $tmp_thread )
						NewMessages::markThreadAsReadByUser( $tmp_thread, $this->user );
				}
				$query = 'lqt_method=undo_mark_as_read&lqt_operand=' . implode( ',', $ids );
				$this->output->redirect( $this->title->getFullURL( $query ) );
			}
		} elseif ( $this->methodApplies( 'undo_mark_as_read' ) ) {
			$ids = explode( ',', $this->request->getVal( 'lqt_operand', '' ) );
			$this->output->addHTML( $this->getUndoButton( $ids ) );
		}
	}

	function show() {
		if ( ! is_array( $this->threads ) ) {
			throw new MWException( 'You must use NewUserMessagesView::setThreads() before calling NewUserMessagesView::show().' );
		}

		// Do everything by id, because we can't depend on reference identity; a simple Thread::withId
		// can change the cached value and screw up your references.

		$this->targets = array();
		$this->tops = array();
		foreach ( $this->threads as $t ) {
			$top = $t->topmostThread();

			// It seems that in some cases $top is zero.
			if ( !$top )
				throw new MWException( "{$t->id()} seems to have no topmost thread" );

			if ( !array_key_exists( $top->id(), $this->tops ) )
				$this->tops[$top->id()] = $top;
			if ( !array_key_exists( $top->id(), $this->targets ) )
				$this->targets[$top->id()] = array();
			$this->targets[$top->id()][] = $t->id();
		}

		$this->output->addHTML( '<table class="lqt-new-messages"><tbody>' );

		foreach ( $this->tops as $t ) {
			// It turns out that with lqtviews composed of threads from various talkpages,
			// each thread is going to have a different article... this is pretty ugly.
			$this->article = $t->article();

			$this->showWrappedThread( $t );
		}

		$this->output->addHTML( '</tbody></table>' );

		return false;
	}

	function showWrappedThread( $t ) {
		wfLoadExtensionMessages( 'LiquidThreads' );

		$read_button = $this->htmlForReadButton(
			wfMsg( 'lqt-read-message' ),
			wfMsg( 'lqt-read-message-tooltip' ),
			'lqt_newmessages_read_button',
			$this->targets[$t->id()] );

		// Left-hand column read button and context link to the full thread.
		global $wgUser;
		$topmostThread = $t->topmostThread();
		$sk = $wgUser->getSkin();
		$title = clone $topmostThread->article()->getTitle();
		$title->setFragment( '#' . $t->getAnchorName() );

		// Make sure it points to the right page. The Pager seems to use the DB
		//  representation of a timestamp for its offset field, odd.
		$dbr = wfGetDB( DB_SLAVE );
		$offset = wfTimestamp( TS_UNIX, $topmostThread->modified() ) + 1;
		$offset = $dbr->timestamp( $offset );

		$contextLink = $sk->link(
			$title,
			wfMsgExt( 'lqt-newmessages-context', 'parseinline' ),
			array(),
			array( 'offset' => $offset ),
			array( 'known' )
		);

		$talkpageLink = $sk->link( $topmostThread->article()->getTitle() );
		$talkpageInfo = wfMsgExt(
			'lqt-newmessages-from',
			array( 'parse', 'replaceafter' ),
			$talkpageLink
		);

		$leftColumn = Xml::tags( 'p', null, $read_button ) .
						Xml::tags( 'p', null, $contextLink ) .
						$talkpageInfo;
		$leftColumn = Xml::tags( 'td', array( 'class' => 'lqt-newmessages-left' ),
									$leftColumn );
		$html = "<tr>$leftColumn<td class='lqt-newmessages-right'>";
		$this->output->addHTML( $html );

		$mustShowThreads = $this->targets[$t->id()];

		$this->showThread( $t, 1, 1, array( 'mustShowThreads' => $mustShowThreads ) );

		$this->output->addHTML( "</td></tr>" );
	}

	function setThreads( $threads ) {
		$this->threads = $threads;
	}
}
