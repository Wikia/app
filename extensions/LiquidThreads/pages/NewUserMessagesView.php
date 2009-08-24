<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class NewUserMessagesView extends LqtView {

	protected $threads;
	protected $tops;
	protected $targets;

	protected function htmlForReadButton( $label, $title, $class, $ids ) {
		$ids_s = implode( ',', $ids );
		return <<<HTML
		<form method="POST" class="{$class}">
		<input type="hidden" name="lqt_method" value="mark_as_read" />
		<input type="hidden" name="lqt_operand" value="{$ids_s}" />
		<input type="submit" value="{$label}" name="lqt_read_button" title="{$title}" />
		</form>
HTML;
	}

	function showReadAllButton( $threads ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$ids =  array_map( create_function( '$t', 'return $t->id();' ), $threads );
		$this->output->addHTML(
			$this->htmlForReadButton(
				wfMsg( 'lqt-read-all' ),
				wfMsg( 'lqt-read-all-tooltip' ),
				"lqt_newmessages_read_all_button",
				$ids )
		);
	}

	function preShowThread( $t ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		//		$t_ids = implode(',', array_map(create_function('$t', 'return $t->id();'), $this->targets[$t->id()]));
		$read_button = $this->htmlForReadButton(
			wfMsg( 'lqt-read-message' ),
			wfMsg( 'lqt-read-message-tooltip' ),
			'lqt_newmessages_read_button',
			$this->targets[$t->id()] );
		$this->output->addHTML( <<<HTML
<table ><tr>
<td style="padding-right: 1em; vertical-align: top; padding-top: 1em;" >
$read_button
</td>
<td>
HTML
		);
	}

	function postShowThread( $t ) {
		$this->output->addHTML( <<<HTML
</td>
</tr></table>
HTML
		);
	}

	function showUndo( $ids ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		if ( count( $ids ) == 1 ) {
			$t = Threads::withId( $ids[0] );
			if ( !$t )
				return; // empty or just bogus operand.
			$msg = wfMsg( 'lqt-marked-read', $t->subject()  );
		} else {
			$count = count( $ids );
			$msg =  wfMsg( 'lqt-count-marked-read', $count );
		}
		$operand = implode( ',', $ids );
		$lqt_email_undo = wfMsg ( 'lqt-email-undo' );
		$lqt_info_undo = wfMsg ( 'lqt-email-info-undo' );
		$this->output->addHTML( <<<HTML
<form method="POST" class="lqt_undo_mark_as_read">
$msg
<input type="hidden" name="lqt_method" value="mark_as_unread" />
<input type="hidden" name="lqt_operand" value="{$operand}" />
<input type="submit" value="{$lqt_email_undo}" name="lqt_read_button" title="{$lqt_info_undo}" />
</form>
HTML
		);
	}

	function postDivClass( $thread ) {
		$topid = $thread->topmostThread()->id();
		if ( in_array( $thread->id(), $this->targets[$topid] ) )
			return 'lqt_post_new_message';
		else
			return 'lqt_post';
	}

	function showOnce() {
		self::addJSandCSS();

		if ( $this->request->wasPosted() ) {
			// If they just viewed this page, maybe they still want that notice.
			// But if they took the time to dismiss even one message, they
			// probably don't anymore.
			$this->user->setNewtalk( false );
		}

		if ( $this->request->wasPosted() && $this->methodApplies( 'mark_as_unread' ) ) {
			$ids = explode( ',', $this->request->getVal( 'lqt_operand', '' ) );
			if ( $ids !== false ) {
				foreach ( $ids as $id ) {
					$tmp_thread = Threads::withId( $id );	if ( $tmp_thread )
						NewMessages::markThreadAsReadByUser( $tmp_thread, $this->user );
				}
				$this->output->redirect( $this->title->getFullURL() );
			}
		}

		else if ( $this->request->wasPosted() && $this->methodApplies( 'mark_as_read' ) ) {
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
		}

		else if ( $this->methodApplies( 'undo_mark_as_read' ) ) {
			$ids = explode( ',', $this->request->getVal( 'lqt_operand', '' ) );
			$this->showUndo( $ids );
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
			if (!$top)
				continue;

			if ( !array_key_exists( $top->id(), $this->tops ) )
				$this->tops[$top->id()] = $top;
			if ( !array_key_exists( $top->id(), $this->targets ) )
				$this->targets[$top->id()] = array();
			$this->targets[$top->id()][] = $t->id();
		}

		foreach ( $this->tops as $t ) {
			// It turns out that with lqtviews composed of threads from various talkpages,
			// each thread is going to have a different article... this is pretty ugly.
			$this->article = $t->article();

			$this->preShowThread( $t );
			$this->showThread( $t );
			$this->postShowThread( $t );
		}
		return false;
	}

	function setThreads( $threads ) {
		$this->threads = $threads;
	}
}
