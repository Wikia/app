<?php

class ThreadHistoryPager extends TablePager {
	static $change_names;

	function __construct( $view, $thread ) {
		parent::__construct();

		$this->thread = $thread;
		$this->view = $view;

		self::$change_names =
		array(
			Threads::CHANGE_EDITED_ROOT => wfMsgNoTrans( 'lqt_hist_comment_edited' ),
			Threads::CHANGE_EDITED_SUMMARY => wfMsgNoTrans( 'lqt_hist_summary_changed' ),
			Threads::CHANGE_REPLY_CREATED => wfMsgNoTrans( 'lqt_hist_reply_created' ),
			Threads::CHANGE_NEW_THREAD => wfMsgNoTrans( 'lqt_hist_thread_created' ),
			Threads::CHANGE_DELETED => wfMsgNoTrans( 'lqt_hist_deleted' ),
			Threads::CHANGE_UNDELETED => wfMsgNoTrans( 'lqt_hist_undeleted' ),
			Threads::CHANGE_MOVED_TALKPAGE => wfMsgNoTrans( 'lqt_hist_moved_talkpage' ),
			Threads::CHANGE_EDITED_SUBJECT => wfMsgNoTrans( 'lqt_hist_edited_subject' ),
			Threads::CHANGE_SPLIT => wfMsgNoTrans( 'lqt_hist_split' ),
			Threads::CHANGE_MERGED_FROM => wfMsgNoTrans( 'lqt_hist_merged_from' ),
			Threads::CHANGE_MERGED_TO => wfMsgNoTrans( 'lqt_hist_merged_to' ),
			Threads::CHANGE_SPLIT_FROM => wfMsgNoTrans( 'lqt_hist_split_from' ),
			Threads::CHANGE_ROOT_BLANKED => wfMsgNoTrans( 'lqt_hist_root_blanked' ),
			Threads::CHANGE_ADJUSTED_SORTKEY => wfMsgNoTrans( 'lqt_hist_adjusted_sortkey' ),
		);
	}

	function getQueryInfo() {
		$queryInfo = array(
			'tables' => array( 'thread_history' ),
			'fields' => '*',
			'conds' => array( 'th_thread' => $this->thread->id() ),
			'options' => array( 'order by' => 'th_timestamp desc' ),
		);

		return $queryInfo;
	}

	function getFieldMessages() {
		$headers = array(
			'th_timestamp' => 'lqt-history-time',
			'th_user_text' => 'lqt-history-user',
			'th_change_type' => 'lqt-history-action',
			'th_change_comment' => 'lqt-history-comment',
			);

		return $headers;
	}

	function getFieldNames() {
		static $headers = null;

		if ( !empty( $headers ) ) {
			return $headers;
		}

		$headers = $this->getFieldMessages();

		$headers = array_map( 'wfMsg', $headers );

		return $headers;
	}

	function formatValue( $name, $value ) {
		global $wgLang, $wgTitle;

		static $linker = null;

		if ( empty( $linker ) ) {
			global $wgUser;
			$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();
		}

		$row = $this->mCurrentRow;

		switch( $name ) {
			case 'th_timestamp':
				$formatted = $wgLang->timeanddate( $value );
				return $linker->link(
					$wgTitle,
					$formatted,
					array(),
					array( 'lqt_oldid' => $row->th_id )
				);
			case 'th_user_text':
				return $linker->userLink(
						$row->th_user,
						$row->th_user_text
					) .
					' ' . $linker->userToolLinks( $row->th_user, $row->th_user_text );
			case 'th_change_type':
				return $this->getActionDescription( $value );
			case 'th_change_comment':
				return $linker->commentBlock( $value );
			default:
				return "Unable to format $name";
				break;
		}
	}

	function getActionDescription( $type ) {
		global $wgOut;

		$args = array();
		$revision = ThreadRevision::loadFromRow( $this->mCurrentRow );
		$changeObject = $revision->getChangeObject();

		if ( $revision && $revision->prev() ) {
			$lastChangeObject = $revision->prev()->getChangeObject();
		}

		if ( $changeObject && $changeObject->title() ) {
			$args[] = $changeObject->title()->getPrefixedText();
		} else {
			$args[] = '';
		}

		$msg = self::$change_names[$type];

		switch( $type ) {
			case Threads::CHANGE_EDITED_SUBJECT:
				if ( $changeObject && $lastChangeObject ) {
					$args[] = $lastChangeObject->subject();
					$args[] = $changeObject->subject();
				} else {
					$msg = wfMsg( 'lqt_hist_edited_subject_corrupt', 'parseinline' );
				}
				break;
			case Threads::CHANGE_EDITED_ROOT:
			case Threads::CHANGE_ROOT_BLANKED:
				$view = $this->view;

				if ( $changeObject && $changeObject->title() ) {
					$diffLink = $view->diffPermalinkURL( $changeObject, $revision );
					$args[] = $diffLink;
				} else {
					$args[] = '';
				}
				break;
		}

		$content = wfMsgReplaceArgs( $msg, $args );
		return $wgOut->parseInline( $content );
	}

	function getIndexField() {
		return 'th_timestamp';
	}

	function getDefaultSort() {
		return 'th_timestamp';
	}

	function isFieldSortable( $name ) {
		$sortable_fields = array( 'th_timestamp', 'th_user_text', 'th_change_type' );
		return in_array( $name, $sortable_fields );
	}

	function getDefaultDirections() { return true; /* descending */ }
}
