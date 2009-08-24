<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class ThreadPermalinkView extends LqtView {
	protected $thread;

	function customizeTabs( $skintemplate, $content_actions ) {
		wfLoadExtensionMessages( 'LiquidThreads' );
		// Insert fake 'article' and 'discussion' tabs before the thread tab.
		// If you call the key 'talk', the url gets re-set later. TODO:
		// the access key for the talk tab doesn't work.
		if ($this->thread) {
			$article_t = $this->thread->article()->getTitle();
			$talk_t = $this->thread->article()->getTitle()->getTalkPage();
		}
		efInsertIntoAssoc( 'article', array(
		'text' => wfMsg( $article_t->getNamespaceKey() ),
		'href' => $article_t->getFullURL(),
		'class' => $article_t->exists() ? '' : 'new' ),
		'nstab-thread', $content_actions );
		efInsertIntoAssoc( 'not_talk', array(
		// talkpage certainly exists since this thread is from it.
		'text' => wfMsg( 'talk' ),
		'href' => $talk_t->getFullURL() ),
		'nstab-thread', $content_actions );

		unset( $content_actions['edit'] );
		unset( $content_actions['viewsource'] );
		unset( $content_actions['talk'] );
		if ( array_key_exists( 'move', $content_actions ) && $this->thread ) {
			$content_actions['move']['href'] =
			SpecialPage::getTitleFor( 'MoveThread' )->getFullURL() . '/' .
			$this->thread->title()->getPrefixedURL();
		}
		if ( array_key_exists( 'delete', $content_actions ) && $this->thread ) {
			$content_actions['delete']['href'] =
			SpecialPage::getTitleFor( 'DeleteThread' )->getFullURL() . '/' .
			$this->thread->title()->getPrefixedURL();
		}

		if ( array_key_exists( 'history', $content_actions ) ) {
			$content_actions['history']['href'] = $this->permalinkUrl( $this->thread, 'thread_history' );
			if ( $this->methodApplies( 'thread_history' ) ) {
				$content_actions['history']['class'] = 'selected';
			}
		}

		return true;
	}

	function showThreadHeading( $thread ) {
		if ( $this->headerLevel == 2 ) {
			$this->output->setPageTitle( $thread->wikilink() );
		} else {
			parent::showThreadHeading( $thread );
		}
	}

	function noSuchRevision() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$this->output->addHTML( wfMsg( 'lqt_nosuchrevision' ) );
	}

	function showMissingThreadPage() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$this->output->addHTML( wfMsg( 'lqt_nosuchthread' ) );
	}

	function getSubtitle() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		// TODO the archive month part is obsolete.
		if ( Date::now()->nDaysAgo( 30 )->midnight()->isBefore( new Date( $this->thread->modified() ) ) )
		$query = '';
		else
		$query = 'lqt_archive_month=' . substr( $this->thread->modified(), 0, 6 );
		$talkpage = $this->thread->article()->getTitle()->getTalkpage();
		$talkpage_link = $this->user->getSkin()->makeKnownLinkObj( $talkpage, '', $query );
		if ( $this->thread->hasSuperthread() ) {
			return wfMsg( 'lqt_fragment', "<a href=\"{$this->permalinkUrl($this->thread->topmostThread())}\">" . wfMsg( 'lqt_discussion_link' ) . "</a>", $talkpage_link );
		} else {
			return wfMsg( 'lqt_from_talk', $talkpage_link );
		}
	}

	function __construct( &$output, &$article, &$title, &$user, &$request ) {

		parent::__construct( $output, $article, $title, $user, $request );

		$t = Threads::withRoot( $this->article );
		$r = $this->request->getVal( 'lqt_oldid', null ); if ( $r ) {
			$t = $t->atRevision( $r );
		if ( !$t ) { $this->noSuchRevision(); return; }

		}
		$this->thread = $t;
		if ( !$t ) {
			return; // error reporting is handled in show(). this kinda sucks.
		}

		// $this->article gets saved to thread_article, so we want it to point to the
		// subject page associated with the talkpage, always, not the permalink url.
		$this->article = $t->article(); # for creating reply threads.

	}

	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array( $this, 'customizeTabs' );

		if ( !$this->thread ) {
			$this->showMissingThreadPage();
			return false;
		}

		self::addJSandCSS();
		$this->output->setSubtitle( $this->getSubtitle() );

		if ( $this->methodApplies( 'summarize' ) )
			$this->showSummarizeForm( $this->thread );

		$this->showThread( $this->thread );
		return false;
	}
}
