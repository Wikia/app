<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class TalkpageHistoryView extends TalkpageView {
	function show() {
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();

		$talkpageTitle = $this->article->getTitle();
		$talkpageLink = $linker->link( $talkpageTitle );

		$this->output->setPageTitle( wfMsg( 'lqt-talkpage-history-title' ) );
		$this->output->setSubtitle( wfMsgExt(
			'lqt-talkpage-history-subtitle',
			array( 'replaceafter', 'parseinline' ),
			$talkpageLink
		) );

		$pager = new TalkpageHistoryPager( $this, $this->article );

		$html = $pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar();

		$this->output->addHTML( $html );

		return false;
	}

	function customizeTabs( $skin, &$links ) {
		TalkpageView::customizeTalkpageTabs( $skin, $links, $this );

		$links['history']['class'] = 'selected';
	}

	function customizeNavigation( $skin, &$links ) {
		TalkpageView::customizeTalkpageNavigation( $skin, $links, $this );
		$links['views']['history']['class'] = 'selected';
		$links['views']['view']['class'] = '';
	}
}

class TalkpageHistoryPager extends ThreadHistoryPager {
	function __construct( $view, $talkpage ) {
		$this->talkpage = $talkpage;

		parent::__construct( $view, null );
	}

	function getFieldMessages() {
		$headers = array(
			'th_timestamp' => 'lqt-history-time',
			'thread_subject' => 'lqt-history-thread',
			'th_user_text' => 'lqt-history-user',
			'th_change_type' => 'lqt-history-action',
			'th_change_comment' => 'lqt-history-comment',
			);

		return $headers;
	}

	function getQueryInfo() {
		$queryInfo = array(
			'tables' => array( 'thread_history', 'thread', 'page' ),
			'fields' => '*',
			'conds' => array( Threads::articleClause( $this->talkpage ) ),
			'options' => array( 'order by' => 'th_timestamp desc' ),
			'join_conds' => array(
				'thread' => array( 'LEFT JOIN', 'thread_id=th_thread' ),
				'page' => array( 'LEFT JOIN', 'thread_root=page_id' ),
			),
		);

		return $queryInfo;
	}

	function formatValue( $name, $value ) {
		global $wgLang, $wgContLang;

		static $linker = null;

		if ( empty( $linker ) ) {
			$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();
		}

		$row = $this->mCurrentRow;

		$ns = $row->page_namespace;
		$title = $row->page_title;

		if ( is_null($ns) ) {
			$ns = $row->thread_article_namespace;
			$title = $row->thread_article_title;
		}

		switch( $name ) {
			case 'thread_subject':
				$title = Title::makeTitleSafe(
					$ns,
					$title
				);

				$link = $linker->link(
					$title,
					$value,
					array(),
					array(),
					array( 'known' )
				);

				return Html::rawElement( 'div', array( 'dir' => $wgContLang->getDir() ), $link );
			case 'th_timestamp':
				$formatted = $wgLang->timeanddate( $value );
				$title = Title::makeTitleSafe(
					$ns,
					$title
				);

				return $linker->link(
					$title,
					$formatted,
					array(),
					array( 'lqt_oldid' => $row->th_id )
				);
			default:
				return parent::formatValue( $name, $value );
		}
	}
}
