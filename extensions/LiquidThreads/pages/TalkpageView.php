<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class TalkpageView extends LqtView {
	/* Added to SkinTemplateTabs hook in TalkpageView::show(). */
	static function customizeTalkpageTabs( $skintemplate, &$content_actions, $view ) {
		// The arguments are passed in by reference.
		unset( $content_actions['edit'] );
		unset( $content_actions['viewsource'] );
		unset( $content_actions['delete'] );

		# Protection against non-SkinTemplate skins
		if ( isset( $content_actions['history'] ) ) {
			$thisTitle = $view->article->getTitle();
			$history_url = $thisTitle->getFullURL( 'lqt_method=talkpage_history' );
			$content_actions['history']['href'] = $history_url;
		}
	}

	static function customizeTalkpageNavigation( $skin, &$links, $view ) {
		$remove = array( 'views/edit', 'views/viewsource', 'actions/delete' );

		foreach ( $remove as $rem ) {
			list( $section, $item ) = explode( '/', $rem, 2 );
			unset( $links[$section][$item] );
		}

		if ( isset( $links['views']['history'] ) ) {
			$title = $view->article->getTitle();
			$history_url = $title->getFullURL( 'lqt_method=talkpage_history' );
			$links['views']['history']['href'] = $history_url;
		}
	}

	function customizeTabs( $skintemplate, &$links ) {
		self::customizeTalkpageTabs( $skintemplate, $links, $this );
	}

	function customizeNavigation( $skintemplate, &$links ) {
		self::customizeTalkpageNavigation( $skintemplate, $links, $this );
	}

	function showHeader() {
		/* Show the contents of the actual talkpage article if it exists. */

		global $wgUser;
		$sk = $wgUser->getSkin();

		$article = new Article( $this->title );

		$oldid = $this->request->getVal( 'oldid', null );

		wfLoadExtensionMessages( 'LiquidThreads' );
		// If $article_text == "", the talkpage was probably just created
		// when the first thread was posted to make the links blue.
		if ( $article->exists() ) {
			$html = '';

			$article->view();

			$actionLinks = array();
			$actionLinks[] = $sk->link(
				$this->title,
				wfMsgExt( 'edit', 'parseinline' ) . "&uarr;",
				array(),
				array( 'action' => 'edit' )
			);
			$actionLinks[] = $sk->link(
				$this->title,
				wfMsgExt( 'history_short', 'parseinline' ) . "&uarr;",
				array(),
				array( 'action' => 'history' )
			);

			if ( $wgUser->isAllowed( 'delete' ) ) {
				$actionLinks[] = $sk->link(
					$this->title,
					wfMsgExt( 'delete', 'parseinline' ) . '&uarr;',
					array(),
					array( 'action' => 'delete' )
				);
			}

			$actions = '';
			foreach ( $actionLinks as $link ) {
				$actions .= Xml::tags( 'li', null, "[$link]" ) . "\n";
			}
			$actions = Xml::tags( 'ul', array( 'class' => 'lqt_header_commands' ), $actions );
			$html .= $actions;

			$html = Xml::tags( 'div', array( 'class' => 'lqt_header_content' ), $html );

			$this->output->addHTML( $html );
		} else {

			$editLink = $sk->link(
				$this->title,
				wfMsgExt( 'lqt_add_header', 'parseinline' ),
				array(),
				array( 'action' => 'edit' )
			);

			$html = Xml::tags( 'p', array( 'class' => 'lqt_header_notice' ), "[$editLink]" );

			$this->output->addHTML( $html );
		}
	}

	function getTOC( $threads ) {
		global $wgLang;

		wfLoadExtensionMessages( 'LiquidThreads' );

		$sk = $this->user->getSkin();

		$html = '';

		$h2_header = Xml::tags( 'h2', null, wfMsgExt( 'lqt_contents_title', 'parseinline' ) );

		// Header row
		$headerRow = '';
		$headers = array( 'lqt_toc_thread_title',
				'lqt_toc_thread_replycount', 'lqt_toc_thread_modified' );
		foreach ( $headers as $msg ) {
			$headerRow .= Xml::tags( 'th', null, wfMsgExt( $msg, 'parseinline' ) );
		}
		$headerRow = Xml::tags( 'tr', null, $headerRow );
		$headerRow = Xml::tags( 'thead', null, $headerRow );

		// Table body
		$rows = array();
		foreach ( $threads as $thread ) {
			if ( $thread->root() && !$thread->root()->getContent() &&
				    !LqtView::threadContainsRepliesWithContent( $thread ) ) {
				continue;
			}

			$row = '';
			$anchor = '#' . $this->anchorName( $thread );
			$subject = Xml::tags( 'a', array( 'href' => $anchor ),
					Threads::stripHTML( $thread->formattedSubject() ) );
			$row .= Xml::tags( 'td', null, $subject );

			$row .= Xml::element( 'td', null, $thread->replyCount() );

			$timestamp = $wgLang->timeanddate( $thread->modified(), true );
			$row .= Xml::element( 'td', null, $timestamp );

			$row = Xml::tags( 'tr', null, $row );
			$rows[] = $row;
		}

		$html .= $headerRow . "\n" . Xml::tags( 'tbody', null, implode( "\n", $rows ) );
		$html = $h2_header . Xml::tags( 'table', array( 'class' => 'lqt_toc' ), $html );

		return $html;
	}

	function getList( $kind, $class, $id, $contents ) {
		$html = '';
		foreach ( $contents as $li ) {
			$html .= Xml::tags( 'li', null, $li );
		}
		$html = Xml::tags( $kind, array( 'class' => $class, 'id' => $id ), $html );

		return $html;
	}

	function getArchiveWidget( ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$url = $this->talkpageUrl( $this->title, 'talkpage_archive' );

		$html = '';
		$html = Xml::tags( 'div', array( 'class' => 'lqt_archive_teaser' ), $html );
		return $html;
	}

	function showTalkpageViewOptions( $article ) {
		wfLoadExtensionMessages( 'LiquidThreads' );

		if ( $article->exists() ) {
			$form_action_url = $this->talkpageUrl( $this->title, 'talkpage_sort_order' );
			$go = wfMsg( 'go' );

			$html = '';

			$html .= Xml::label( wfMsg( 'lqt_sorting_order' ), 'lqt_sort_select' ) . ' ';

			$sortOrderSelect =
				new XmlSelect( 'lqt_order', 'lqt_sort_select', $this->getSortType() );

			$sortOrderSelect->setAttribute( 'class', 'lqt_sort_select' );
			$sortOrderSelect->addOption(
				wfMsg( 'lqt_sort_newest_changes' ),
				LQT_NEWEST_CHANGES
			);
			$sortOrderSelect->addOption(
				wfMsg( 'lqt_sort_newest_threads' ),
				LQT_NEWEST_THREADS
			);
			$sortOrderSelect->addOption(
				wfMsg( 'lqt_sort_oldest_threads' ),
				LQT_OLDEST_THREADS
			);
			$html .= $sortOrderSelect->getHTML();

			$html .= Xml::submitButton( wfMsg( 'go' ), array( 'class' => 'lqt_go_sort' ) );
			$html .= Xml::hidden( 'title', $this->title->getPrefixedText() );


			$html = Xml::tags(
				'form',
				array(
					'action' => $form_action_url,
					'method' => 'get',
					'name' => 'lqt_sort'
				),
				$html
			);
			$html = Xml::tags( 'div', array( 'class' => 'lqt_view_options' ), $html );

			return $html;
		}
	}

	function show() {
		wfLoadExtensionMessages( 'LiquidThreads' );

		$this->output->setPageTitle( $this->title->getPrefixedText() );
		self::addJSandCSS();

		// Expose feed links.
		global $wgFeedClasses, $wgScriptPath, $wgServer;
		$apiParams = array( 'action' => 'feedthreads', 'type' => 'replies|newthreads',
				'talkpage' => $this->title->getPrefixedText() );
		$urlPrefix = wfScript( 'api' ) . '?';
		foreach ( $wgFeedClasses as $format => $class ) {
			$theseParams = $apiParams + array( 'feedformat' => $format );
			$url = $urlPrefix . wfArrayToCGI( $theseParams );
			$this->output->addFeedLink( $format, $url );
		}

		$sk = $this->user->getSkin();

		$article = new Article( $this->title );

		if ( $this->request->getBool( 'lqt_inline' ) ) {
			$this->doInlineEditForm();
			return false;
		}

		// Search!
		if ( $this->request->getCheck( 'lqt_search' ) ) {
			$q = $this->request->getText( 'lqt_search' );
			$q .= ' ondiscussionpage:' . $article->getTitle()->getPrefixedText();

			$params = array(
				'search' => $q,
				'fulltext' => 1,
				'ns' . NS_LQT_THREAD => 1,
			);

			$t = SpecialPage::getTitleFor( 'Search' );
			$url = $t->getLocalURL( wfArrayToCGI( $params ) );

			$this->output->redirect( $url );
		}

		$this->showHeader();

		$html = '';

		// Set up a per-page header for new threads, search box, and sorting stuff.

		$talkpageHeader = '';

		if ( Thread::canUserPost( $this->user, $this->article ) ) {
			$newThreadText = wfMsgExt( 'lqt_new_thread', 'parseinline' );
			$newThreadLink = $sk->link(
				$this->title, $newThreadText,
				array( ),
				array( 'lqt_method' => 'talkpage_new_thread' ),
				array( 'known' )
			);

			$talkpageHeader .= Xml::tags(
				'strong',
				array( 'class' => 'lqt_start_discussion' ),
				$newThreadLink
			);
		}

		$talkpageHeader .= $this->getSearchBox();
		$talkpageHeader .= $this->showTalkpageViewOptions( $article );
		$talkpageHeader = Xml::tags(
			'div',
			array( 'class' => 'lqt-talkpage-header' ),
			$talkpageHeader
		);

		$this->output->addHTML( $talkpageHeader );

		global $wgRequest;
		if ( $this->methodApplies( 'talkpage_new_thread' ) ) {
			$params = array( 'class' => 'lqt-new-thread lqt-edit-form' );
			$this->output->addHTML( Xml::openElement( 'div', $params ) );
			$this->showNewThreadForm( $this->article );
			$this->output->addHTML( Xml::closeElement( 'div' ) );
		} else {
			$this->output->addHTML( Xml::tags( 'div',
				array( 'class' => 'lqt-new-thread lqt-edit-form' ), '' ) );
		}

		$pager = $this->getPager();

		$threads = $this->getPageThreads( $pager );

		if ( count( $threads ) > 0 ) {
			$html .= $this->getTOC( $threads );
		} else {
			$html .= Xml::tags( 'div', array( 'class' => 'lqt-no-threads' ),
					wfMsgExt( 'lqt-no-threads', 'parseinline' ) );
		}

		$html .= $pager->getNavigationBar();

		$this->output->addHTML( $html );

		foreach ( $threads as $t ) {
			$this->showThread( $t );
		}

		$this->output->addHTML( $pager->getNavigationBar() );

		return false;
	}

	function getSearchBox() {
		$html = '';
		$html .= Xml::inputLabel(
			wfMsg( 'lqt-search-label' ),
			'lqt_search',
			'lqt-search-box',
			45
		);

		$html .= ' ' . Xml::submitButton( wfMsg( 'lqt-search-button' ) );
		$html .= Xml::hidden( 'title', $this->title->getPrefixedText() );
		$html = Xml::tags(
			'form',
			array(
				'action' => $this->title->getLocalURL(),
				'method' => 'get'
			),
			$html
		);

		$html = Xml::tags( 'div', array( 'class' => 'lqt-talkpage-search' ), $html );

		return $html;
	}

	function getPager() {

		$sortType = $this->getSortType();
		return new LqtDiscussionPager( $this->article, $sortType );
	}

	function getPageThreads( $pager ) {
		$rows = $pager->getRows();

		return Thread::bulkLoad( $rows );
	}

	function getSortType() {
		// Determine sort order
		if ( $this->request->getCheck( 'lqt_order' ) ) {
			// Sort order is explicitly specified through UI
			$lqt_order = $this->request->getVal( 'lqt_order' );
			switch( $lqt_order ) {
				case 'nc':
					return LQT_NEWEST_CHANGES;
				case 'nt':
					return LQT_NEWEST_THREADS;
				case 'ot':
					return LQT_OLDEST_THREADS;
			}
		}

		// Default
		return LQT_NEWEST_CHANGES;
	}
}

