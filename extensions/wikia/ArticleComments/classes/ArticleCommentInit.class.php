<?php
class ArticleCommentInit {
	public static $enable = null;
	public static $commentByAnonMsg = null;

	static public function ArticleCommentCheck( $title = null ) {
		global $wgRequest, $wgUser;

		if ( $title === null ) {
			global $wgTitle;
			$title = $wgTitle;
		}

		if ( is_null( self::$enable ) && !empty( $title ) ) {
			self::$enable = self::ArticleCommentCheckTitle( $title );

			if ( self::$enable && !is_null( $wgRequest->getVal( 'diff' ) ) ) {
				self::$enable = false;
			}

			$action = $wgRequest->getVal( 'action', 'view' );
			if ( self::$enable && $action == 'purge' && $wgUser->isAnon() && !$wgRequest->wasPosted() ) {
				self::$enable = false;
			}

			if ( self::$enable && $action != 'view' && $action != 'purge' ) {
				self::$enable = false;
			}

			if ( self::$enable && !Hooks::run( 'ArticleCommentCheck', [ $title ] ) ) {
				self::$enable = false;
			}
		}

		return self::$enable;
	}

	/**
	 * Check whether comments should be enabled for given title
	 * @param Title $title
	 * @return bool
	 */
	static public function ArticleCommentCheckTitle( Title $title ) {
		// enable comments only on content namespaces (use $wgArticleCommentsNamespaces if defined)
		if ( !self::ArticleCommentCheckNamespace( $title ) ) {
			return false;
		}

		// non-existing articles
		if ( !$title->exists() ) {
			return false;
		}

		// disable on main page (RT#33703)
		if ( Title::newMainPage()->getText() == $title->getText() ) {
			return false;
		}

		// disable on pages that cant be read (RT#49525)
		if ( !$title->userCan( 'read' ) ) {
			return false;
		}

		// blog listing? (eg: User:Name instead of User:Name/Blog_name) - do not show comments
		if ( ArticleComment::isBlog() && strpos( $title->getText(), '/' ) === false ) {
			return false;
		}
		return true;
	}

	/**
	 * Check whether comments should be enabled for namespace of given title
	 */
	static public function ArticleCommentCheckNamespace( $title ) {
		global $wgContentNamespaces, $wgArticleCommentsNamespaces;

		// enable comments only on content namespaces (use $wgArticleCommentsNamespaces if defined)

		$enable = (
				$title instanceof Title &&
				in_array(
						$title->getNamespace(),
						empty( $wgArticleCommentsNamespaces ) ? $wgContentNamespaces : $wgArticleCommentsNamespaces
				)
		);
		return $enable;
	}

	static public function ArticleCommentEnable( &$data ) {
		global $wgTitle;

		$skin = RequestContext::getMain()->getSkin();

		// use this hook only for skins other than Monaco
		// update: it's actually only MonoBook since Oasis and WikiaMobile use their own
		// logic and the other mobile skins do not show comments-related stuff
		if ( $skin instanceof SkinMonoBook ) {
			if ( self::ArticleCommentCheck() ) {
				$page = ArticleCommentList::newFromTitle( $wgTitle );
				$data = $page->render();
			}
		}

		return true;
	}

	/**
	 * @static
	 * @param OutputPage $out
	 * @param Skin $sk
	 * @return bool
	 */
	static public function ArticleCommentAddJS( OutputPage &$out, Skin &$sk ) {
		global $wgExtensionsPath;

		if ( self::ArticleCommentCheck() ) {
			// FB#21244 this should run only for MonoBook, Oasis and WikiaMobile have their own SASS-based styling
			if ( $sk instanceof SkinMonoBook ) {
				$out->addExtensionStyle( "$wgExtensionsPath/wikia/ArticleComments/css/ArticleComments.css" );
			}
		}

		return true;
	}

	// TODO: not used in oasis - remove
	static public function ArticleCommentHideTab( $skin, &$content_actions ) {
		global $wgArticleCommentsHideDiscussionTab;

		if ( !empty( $wgArticleCommentsHideDiscussionTab ) && self::ArticleCommentCheck() ) {
			unset( $content_actions['talk'] );
		}

		return true;
	}

