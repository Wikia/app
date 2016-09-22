<?php

/**
 * Renders comments chicklet button with given value for given title
 *
 * @author Maciej Brencz
 */
class CommentsLikesController extends WikiaController {

	/** @var Title $contextTitle */
	private $contextTitle;

	public function init() {
		$this->commentsAccesskey = null;
		$this->commentsBubble = null;
	}

	/**
	 * Are article comments enabled for context title?
	 */
	private function checkArticleComments() {
		$this->isArticleComments = class_exists( 'ArticleComment' ) && ArticleCommentInit::ArticleCommentCheckTitle( $this->contextTitle );
		return $this->isArticleComments;
	}

	/**
	 * Get URL of the page comments button should be linking to
	 */
	private function getCommentsLink() {
		wfProfileIn( __METHOD__ );

		$isHistory = $this->wg->Request->getVal( 'action' ) == 'history';

		if ( $this->checkArticleComments() ) {
			// link to article comments section
			if ( $this->contextTitle != $this->wg->Title || $isHistory ) {
				$commentsLink = $this->contextTitle->getLocalURL() . '#WikiaArticleComments';
			} else {
				// fix for redirected articles
				$commentsLink = '#WikiaArticleComments';
			}
		} else {
			// link to talk page
			if ( $this->contextTitle->canTalk() ) {
				$commentsLink = $this->contextTitle->getTalkPage()->getLocalURL();
			} else {
				// This case shouldn't happen other than Special:ThemeDesignerPreview
				// We're faking some comments to show a user what an article would look like
				$commentsLink = '';
			}
		}

		wfProfileOut( __METHOD__ );
		return $commentsLink;
	}

	/**
	 * Get tooltip for comments button
	 */
	private function getCommentsTooltip() {
		if ( $this->comments == 0 ) {
			$commentsTooltip = wfMessage( 'oasis-page-header-no-comments-tooltip' )->escaped();
		} else {
			$commentsTooltip = '';
		}

		return $commentsTooltip;
	}

	/**
	 * Format provided integer using one of oasis messages
	 * @param Integer $count - number of comments/talk pages
	 * @return String - formatted count
	 */
	private function formatCount( $count ) {
		if ( $count > 999999 ) {
			return $formattedComments = wfMessage( 'oasis-page-header-comments-m', floor( $count / 1000000 ) )->escaped();
		} else if ( $count > 999 ) {
			return $formattedComments = wfMessage( 'oasis-page-header-comments-k', floor( $count / 1000 ) )->escaped();
		}
		return $count;
	}

	public function index( $data ) {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->wg->ExtraNamespacesLocal ) ) {
			$this->wg->ExtraNamespacesLocal = [];
		}

		// set the page for which we're showing comments / likes
		// used for proper linking on blog posts listings
		if ( $this->request->getVal( 'title' ) ) {
			$this->contextTitle = $this->request->getVal( 'title' );
		} else {
			// by default we're showing # of comments for current page
			$this->contextTitle = &$this->wg->Title;
		}

		// comments / talks
		if ( is_numeric( $this->request->getVal( 'comments' ) ) ) {
			$this->comments = $this->request->getInt( 'comments' );

			// format number of comments (1200 -> 1k, 9999 -> 9k, 1.300.000 -> 1M)
			$this->formattedComments = $this->formatCount( $this->comments );

			$this->commentsLink = $this->getCommentsLink();
			$this->commentsTooltip = $this->getCommentsTooltip();
			$this->isArticleComments = $this->checkArticleComments();

			// get source of comments number (comments / talk page revisions)
			$this->commentsEnabled = $this->checkArticleComments();

			// pass accesskey => false to this module to disable accesskey attribute (BugId:15685)
			if ( !isset( $data['accesskey'] ) || $data['accesskey'] !== false ) {
				$this->commentsAccesskey = ' accesskey="t"';
			}

			// render comments count as just a bubble
			$this->commentsBubble = $this->request->getBool( 'bubble' );
		}

		wfProfileOut( __METHOD__ );
	}

	public function getData() {
		wfProfileIn( __METHOD__ );

		$this->contextTitle = $this->wg->Title;

		$count = $this->request->getVal( 'count' );
		$formattedCount = $this->formatCount( $count );
		$href = $this->getCommentsLink();
		$tooltip = $this->getCommentsTooltip();
		$mgsKey = $this->checkArticleComments() ? 'oasis-page-header-comments' : 'oasis-page-header-talk';
		$title = wfMessage( $mgsKey )->text();

		wfProfileOut( __METHOD__ );

		$this->response->setVal( 'data', [
			'href' => $href,
			'tooltip' => $tooltip,
			'formattedCount' => $formattedCount,
			'title' => $title,
		] );
	}
}