class LqtDiscussionPager extends IndexPager {
	function __construct( $article, $orderType ) {
		$this->article = $article;
		$this->orderType = $orderType;

		parent::__construct();

		$this->mLimit = $this->getPageLimit();
	}

	function getPageLimit() {
		$article = $this->article;

		global $wgRequest;
		$requestedLimit = $wgRequest->getVal( 'limit', null );
		if ( $requestedLimit ) {
			return $requestedLimit;
		}

		if ( $article->exists() ) {
			$pout = $article->getParserOutput();
			$setLimit = $pout->getProperty( 'lqt-page-limit' );
			if ( $setLimit ) return $setLimit;
		}

		global $wgLiquidThreadsDefaultPageLimit;
		return $wgLiquidThreadsDefaultPageLimit;
	}

	function getQueryInfo() {
		$queryInfo = array(
			'tables' => array( 'thread' ),
			'fields' => '*',
			'conds' => array(
				Threads::articleClause( $this->article ),
				Threads::topLevelClause(),
				'thread_type != ' . $this->mDb->addQuotes( Threads::TYPE_DELETED ),
			),
		);

		return $queryInfo;
	}

	// Adapted from getBody().
	function getRows() {
		if ( !$this->mQueryDone ) {
			$this->doQuery();
		}

		# Don't use any extra rows returned by the query
		$numRows = min( $this->mResult->numRows(), $this->mLimit );

		$rows = array();

		if ( $numRows ) {
			if ( $this->mIsBackwards ) {
				for ( $i = $numRows - 1; $i >= 0; $i-- ) {
					$this->mResult->seek( $i );
					$row = $this->mResult->fetchObject();
					$rows[] = $row;
				}
			} else {
				$this->mResult->seek( 0 );
				for ( $i = 0; $i < $numRows; $i++ ) {
					$row = $this->mResult->fetchObject();
					$rows[] = $row;
				}
			}
		}

		return $rows;
	}