	/**
	 * Hook
	 *
	 * @param Parser $parser -- instance of Parser class
	 * @param Skin $sk -- instance of Skin class
	 * @param string $toc -- HTML for TOC
	 * @param array $sublevelCount -- last used numbers for each indentation
	 *
	 * @static
	 * @access public
	 * @todo TODO: not working - check
	 *
	 * @return Bool true -- because it's a hook
	 */
	static function InjectTOCitem( $parser, &$toc, &$sublevelCount ) {
		if ( self::ArticleCommentCheck() && !( F::app()->checkSkin( 'wikiamobile' ) ) ) {
			$tocnumber = ++$sublevelCount[1];

			$toc .= Linker::tocLine( 'WikiaArticleComments', wfMsg( 'article-comments-toc-item' ), $tocnumber, 1 );
		}
		return true;
	}

	/**
	 * Hook handler
	 *
	 * @param Title $title
	 * @param User $fakeUser
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static function ArticleCommentNotifyUser( $title, &$fakeUser ) {
		if ( $title->getNamespace() == NS_USER_TALK && ArticleComment::isTitleComment( $title ) ) {
			$parts = ArticleComment::explode( $title->getText() );
			if ( $parts['title'] != '' ) {
				$newUser = User::newFromName( $parts['title'] );
				if ( $newUser instanceof User ) {
					$fakeUser = $newUser;
				}
			}
		}
		return true;
	}

	/**
	 * HAWelcome
	 *
	 * @param Title $title
	 * @param User $fakeUser
	 *
	 * @access public
	 * @author Jakub
	 *
	 * @return boolean
	 */
	static public function HAWelcomeGetPrefixText( &$prefixedText, Title $title ) {

		if ( ArticleComment::isTitleComment( $title ) ) {
			$title = $title->getSubjectPage();
			$prefixedText = $title->getPrefixedText();

			$aPrefix = explode( ARTICLECOMMENT_PREFIX, $prefixedText );
			if ( count( $aPrefix ) > 0 ) {
				$prefixedText = substr_replace( $aPrefix[0] , "" , -1 );
			}
		}
		return true;
	}

	// when comments are enabled on the current namespace make the WikiaMobile skin enriched assets
	// while keeping the response size (assets minification) and the number of external requests low (aggregation)
	static public function onWikiaMobileAssetsPackages( Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages ) {
		if ( self::ArticleCommentCheck() ) {
			$jsExtensionPackages[] = 'articlecomments_init_js_wikiamobile';
		}

		return true;
	}

	/**
	 * formats links in the "File usage" section of file pages
	 * @author Jakub Olek
	 */
	public static function onFilePageImageUsageSingleLink( &$link, &$element ) {
		$ns = $element->page_namespace;

		$title = Title::newFromText( $element->page_title, $ns );

		if ( empty( $title ) ) {
			// sanity check
			return true;
		}

		// format links to comment pages
		if ( $ns == NS_TALK && ArticleComment::isTitleComment( $title ) ) {
			$parentTitle = reset( explode( '/', $element->page_title ) ); // getBaseText returns me parent comment for subcomment

			$link = wfMessage(
				'article-comments-file-page',
				$title->getPrefixedText(),
				self::getUserNameFromRevision( $title ),
				$parentTitle
			)->parse();

		// format links to blog posts
		} else if ( defined( 'NS_BLOG_ARTICLE_TALK' ) && $ns == NS_BLOG_ARTICLE_TALK ) {
			$baseText = $title->getBaseText();
			$titleNames = explode( '/', $baseText );
			$userBlog = Title::newFromText( $titleNames[0], NS_BLOG_ARTICLE );

			$link = wfMessage(
				'article-blog-comments-file-page',
				$title->getPrefixedText(),
				self::getUserNameFromRevision( $title ),
				Title::newFromText( $baseText, NS_BLOG_ARTICLE )->getPrefixedText(),
				$titleNames[1],
				$userBlog->getPrefixedText(),
				$userBlog->getBaseText()
			)->parse();
		}

		return true;
	}

	public static function getUserNameFromRevision( Title $title ) {
		$rev = Revision::newFromId( $title->getLatestRevID() );

		$userName = null;
		if ( !empty( $rev ) ) {
			$user = User::newFromId( $rev->getUser() );

			if ( !empty( $user ) ) {
				$userName = $user->getName();
			} else {
				$userName = self::getCommentByAnonMsg();
			}
		}

		return $userName;
	}

	public static function getCommentByAnonMsg() {
		if ( is_null( self::$commentByAnonMsg ) ) {
			self::$commentByAnonMsg = wfMessage( 'article-comments-anonymous' )->text();
		}

		return self::$commentByAnonMsg;
	}
}
