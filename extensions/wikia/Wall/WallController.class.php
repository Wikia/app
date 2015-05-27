<?php
/**
 * A class which represents a user wall. A Wall is a replacement for the main part of the User_talk page.
 * A Wall consists of "Bricks" which are each a single topic/thread/conversation.
 * In typical use, a Wall will only load a subset of Bricks because there will be a TON of bricks as time goes on.
 */
class WallController extends WallBaseController {
	protected $allowedNamespaces = array();
	protected $sortingType = 'index';
	const WALL_MESSAGE_RELATIVE_TIMESTAMP = 604800; // relative message timestampt for 7 days (improvement 20178)

	public function __construct() {
		global $wgUserProfileNamespaces;
		parent::__construct();
		$this->allowedNamespaces = $wgUserProfileNamespaces;
	}

	public function init() {
		$this->helper = new WallHelper();
	}

	public function messageDeleted() {
		$id = $this->app->wg->Title->getText();

		$wm	= WallMessage::newFromId( $id );

		if ( empty( $wm ) ) {
			$this->response->setVal( 'wallOwner', '' );
			$this->response->setVal( 'wallUrl',  '' );
		} else {

			$user = $wm->getWallOwner();
			$user_displayname = $user->getName();

			$this->response->setVal( 'wallOwner', $user_displayname );
			$this->response->setVal( 'wallUrl', $wm->getArticleTitle()->getFullURL() );

			$this->response->setVal( 'showViewLink', $wm->canViewDeletedMessage( $this->app->wg->User ) );
			$this->response->setVal( 'viewUrl', $this->app->wg->Title->getFullUrl( 'show=1' ) );

			$this->response->setVal( 'returnTo', wfMsg( 'wall-deleted-msg-return-to', $user_displayname ) );

			wfRunHooks( 'WallMessageDeleted', array( &$wm, &$this->response ) );
		}
	}

	/**
	 * @brief Passes $userTalkArchiveContent to the template and renders the template
	 *
	 * @desc Renders old User_talk:[username] page in new place, using Wall_renderOldUserTalkPage.php template
	 *
	 * @author Andrzej 'nAndy' √Ö¬Åukaszewski
	 */
	public function renderOldUserTalkPage() {
		$wallUrl = $this->request->getVal( 'wallUrl' );

		$this->userTalkArchiveContent = $this->getUserTalkContent();

		if ( $this->userTalkArchiveContent === false && !empty( $wallUrl ) ) {
		// the subpages did not exist before
			$this->app->wg->Out->redirect( $wallUrl, 301 );
		}
	}

	/**
	 * @brief Passes $userTalkArchiveContent to the template and renders the template
	 *
	 * @desc Renders old User_talk:[username]/[subpage] page in new place, using Wall_renderOldUserTalkSubpage.php template
	 *
	 * @author Andrzej 'nAndy' √Ö¬Åukaszewski
	 */
	public function renderOldUserTalkSubpage() {
		$subpageName = $this->request->getVal( 'subpage', null );
		$wallUrl = $this->request->getVal( 'wallUrl' );

		$this->content = $this->getUserTalkContent( $subpageName );

		if ( $this->content === false && !empty( $wallUrl ) ) {
		// the subpages did not exist before
			// commented this because it caused fatal error fb#15508 -- so this is a quick fix
			// if( !$this->helper->isGreeting($this->app->wg->Title) ) {
				$this->app->wg->Out->redirect( $wallUrl, 301 );
			// }
		}
	}

	/**
	 * @brief Passes $renderUserTalkArchiveAnchor to the template and renders the template
	 *
	 * @desc Renders an anchor to "User talk archive" page
	 *
	 * @author Andrzej 'nAndy' √Ö¬Åukaszewski
	 */

	public function renderUserTalkArchiveAnchor() {
		$title = $this->request->getVal( 'title' );

		$this->renderUserTalkArchiveAnchor = false;
		$pageTitle = $this->helper->getTitle( NS_USER_TALK );
		if ( !empty( $title ) && $title->getNamespace() == NS_USER_WALL && !empty( $pageTitle ) && $pageTitle->exists() ) {
			$this->renderUserTalkArchiveAnchor = true;
			$this->userTalkArchivePageUrl = ( empty( $title ) ? $this->wg->Title->getFullUrl(): $title->getFullUrl() ) . '/' . $this->helper->getArchiveSubPageText();
		}
	}

	public function loadMore() {
		$this->response->setVal( 'repliesNumber', $this->request->getVal( 'repliesNumber' ) );
	}

	protected function getWallMessage() {
		$comment = $this->request->getVal( 'comment' );
		if ( ( $comment instanceof ArticleComment ) ) {
			$wallMessage = WallMessage::newFromArticleComment( $comment );
		} else {
			$wallMessage = $comment;
		}
		if ( $wallMessage instanceof WallMessage ) {
			$wallMessage->load();
			return $wallMessage;
		}
	}

