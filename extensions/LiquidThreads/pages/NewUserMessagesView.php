<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class NewUserMessagesView extends LqtView {
	protected $highlightedThreads;
	protected $messagesInfo;

	protected function htmlForReadButton( $label, $title, $class, $ids ) {
		$ids_s = implode( ',', $ids );
		$html = '';
		$html .= Html::hidden( 'lqt_method', 'mark_as_read' );
		$html .= Html::hidden( 'lqt_operand', $ids_s );
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

	function getReadAllButton( ) {
		return $this->htmlForReadButton(
			wfMsg( 'lqt-read-all' ),
			wfMsg( 'lqt-read-all-tooltip' ),
			"lqt_newmessages_read_all_button",
			array('all')
		);
	}

	function getUndoButton( $ids ) {

		if ( count( $ids ) == 1 ) {
			$t = Threads::withId( $ids[0] );
			if ( !$t )
				return; // empty or just bogus operand.
			$msg = wfMsgExt( 'lqt-marked-read', 'parseinline', LqtView::formatSubject( $t->subject() )  );
		} else {
			$count = count( $ids );
			$msg =	wfMsgExt( 'lqt-count-marked-read', 'parseinline', array( $count ) );
		}
		$operand = implode( ',', $ids );

		$html = '';
		$html .= $msg;
		$html .= Html::hidden( 'lqt_method', 'mark_as_unread' );
		$html .= Html::hidden( 'lqt_operand', $operand );
		$html .= ' ' . Xml::submitButton(
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

		if ( in_array( $thread->id(), $this->highlightThreads ) )
			return "$origClass lqt_post_new_message";

		return $origClass;
	}

	function showOnce() {
		NewMessages::recacheMessageCount( $this->user->getId() );

		$this->user->setNewtalk( false );

		if ( $this->methodApplies( 'mark_as_unread' ) ) {
			$ids = explode( ',', $this->request->getVal( 'lqt_operand', '' ) );

			if ( $ids !== false ) {
				foreach ( $ids as $id ) {
					$tmp_thread = Threads::withId( $id );
					if ( $tmp_thread )
						NewMessages::markThreadAsUnReadByUser( $tmp_thread, $this->user );
				}
				$this->output->redirect( $this->title->getLocalURL() );
			}
		} elseif ( $this->methodApplies( 'mark_as_read' ) ) {
			$ids = explode( ',', $this->request->getVal( 'lqt_operand' ) );
			if ( $ids !== false ) {
				foreach ( $ids as $id ) {
					if ( $id == 'all' ) {
						NewMessages::markAllReadByUser( $this->user );
					} else {
						$tmp_thread = Threads::withId( $id );
						if ( $tmp_thread )
							NewMessages::markThreadAsReadByUser( $tmp_thread, $this->user );
					}
				}
				$query = 'lqt_method=undo_mark_as_read&lqt_operand=' . implode( ',', $ids );
				$this->output->redirect( $this->title->getLocalURL( $query ) );
			}
		} elseif ( $this->methodApplies( 'undo_mark_as_read' ) ) {
			$ids = explode( ',', $this->request->getVal( 'lqt_operand', '' ) );
			$this->output->addHTML( $this->getUndoButton( $ids ) );
		}
	}

	function show() {
		$pager = new LqtNewMessagesPager( $this->user );
		$this->messagesInfo = $pager->getThreads();
		
		if ( ! $this->messagesInfo ) {
			$this->output->addWikiMsg( 'lqt-no-new-messages' );
			return false;
		}
		
		$this->output->addHTML( $this->getReadAllButton() );
		$this->output->addHTML( $pager->getNavigationBar() );

		$this->output->addHTML( '<table class="lqt-new-messages"><tbody>' );

		foreach ( $this->messagesInfo as $info ) {
			// It turns out that with lqtviews composed of threads from various talkpages,
			// each thread is going to have a different article... this is pretty ugly.
			$thread = $info['top'];
			$this->highlightThreads = $info['posts'];
			$this->article = $thread->article();

			$this->showWrappedThread( $thread );
		}

		$this->output->addHTML( '</tbody></table>' );
		
		$this->output->addHTML( $pager->getNavigationBar() );

		return false;
	}

	function showWrappedThread( $t ) {
		$read_button = $this->htmlForReadButton(
			wfMsg( 'lqt-read-message' ),
			wfMsg( 'lqt-read-message-tooltip' ),
			'lqt_newmessages_read_button',
			$this->highlightThreads );

		// Left-hand column read button and context link to the full thread.
		$topmostThread = $t->topmostThread();
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();
		$title = clone $topmostThread->getTitle();
		$title->setFragment( '#' . $t->getAnchorName() );

		// Make sure it points to the right page. The Pager seems to use the DB
		//	representation of a timestamp for its offset field, odd.
		$dbr = wfGetDB( DB_SLAVE );
		$offset = wfTimestamp( TS_UNIX, $topmostThread->modified() ) + 1;
		$offset = $dbr->timestamp( $offset );

		$contextLink = $linker->link(
			$title,
			wfMsgExt( 'lqt-newmessages-context', 'parseinline' ),
			array(),
			array( 'offset' => $offset ),
			array( 'known' )
		);

		$talkpageLink = $linker->link( $topmostThread->getTitle() );
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

		$mustShowThreads = $this->highlightThreads;

		$this->showThread( $t, 1, 1, array( 'mustShowThreads' => $mustShowThreads ) );
		$this->output->addModules( 'ext.liquidThreads.newMessages' );
		$this->output->addHTML( "</td></tr>" );
	}
}

class LqtNewMessagesPager extends LqtDiscussionPager {
	private $user;
	
	function __construct( $user ) {
		$this->user = $user;
		
		parent::__construct( false, false );
	}
	
	/**
	 * Returns an array of structures. Each structure has the keys 'top' and 'posts'.
	 * 'top' contains the top-level thread to display.
	 * 'posts' contains an array of integer post IDs which should be highlighted.
	 */
	function getThreads() {
		$rows = $this->getRows();
		
		if ( ! count($rows) ) {
			return false;
		}
		
		$threads = Thread::bulkLoad( $rows );
		$thread_ids = array_keys( $threads );
		$output = array();
		
		foreach( $threads as $id => $thread ) {
			$output[$id] = array( 'top' => $thread, 'posts' => array() );
		}
		
		$dbr = wfGetDB( DB_SLAVE );
		
		$res = $dbr->select( array( 'user_message_state' ),
					array( 'ums_thread', 'ums_conversation' ),
					array(
						'ums_user' => $this->user->getId(),
						'ums_conversation' => $thread_ids
					),
					__METHOD__
					);
					
		foreach( $res as $row ) {
			$top = $row->ums_conversation;
			$thread = $row->ums_thread;
			$output[$top]['posts'][] = $thread;
		}
		
		return $output;
	}
	
	function getQueryInfo() {
		$dbr = wfGetDB( DB_SLAVE );

		$queryInfo = array(
			'tables' => array( 'thread', 'user_message_state' ),
			'fields' => array( $dbr->tableName( 'thread' ) . '.*', 'ums_conversation' ),
			'conds' => array(
				'ums_user' => $this->user->getId(),
				'thread_type != ' . $this->mDb->addQuotes( Threads::TYPE_DELETED ),
			),
			'join_conds' => array(
				'thread' => array( 'join', 'ums_conversation=thread_id' )
			),
			'options' => array(
				'group by' => 'ums_conversation'
			)
		);

		return $queryInfo;
	}
	
	function getPageLimit() {
		return 25;
	}
	
	function getDefaultDirections() {
		return true; // Descending
	}
	
	function getIndexField() {
		return array('ums_conversation');
	}
}