	function formatRow( $row ) {
		// No-op, we get the list of rows from getRows()
	}

	function getIndexField() {
		switch( $this->orderType ) {
			case LQT_NEWEST_CHANGES:
				return 'thread_sortkey';
			case LQT_OLDEST_THREADS:
			case LQT_NEWEST_THREADS:
				return 'thread_created';
			default:
				throw new MWException( "Unknown sort order " . $this->orderType );
		}
	}

	function getDefaultDirections() {
		switch( $this->orderType ) {
			case LQT_NEWEST_CHANGES:
			case LQT_NEWEST_THREADS:
				return true; // Descending
			case LQT_OLDEST_THREADS:
				return false; // Ascending
			default:
				throw new MWException( "Unknown sort order " . $this->orderType );
		}
	}

	/**
	 * A navigation bar with images
	 * Stolen from TablePager because it's pretty.
	 */
	function getNavigationBar() {
		global $wgStylePath, $wgContLang;

		if ( method_exists( $this, 'isNavigationBarShown' ) &&
				!$this->isNavigationBarShown() )
			return '';

		$path = "$wgStylePath/common/images";
		$labels = array(
			'first' => 'table_pager_first',
			'prev' => 'table_pager_prev',
			'next' => 'table_pager_next',
			'last' => 'table_pager_last',
		);
		$images = array(
			'first' => $wgContLang->isRTL() ? 'arrow_last_25.png' : 'arrow_first_25.png',
			'prev' =>  $wgContLang->isRTL() ? 'arrow_right_25.png' : 'arrow_left_25.png',
			'next' =>  $wgContLang->isRTL() ? 'arrow_left_25.png' : 'arrow_right_25.png',
			'last' =>  $wgContLang->isRTL() ? 'arrow_first_25.png' : 'arrow_last_25.png',
		);
		$disabledImages = array(
			'first' => $wgContLang->isRTL() ? 'arrow_disabled_last_25.png' : 'arrow_disabled_first_25.png',
			'prev' =>  $wgContLang->isRTL() ? 'arrow_disabled_right_25.png' : 'arrow_disabled_left_25.png',
			'next' =>  $wgContLang->isRTL() ? 'arrow_disabled_left_25.png' : 'arrow_disabled_right_25.png',
			'last' =>  $wgContLang->isRTL() ? 'arrow_disabled_first_25.png' : 'arrow_disabled_last_25.png',
		);

		$linkTexts = array();
		$disabledTexts = array();
		foreach ( $labels as $type => $label ) {
			$msgLabel = wfMsgHtml( $label );
			$linkTexts[$type] = "<img src=\"$path/{$images[$type]}\" alt=\"$msgLabel\"/><br />$msgLabel";
			$disabledTexts[$type] = "<img src=\"$path/{$disabledImages[$type]}\" alt=\"$msgLabel\"/><br />$msgLabel";
		}
		$links = $this->getPagingLinks( $linkTexts, $disabledTexts );

		$navClass = htmlspecialchars( $this->getNavClass() );
		$s = "<table class=\"$navClass\" align=\"center\" cellpadding=\"3\"><tr>\n";
		$cellAttrs = 'valign="top" align="center" width="' . 100 / count( $links ) . '%"';
		foreach ( $labels as $type => $label ) {
			$s .= "<td $cellAttrs>{$links[$type]}</td>\n";
		}
		$s .= "</tr></table>\n";
		return $s;
	}

	function getNavClass() {
		return 'TalkpagePager_nav';
	}
}
