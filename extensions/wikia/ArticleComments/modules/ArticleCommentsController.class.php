<?php
class ArticleCommentsController extends WikiaController {
	private $dataLoaded = false;

	public function executeIndex() {
		$this->wf->ProfileIn(__METHOD__);
		if (class_exists('ArticleCommentInit') && ArticleCommentInit::ArticleCommentCheck()) {
			$isMobile = $this->app->checkSkin( 'wikiamobile' );

			if ($this->wg->Request->wasPosted()) {
				// for non-JS version !!! (used also for Monobook and WikiaMobile)
				$sComment = $this->wg->Request->getVal( 'wpArticleComment', false );
				$iArticleId = $this->wg->Request->getVal( 'wpArticleId', false );
				$sSubmit = $this->wg->Request->getVal( 'wpArticleSubmit', false );

				if ( $sSubmit && $sComment && $iArticleId ) {
					$oTitle = Title::newFromID( $iArticleId );

					if ( $oTitle instanceof Title ) {
						$response = ArticleComment::doPost( $this->wg->Request->getVal('wpArticleComment') , $this->wg->User, $oTitle );

						if ( !$isMobile ) {
							$this->wg->Out->redirect( $oTitle->getLocalURL() );
						} else {
							$result = array();
							$canComment = ArticleCommentInit::userCanComment( $result, $oTitle );

							//this check should be done for all the skins and before calling ArticleComment::doPost but that requires a good bit of refactoring
							//and some design review as the OAsis/Monobook template doesn't handle error feedback from this code
							if ( $canComment == true ) {
								if ( empty( $response[2]['error'] ) ) {
									//wgOut redirect doesn't work when running fully under the
									//Nirvana stack (WikiaMobile skin), also send back to the first page of comments
									$this->response->redirect( $oTitle->getLocalURL( array( 'page' => 1 ) ) . '#article-comments' );
								} else {
									$this->response->setVal( 'error', $response[2]['msg'] );
								}
							} else {
								$this->response->setVal( 'error', $result['msg'] );
							}
						}
					}
				}
			}

			$this->getCommentsData( $this->wg->Title, $this->wg->request->getInt( 'page', 1 ) );

			if ( $isMobile ) {
				$this->forward( __CLASS__, 'WikiaMobileIndex', false );
			}
		}

		$this->wf->ProfileOut(__METHOD__);
	}

	/**
	 * Overrides the main template for the WikiaMobile skin
	 *
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com?
	 **/
	public function executeWikiaMobileIndex(){
		/** render WikiaMobile template**/

		//unfortunately the only way to get the total number of comments (required in the skin) is to load them
		//via ArticleCommentsList::getData (cached in MemCache for 1h), still to cut down page loading times
		//we won't show them until the user doesn't request for page 1 (hence page == 0 means don't print them out)
		//this is definitely sub optimal but it's the only way until the whole extension doesn't get refactored
		//and the total of comments stored separately
		$this->response->setVal( 'requestedPage', ( $this->wg->request->getVal( 'page', 0 ) ) );
	}

	/**
	 * Overrides the template for one comment item for the WikiaMobile skin
	 *
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com?
	 **/
	public function executeWikiaMobileComment(){/** render WikiaMobile template**/}

	/**
	 * Renders the contents of a page of comments including post button/form and prev/next page
	 * used in the WikiaMobile skin to deliver the first page of comments via AJAX and any page of comments for non-JS browsers
	 *
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com?
	 **/
	public function executeWikiaMobileCommentsPage(){
		$this->wf->profileIn( __METHOD__ );
		$articleID = $this->request->getInt( 'articleID' );
		$title = null;

		if ( !empty( $articleID ) ) {
			$title = Title::newFromId( $articleID );
		}

		if ( !( $title instanceof Title ) ) {
			$title = $this->wg->title;
		}

		$this->getCommentsData( $title, $this->wg->request->getInt( 'page', 1 ) );

		if ( $this->page > 1 ) {
			$this->response->setVal( 'prevPage', $this->page - 1 );
		}

		if ( $this->page <  $this->pagesCount ) {
			$this->response->setVal( 'nextPage', $this->page + 1 );
		}

		$this->wf->profileOut( __METHOD__ );
	}

	private function getCommentsData(Title $title, $page, $perPage = null, $filterid = null) {
		wfProfileIn(__METHOD__);

		$key = implode( '_', array( $title->getArticleID(), $page, $perPage, $filterid ) );
		$data = null;

		// avoid going through all this when calling the method from the same round trip for the same paramenters
		// the real DB stuff is cached by ArticleCommentList in Memcached
		if ( empty( $this->dataLoaded[ $key ] ) ) {
			$commentList = F::build('ArticleCommentList', array(($title)), 'newFromTitle');

			if ( !empty( $perPage ) ) {
				$commentList->setMaxPerPage( $perPage );
			}

			if ( !empty( $filterid ) ) {
				$commentList->setId( $filterid );
			}

			$data = $commentList->getData( $page );

			$this->dataLoaded[$key] = $data;
		} else {
			$data = $this->dataLoaded[$key];
		}

		if ( empty( $data ) ) {
			// Seems like we should always have data, let's leave a log somewhere if this happens
			Wikia::log( __METHOD__, false, 'No data, this should not happen.' );
		}

		// Hm.
		// TODO: don't pass whole instance of Masthead object for author of current comment
		// Did I miss something? It doesn't seem to pass the whole Masthead object anywhere... -- Federico
		$this->avatar = $data['avatar'];

		$this->title = $this->wg->Title;
		$this->ajaxicon = $this->wg->StylePath.'/common/images/ajax.gif';
		$this->canEdit = $data['canEdit'];
		$this->isBlocked = $data['isBlocked'];
		$this->reason = $data['reason'];
		$this->commentListRaw = $data['commentListRaw'];
		$this->isLoggedIn =  $this->wg->User->isLoggedIn();

		$this->isReadOnly = $data['isReadOnly'];
		$this->page = $data['page'];
		$this->pagination = $data['pagination'];

		$this->countComments = $data['countComments'];
		$this->countCommentsNested = $data['countCommentsNested'];
		$this->commentingAllowed = $data['commentingAllowed'];
		$this->commentsPerPage = $data['commentsPerPage'];
		$this->pagesCount = ( $data['commentsPerPage'] > 0 ) ? ceil( $data['countComments'] / $data['commentsPerPage'] ) : 0;

		wfProfileOut(__METHOD__);
	}
	
	public static function onSkinAfterContent( &$afterContentHookText ) {
		global $wgArticleCommentsContent;
		if(!empty($wgArticleCommentsContent)) {
			$afterContentHookText .= $wgArticleCommentsContent;
		}
		return true;
	} 
	
	public static function onBeforePageDisplay(OutputPage &$out, Skin &$skin) {
		global $wgArticleCommentsContent;
		// Display comments on content and blog pages
		if ( class_exists('ArticleCommentInit') && ArticleCommentInit::ArticleCommentCheck() ) {
			$wgArticleCommentsContent = wfRenderModule('ArticleComments');
		}
		return true;	
	}
}
