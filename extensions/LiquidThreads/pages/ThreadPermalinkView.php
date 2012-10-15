<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class ThreadPermalinkView extends LqtView {
	protected $thread;

	function customizeTabs( $skin, &$links ) {
		self::customizeThreadTabs( $skin, $links, $this );
	}

	function customizeNavigation( $skin, &$links ) {
		self::customizeThreadNavigation( $skin, $links, $this );
	}

	static function customizeThreadTabs( $skintemplate, &$content_actions, $view ) {
		if ( !$view->thread ) {
			return true;
		}

		// Insert 'article' and 'discussion' tabs before the thread tab.

		$tabs = self::getCustomTabs( $view );
		$content_actions = $tabs + $content_actions;

		unset( $content_actions['edit'] );
		unset( $content_actions['viewsource'] );
		unset( $content_actions['talk'] );

		if ( ! $view->thread->title() ) {
			throw new MWException( "Thread ".$view->thread->id()." has null title" );
		}

		$subpage = $view->thread->title()->getPrefixedText();

		// Repoint move/delete/history tabs
		if ( array_key_exists( 'move', $content_actions ) && $view->thread ) {
			$content_actions['move']['href'] =
				SpecialPage::getTitleFor( 'MoveThread', $subpage )->getLocalURL();
		}

		if ( array_key_exists( 'delete', $content_actions ) && $view->thread ) {
			$content_actions['delete']['href'] =
				$view->thread->title()->getLocalURL( 'action=delete' );
		}

		if ( array_key_exists( 'history', $content_actions ) ) {
			$content_actions['history']['href'] = self::permalinkUrl( $view->thread, 'thread_history' );
			if ( $view->methodApplies( 'thread_history' ) ) {
				$content_actions['history']['class'] = 'selected';
			}
		}

		return true;
	}

	static function customizeThreadNavigation( $skin, &$links, $view ) {
		$tempTitle = Title::makeTitle( NS_LQT_THREAD, 'A' );
		$talkKey = $tempTitle->getNamespaceKey( '' ) . '_talk';

		if ( !$view->thread ) {
			unset( $links['views']['edit'] );
			unset( $links['views']['history'] );

			$links['actions'] = array();

			unset( $links['namespaces'][$talkKey] );
			return true;
		}

		// Insert 'article' and 'discussion' namespace-tabs
		$new_nstabs = self::getCustomTabs( $view );

		$nstabs =& $links['namespaces'];

		unset( $nstabs[$talkKey] );
		$nstabs = $new_nstabs + $nstabs;

		// Remove some views.
		$views =& $links['views'];
		unset( $views['viewsource'] );
		unset( $views['edit'] );

		// Re-point move, delete and history actions
		$subpage = $view->thread->title()->getPrefixedText();
		$actions =& $links['actions'];
		if ( isset( $actions['move'] ) ) {
			$actions['move']['href'] =
			SpecialPage::getTitleFor( 'MoveThread', $subpage )->getLocalURL();
		}

		if ( isset( $actions['delete'] ) ) {
			$actions['delete']['href'] =
				$view->thread->title()->getLocalURL( 'action=delete' );
		}

		if ( isset( $views['history'] ) ) {
			$views['history']['href'] =
				self::permalinkUrl( $view->thread, 'thread_history' );
			if ( $view->methodApplies( 'thread_history' ) ) {
				$views['history']['class'] = 'selected';
			}
		}
	}

	// Pre-generates the tabs to be included, for customizeTabs and customizeNavigation
	//  to insert in the appropriate place
	static function getCustomTabs( $view ) {
		$tabs = array();

		$articleTitle = $view->thread->getTitle()->getSubjectPage();
		$talkTitle = $view->thread->getTitle()->getTalkPage();

		$articleClasses = array();
		if ( !$articleTitle->exists() ) $articleClasses[] = 'new';
		if ( $articleTitle->equals( $view->thread->getTitle() ) )
			$articleClasses[] = 'selected';

		$talkClasses = array();
		if ( !$talkTitle->exists() ) $talkClasses[] = 'new';

		$tabs['article'] =
			array(
				'text' => wfMsg( $articleTitle->getNamespaceKey() ),
				'href' => $articleTitle->getLocalURL(),
				'class' => implode( ' ', $articleClasses ),
			);

		$tabs['lqt_talk'] =
			array(
				// talkpage certainly exists since this thread is from it.
				'text' => wfMsg( 'talk' ),
				'href' => $talkTitle->getLocalURL(),
				'class' => implode( ' ', $talkClasses ),
			);

		return $tabs;
	}

	function showThreadHeading( $thread ) {
		parent::showThreadHeading( $thread );
	}

	function noSuchRevision() {
		$this->output->addWikiMsg( 'lqt_nosuchrevision' );
	}

	function showMissingThreadPage() {
		$this->output->setPageTitle( wfMsg( 'lqt_nosuchthread_title' ) );
		$this->output->addWikiMsg( 'lqt_nosuchthread' );
	}

	function getSubtitle() {
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();
		$fragment = '#' . $this->anchorName( $this->thread );

		//if ( $this->thread->isHistorical() ) {
			// TODO: Point to the relevant part of the archive.
		//	$query = '';
		//} else {
		//	$query = '';
		//}

		$talkpage = $this->thread->getTitle();
		$talkpage->setFragment( $fragment );
		$talkpage_link = $linker->link( $talkpage );

		if ( $this->thread->hasSuperthread() ) {
			$topmostTitle = $this->thread->topmostThread()->title();
			$topmostTitle->setFragment( $fragment );

			$linkText = wfMsgExt( 'lqt_discussion_link', 'parseinline' );
			$permalink = $linker->link( $topmostTitle, $linkText );

			return wfMsgExt(
				'lqt_fragment',
				array( 'parseinline', 'replaceafter' ),
				array( $permalink, $talkpage_link )
			);
		} else {
			return wfMsgExt(
				'lqt_from_talk',
				array( 'parseinline', 'replaceafter' ),
				array( $talkpage_link )
			);
		}
	}

	function __construct( &$output, &$article, &$title, &$user, &$request ) {
		parent::__construct( $output, $article, $title, $user, $request );

		$t = Threads::withRoot( $this->article );

		$this->thread = $t;
		if ( !$t ) {
			return;
		}

		// $this->article gets saved to thread_article, so we want it to point to the
		// subject page associated with the talkpage, always, not the permalink url.
		$this->article = $t->article(); # for creating reply threads.
	}

	function show() {
		if ( !$this->thread ) {
			$this->showMissingThreadPage();
			return false;
		}

		if ( $this->request->getBool( 'lqt_inline' ) ) {
			$this->doInlineEditForm();
			return false;
		}

		// Handle action=edit stuff
		if ( $this->request->getVal( 'action' ) == 'edit' &&
				!$this->request->getVal( 'lqt_method', null ) ) {
			// Rewrite to lqt_method = edit
			$this->request->setVal( 'lqt_method', 'edit' );
			$this->request->setVal( 'lqt_operand', $this->thread->id() );
		}

		// Expose feed links.
		global $wgFeedClasses;
		$thread = $this->thread->topmostThread()->title()->getPrefixedText();
		$apiParams = array(
			'action' => 'feedthreads',
			'type' => 'replies|newthreads',
			'thread' => $thread
		);
		$urlPrefix = wfScript( 'api' ) . '?';
		foreach ( $wgFeedClasses as $format => $class ) {
			$theseParams = $apiParams + array( 'feedformat' => $format );
			$url = $urlPrefix . wfArrayToCGI( $theseParams );
			$this->output->addFeedLink( $format, $url );
		}

		$this->output->setSubtitle( $this->getSubtitle() );

		if ( $this->methodApplies( 'summarize' ) )
			$this->showSummarizeForm( $this->thread );
		elseif ( $this->methodApplies( 'split' ) )
			$this->showSplitForm( $this->thread );

		$this->showThread( $this->thread, 1, 1, array( 'maxDepth' => - 1, 'maxCount' => - 1 ) );

		$this->output->setPageTitle( $this->thread->subject() );
		return false;
	}
}
