<?php
class LqtDispatch {
	/** static cache of per-page LiquidThreads activation setting */
	static $userLqtOverride = array();
	static $primaryView = null;

	static function talkpageMain( &$output, &$article, &$title, &$user, &$request ) {
		// We are given a talkpage article and title. Fire up a TalkpageView

		if ( $title->getNamespace() == NS_LQT_THREAD + 1 /* talk page */ ) {
			// Threads don't have talk pages; redirect to the thread page.
			$output->redirect( $title->getSubjectPage()->getFullUrl() );
			return false;
		}

		// If we came here from a red-link, redirect to the thread page.
		$redlink = $request->getCheck( 'redlink' ) &&
					$request->getText( 'action' ) == 'edit';
		if ( $redlink ) {
			$output->redirect( $title->getFullURL() );
			return false;
		}

		/**
		 * Certain actions apply to the "header", which is stored in the actual talkpage
		 * in the database. Drop everything and behave like a normal page if those
		 * actions come up, to avoid hacking the various history, editing, etc. code.
		 */
		$action =  $request->getVal( 'action' );
		$header_actions = array( 'history', 'edit', 'submit', 'delete' );
		global $wgRequest;

		$lqt_action = $request->getVal( 'lqt_method' );
		if ( $action == 'edit' && $request->getVal( 'section' ) == 'new' ) {
			// Hijack section=new for "new thread".
			$request->setVal( 'lqt_method', 'talkpage_new_thread' );
			$request->setVal( 'section', '' );

			$viewname = 'TalkpageView';
		} elseif ( !$lqt_action && ( in_array( $action, $header_actions ) ||
				$request->getVal( 'diff', null ) !== null ) ) {
			// Pass through wrapper
			$viewname = 'TalkpageHeaderView';
		} elseif ( $action == 'protect' || $action == 'unprotect' ) {
			// Pass through wrapper
			$viewname = 'ThreadProtectionFormView';
		} elseif ( $lqt_action == 'talkpage_history' ) {
			$viewname = 'TalkpageHistoryView';
		} else {
			$viewname = 'TalkpageView';
		}

		Thread::$titleCacheById[$article->getId()] = $title;

		$view = new $viewname( $output, $article, $title, $user, $request );
		self::$primaryView = $view;
		return $view->show();
	}

	static function threadPermalinkMain( &$output, &$article, &$title, &$user, &$request ) {
		$action =  $request->getVal( 'action' );
		$lqt_method = $request->getVal( 'lqt_method' );

		if ( $lqt_method == 'thread_history' ) {
			$viewname = 'ThreadHistoryListingView';
		} else if ( $lqt_method == 'diff' ) {
			// this clause and the next must be in this order.
			$viewname = 'ThreadDiffView';
		} else if ( $action == 'history'
			|| $request->getVal( 'diff', null ) !== null ) {
			$viewname = 'IndividualThreadHistoryView';
		} else if ( $action == 'protect' || $action == 'unprotect' ) {
			$viewname = 'ThreadProtectionFormView';
		} else if ( $request->getVal( 'lqt_oldid', null ) !== null ) {
			$viewname = 'ThreadHistoricalRevisionView';
		} else if ( $action == 'watch' || $action == 'unwatch' ) {
			$viewname = 'ThreadWatchView';
		} elseif ( $action == 'delete' ) {
			return true;
		} else {
			$viewname = 'ThreadPermalinkView';
		}

		$view = new $viewname( $output, $article, $title, $user, $request );
		self::$primaryView = $view;
		return $view->show();
	}

	static function threadSummaryMain( &$output, &$article, &$title, &$user, &$request ) {
		$viewname = 'SummaryPageView';
		$view = new $viewname( $output, $article, $title, $user, $request );
		self::$primaryView = $view;
		return $view->show();
	}

	static function isLqtPage( $title ) {
		// Ignore it if it's a thread or a summary, makes no sense to have LiquidThreads there.
		if ( $title->getNamespace() == NS_LQT_THREAD ||
				$title->getNamespace() == NS_LQT_SUMMARY ) {
			return false;
		}

		global $wgLqtPages, $wgLqtTalkPages;
		$isTalkPage = ( $title->isTalkPage() && $wgLqtTalkPages ) ||
				in_array( $title->getPrefixedText(), $wgLqtPages );

		if ( $title->exists() ) {
			$override = self::getUserLqtOverride( $title );
		} else {
			$override = null;
		}

		global $wgLiquidThreadsAllowUserControl;
		if ( !is_null( $override ) && $wgLiquidThreadsAllowUserControl ) {
			$isTalkPage = $override;
		}

		$isTalkPage = $isTalkPage && !$title->isRedirect();

		return $isTalkPage;
	}

	static function getUserLqtOverride( $title ) {
		if ( ! is_object( $title ) ) {
			return null;
		}

		$articleid = $title->getArticleId();

		global $wgLiquidThreadsAllowUserControlNamespaces;
		global $wgLiquidThreadsAllowUserControl;

		if ( !$wgLiquidThreadsAllowUserControl ) {
			return null;
		}

		$namespaces = $wgLiquidThreadsAllowUserControlNamespaces;

		if ( !is_null( $namespaces ) && !in_array( $title->getNamespace(), $namespaces ) ) {
			return null;
		}

		// Check instance cache.
		if ( array_key_exists( $articleid, self::$userLqtOverride ) ) {
			$cacheVal = self::$userLqtOverride[$articleid];

			return $cacheVal;
		}

		// Load from the database.
		$dbr = wfGetDB( DB_SLAVE );

		$row = $dbr->selectRow(
			'page_props',
			'pp_value',
			array(
				'pp_propname' => 'use-liquid-threads',
				'pp_page' => $articleid
			),
			__METHOD__
		);

		if ( $row ) {
			$dbVal = $row->pp_value;

			self::$userLqtOverride[$articleid] = $dbVal;
			return $dbVal;
		} else {
			// Negative caching.
			self::$userLqtOverride[$articleid] = null;
			return null;
		}
	}

	/**
	* If the page we recieve is a LiquidThreads page of any kind, process it
	* as needed and return True. If it's a normal, non-liquid page, return false.
	*/
	static function tryPage( $output, $article, $title, $user, $request ) {
		if ( LqtDispatch::isLqtPage( $title ) ) {
			// LiquidThreads pages, Talk:X etc
			return self::talkpageMain( $output, $article, $title, $user, $request );
		} else if ( $title->getNamespace() == NS_LQT_THREAD ) {
			// Thread permalink pages, Thread:X
			return self::threadPermalinkMain( $output, $article, $title, $user, $request );
		} else if ( $title->getNamespace() == NS_LQT_SUMMARY ) {
			// Summary pages, Summary:X
			return self::threadSummaryMain( $output, $article, $title, $user, $request );
		}
		return true;
	}

	static function onSkinTemplateNavigation( $skinTemplate, &$links ) {
		if ( !self::$primaryView ) return true;

		self::$primaryView->customizeNavigation( $skinTemplate, $links );

		return true;
	}

	static function onSkinTemplateTabs( $skinTemplate, &$links ) {
		if ( !self::$primaryView ) return true;

		self::$primaryView->customizeTabs( $skinTemplate, $links );

		return true;
	}
}