	public function deleteInfoBox() {
	}


	public function messageRemoved() {
		$this->response->setVal( 'comment', $this->request->getVal( 'comment', false ) );
		$this->response->setVal( 'showundo', $this->request->getVal( 'showundo', false ) );

		$showFrom = $this->request->getVal( 'repliesNumber', 0 ) - $this->request->getVal( 'showRepliesNumber', 0 );
		if ( $showFrom > $this->request->getVal( 'current' ) ) {
			$this->response->setVal( 'hide',  true );
		} else {
			$this->response->setVal( 'hide',  false );
		}

	}

	public function parseText( $text ) {
		return $this->parserText( $text );
	}

	protected function checkAndSetUserBlockedStatus( $wallOwner = null ) {
		$user = $this->app->wg->User;

		if ( $user->isBlocked() || $user->isBlockedGlobally() ) {
			if (	!empty( $wallOwner ) &&
				$wallOwner->getName() == $this->wg->User->getName() &&
				!( empty( $user->mAllowUsertalk ) ) ) {

				// user is blocked, but this is his wall and he was not blocked
				// from user talk page
				$this->response->setVal( 'userBlocked', false );
			} else {
				$this->response->setVal( 'userBlocked', true );
			}
		} else {
			$this->response->setVal( 'userBlocked', false );
		}

	}

	protected function getSortingOptions() {
		$title = $this->request->getVal( 'title', $this->app->wg->Title );

		$output = array();
		$selected = $this->getSortingSelected();

		// $id's are names of DOM elements' classes
		// which are needed to click tracking
		// if you change them here, do so in Wall.js file, please
		foreach ( $this->getSortingOptionsText() as $id => $option ) {
			if ( $this->sortingType === 'history' ) {
				$href = $title->getFullURL( array( 'action' => 'history', 'sort' => $id ) );
			} else {
				$href = $title->getFullURL( array( 'sort' => $id ) );
			}

			if ( $id == $selected ) {
				$output[] = array( 'id' => $id, 'text' => $option, 'href' => $href, 'selected' => true );
			} else {
				$output[] = array( 'id' => $id, 'text' => $option, 'href' => $href );
			}
		}

		return $output;
	}

	protected function getSortingSelected() {
		$selected = $this->wg->request->getVal( 'sort' );

		if ( empty( $selected ) ) {
			$selected = $this->app->wg->User->getOption( 'wall_sort_' . $this->sortingType );
		} else {
			$selectedDB = $this->app->wg->User->getOption( 'wall_sort_' . $this->sortingType );

			if ( $selectedDB != $selected ) {
				$this->app->wg->User->setOption( 'wall_sort_' . $this->sortingType, $selected );
				$this->app->wg->User->saveSettings();
			}
		}

		if ( empty( $selected ) || !array_key_exists( $selected, $this->getSortingOptionsText() ) ) {
			$selected = ( $this->sortingType === 'history' ) ? 'of' : 'nt';
		}

		return $selected;
	}

	protected function getSortingOptionsText() {
		switch( $this->sortingType ) {
			case 'history':
				// keys of sorting array are names of DOM elements' classes
				// which are needed to click tracking
				// if you change those keys here, do so in Wall.js file, please
				$options = array(
					'nf' => wfMsg( 'wall-history-sorting-newest-first' ),
					'of' => wfMsg( 'wall-history-sorting-oldest-first' ),
				);
				break;
			case 'index':
			default:
				$options = array(
					'nt' => wfMsg( 'wall-sorting-newest-threads' ),
					'ot' => wfMsg( 'wall-sorting-oldest-threads' ),
					'nr' => wfMsg( 'wall-sorting-newest-replies' ),
					// 'ma' => wfMsg('wall-sorting-most-active'),
					// 'a' => wfMsg('wall-sorting-archived')
				);
				break;
		}

		return $options;
	}

	protected function getSortingSelectedText() {
		$selected = $this->getSortingSelected();
		$options = $this->getSortingOptionsText();
		return $options[$selected];
	}

	/**
	 * @brief Gets and returns user's talk page's content
	 *
	 * @param string $subpageName a title of user talk subpage
	 *
	 * @return Title
	 *
	 * @author Andrzej 'nAndy' √Ö¬Åukaszewski
	 */
	private function getUserTalkContent( $subpageName = '' ) {
		if ( !empty( $subpageName ) ) {
			$pageTitle = $this->helper->getTitle( NS_USER_TALK, $subpageName );
		} else {
			$pageTitle = $this->helper->getTitle( NS_USER_TALK );
		}
		$article = new Article( $pageTitle );
		$articleId = $article->getId();

		if ( empty( $articleId ) ) {
			return false;
		} else {
			return $this->app->wg->Parser->parse( $article->getContent(), $pageTitle, new ParserOptions( $this->wg->User ) )->getText();
		}
	}
} // end class Wall
