<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class TalkpageView extends LqtView {
	/* Added to SkinTemplateTabs hook in TalkpageView::show(). */
	function customizeTabs( $skintemplate, $content_actions ) {
		// The arguments are passed in by reference.
		unset( $content_actions['edit'] );
		unset( $content_actions['viewsource'] );
		unset( $content_actions['addsection'] );
		unset( $content_actions['history'] );
		unset( $content_actions['watch'] );
		unset( $content_actions['move'] );

		/*
		TODO:
		We could make these tabs actually follow the tab metaphor if we repointed
		the 'history' and 'edit' tabs to the original subject page. That way 'discussion'
		would just be one of four ways to view the article. But then those other tabs, for
		logged-in users, don't really fit the metaphor. What to do, what to do?
		*/
		return true;
	}

	function permalinksForThreads( $ts, $method = null, $operand = null ) {
		$ps = array();
		foreach ( $ts as $t ) {
			$u = $this->permalinkUrl( $t, $method, $operand );
			$l = $t->subjectWithoutIncrement();
			$ps[] = "<a href=\"$u\">$l</a>";
		}
		return $ps;
	}

	function showHeader() {
		/* Show the contents of the actual talkpage article if it exists. */

		$article = new Article( $this->title );
		$revision = Revision::newFromId( $article->getLatest() );
		if ( $revision ) $article_text = $revision->getRawText();

		$oldid = $this->request->getVal( 'oldid', null );
		$editlink = $this->title->getFullURL( 'action=edit' );

		wfLoadExtensionMessages( 'LiquidThreads' );
		// If $article_text == "", the talkpage was probably just created
		// when the first thread was posted to make the links blue.
		if ( $article->exists() && $article_text != "" ) {
			$historylink = $this->title->getFullURL( 'action=history' );
			$this->openDiv( 'lqt_header_content' );
			$this->showPostBody( $article, $oldid );
			$this->outputList( 'ul', 'lqt_header_commands', null, array(
				"[<a href=\"$editlink\">" . wfMsg( 'edit' ) . "&uarr;</a>]",
				"[<a href=\"$historylink\">" . wfMsg( 'history_short' ) . "&uarr;</a>]"
				) );
				$this->closeDiv();
		} else {
			$this->output->addHTML( "<p class=\"lqt_header_notice\">[<a href=\"$editlink\">" . wfMsg( 'lqt_add_header' ) . "</a>]</p>" );
		}
	}

	function outputList( $kind, $class, $id, $contents ) {
		$this->output->addHTML( Xml::openElement( $kind, array( 'class' => $class, 'id' => $id ) ) );
		foreach ( $contents as $li ) {
			$this->output->addHTML( Xml::openElement( 'li' ) );
			$this->output->addHTML( $li );
			$this->output->addHTML( Xml::closeElement( 'li' ) );
		}
		$this->output->addHTML( Xml::closeElement( $kind ) );
	}

	function showTOC( $threads ) {
		wfLoadExtensionMessages( 'LiquidThreads' );

		$sk = $this->user->getSkin();
		$toclines = array();
		$i = 1;
		$toclines[] = $sk->tocIndent();
		foreach ( $threads as $t ) {
			$toclines[] = $sk->tocLine( $this->anchorName( $t ), $t->subjectWithoutIncrement(), $i, 1 );
			$i++;
		}
		$toclines[] = $sk->tocUnindent( 1 );

		$this->openDiv( 'lqt_toc_wrapper' );
		$this->output->addHTML( '<h2 class="lqt_toc_title">' . wfMsg( 'lqt_contents_title' ) . '</h2> <ul>' );

		foreach ( $threads as $t ) {
			$this->output->addHTML( '<li><a href="#' . $this->anchorName( $t ) . '">' . $t->subjectWithoutIncrement() . '</a></li>' );
		}

		$this->output->addHTML( '</ul></div>' );
	}

	function showArchiveWidget( $threads ) {
		wfLoadExtensionMessages( 'LiquidThreads' );

		$threadlinks = $this->permalinksForThreads( $threads );
		$url = $this->talkpageUrl( $this->title, 'talkpage_archive' );

		if ( count( $threadlinks ) > 0 ) {
			$this->openDiv( 'lqt_archive_teaser' );
			$this->output->addHTML( '<h2 class="lqt_recently_archived">' . wfMsg( 'lqt_recently_archived' ) . '</h2>' );
			$this->outputList( 'ul', '', '', $threadlinks );
			$this->closeDiv();
		} else {
		}
	}

	function showTalkpageViewOptions( $article ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		// TODO WTF who wrote this?

		if ( $this->methodApplies( 'talkpage_sort_order' ) ) {
			$remember_sort_checked = $this->request->getBool( 'lqt_remember_sort' ) ? 'checked ' : '';
			$this->user->setOption( 'lqt_sort_order', $this->sort_order );
			$this->user->saveSettings();
		} else {
			$remember_sort_checked = '';
		}

		if ( $article->exists() ) {
			$nc_sort = $this->sort_order == LQT_NEWEST_CHANGES ? ' selected' : '';
			$nt_sort = $this->sort_order == LQT_NEWEST_THREADS ? ' selected' : '';
			$ot_sort = $this->sort_order == LQT_OLDEST_THREADS ? ' selected' : '';
			$newest_changes = wfMsg( 'lqt_sort_newest_changes' );
			$newest_threads = wfMsg( 'lqt_sort_newest_threads' );
			$oldest_threads = wfMsg( 'lqt_sort_oldest_threads' );
			$lqt_remember_sort = wfMsg( 'lqt_remember_sort' ) ;
			$form_action_url = $this->talkpageUrl( $this->title, 'talkpage_sort_order' );
			$lqt_sorting_order = wfMsg( 'lqt_sorting_order' );
			$lqt_sort_newest_changes = wfMsg( 'lqt_sort_newest_changes' );
			$lqt_sort_newest_threads = wfMsg( 'lqt_sort_newest_threads' );
			$lqt_sort_oldest_threads = wfMsg( 'lqt_sort_oldest_threads' );
			$go = wfMsg( 'go' );
			if ( $this->user->isLoggedIn() ) {
				$remember_sort =
				<<<HTML
<br />
<label for="lqt_remember_sort_checkbox">
<input id="lqt_remember_sort_checkbox" name="lqt_remember_sort" type="checkbox" value="1" $remember_sort_checked />
$lqt_remember_sort</label>
HTML;
			} else {
				$remember_sort = '';
			}
			if ( in_array( 'deletedhistory',  $this->user->getRights() ) ) {
				$show_deleted_checked = $this->request->getBool( 'lqt_show_deleted_threads' ) ? 'checked ' : '';
				$show_deleted = "<br />\n" .
								"<label for=\"lqt_show_deleted_threads_checkbox\">\n" .
								"<input id=\"lqt_show_deleted_threads_checkbox\" name=\"lqt_show_deleted_threads\" type=\"checkbox\" value=\"1\" $show_deleted_checked />\n" .
								wfMsg( 'lqt_delete_show_checkbox' ) . "</label>\n";
			} else {
				$show_deleted = "";
			}
			$this->openDiv( 'lqt_view_options' );
			$this->output->addHTML(

			<<<HTML
<form name="lqt_sort" action="$form_action_url" method="post">$lqt_sorting_order
<select name="lqt_order" class="lqt_sort_select">
<option value="nc"$nc_sort>$lqt_sort_newest_changes</option>
<option value="nt"$nt_sort>$lqt_sort_newest_threads</option>
<option value="ot"$ot_sort>$lqt_sort_oldest_threads</option>
</select>
$remember_sort
$show_deleted
<input name="submitsort" type="submit" value="$go" class="lqt_go_sort"/>
</form>
HTML
			);
			$this->closeDiv();
		}

	}

	function show() {
		global $wgHooks;
		wfLoadExtensionMessages( 'LiquidThreads' );
		// Why is a hook added here?
		$wgHooks['SkinTemplateTabs'][] = array( $this, 'customizeTabs' );

		$this->output->setPageTitle( $this->title->getTalkpage()->getPrefixedText() );
		self::addJSandCSS();
		$article = new Article( $this->title ); // Added in r29715 sorting. Why?

		// Removed in r29715 sorting. Again, why?
		$this->showHeader();

		global $wgRequest; // TODO
		if ( $this->methodApplies( 'talkpage_new_thread' ) ) {
			$this->showNewThreadForm();
		} else {
			$this->showTalkpageViewOptions( $article );
			$url = $this->talkpageUrl( $this->title, 'talkpage_new_thread' );
			$this->output->addHTML( "<strong><a class=\"lqt_start_discussion\" href=\"$url\">" . wfMsg( 'lqt_new_thread' ) . "</a></strong>" );
		}

		$threads = $this->queries->query( 'fresh' );

		$this->openDiv( 'lqt_toc_archive_wrapper' );

		$this->openDiv( 'lqt_archive_teaser_empty' );
		$this->output->addHTML( "<div class=\"lqt_browse_archive\"><a href=\"{$this->talkpageUrl($this->title, 'talkpage_archive')}\">" .
			wfMsg( 'lqt_browse_archive_without_recent' ) . "</a></div>" );
		$this->closeDiv();
		$recently_archived_threads = $this->queries->query( 'recently-archived' );
		if ( count( $threads ) > 3 || count( $recently_archived_threads ) > 0 ) {
			$this->showTOC( $threads );
		}
		$this->showArchiveWidget( $recently_archived_threads );
		$this->closeDiv();
		// Clear any floats
		$this->output->addHTML( '<br clear="all" />' );

		foreach ( $threads as $t ) {
			$this->showThread( $t );
		}
		return false;
	}
}
