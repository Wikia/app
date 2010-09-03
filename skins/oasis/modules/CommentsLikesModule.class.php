<?php
/**
 * Renders comments chicklet button with given value for given title
 *
 * @author Maciej Brencz
 */

class CommentsLikesModule extends Module {

	var $wgBlankImgUrl;

	private $contextTitle;

	var $comments;
	var $commentsAccesskey;
	var $commentsLink;
	var $commentsTooltip;
	var $likes;

	/**
	 * Get URL of the page comments button should be linking to
	 */
	private function getCommentsLink() {
		wfProfileIn(__METHOD__);
		global $wgTitle;

		if (class_exists('ArticleComment') && ArticleCommentInit::ArticleCommentCheck()) {
			// link to article comments section
			if ($this->contextTitle != $wgTitle) {
				$commentsLink = $this->contextTitle->getLocalUrl() . '#WikiaArticleComments';
			}
			else {
				// fix for redirected articles
				$commentsLink = '#WikiaArticleComments';
			}
		}
		else {
			// link to talk page
			$commentsLink = $this->contextTitle->getTalkPage()->getLocalUrl();
		}

		wfProfileOut(__METHOD__);
		return $commentsLink;
	}

	/**
	 * Get tooltip for comments button
	 */
	private function getCommentsTooltip() {
		if ($this->comments == 0) {
			$commentsTooltip = wfMsg('oasis-page-header-no-comments-tooltip');
		}
		else {
			$commentsTooltip = '';
		}

		return $commentsTooltip;
	}

	public function executeIndex($data) {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgLang;

		// set the page for which we're showing comments / likes
		// used for proper linking on blog posts listings
		if (!empty($data['title'])) {
			$this->contextTitle = $data['title'];
		}
		else {
			// by default we're showing # of comments for current page
			$this->contextTitle = &$wgTitle;
		}

		if (isset($data['comments']) && is_numeric($data['comments'])) {
			$this->comments = $wgLang->formatNum($data['comments']);

			$this->commentsLink = $this->getCommentsLink();
			$this->commentsTooltip = $this->getCommentsTooltip();

			$this->commentsAccesskey = ' accesskey="t"';
		}

		if (isset($data['likes']) && is_numeric($data['likes'])) {
			$this->likes = $data['likes'];
		}

		wfProfileOut(__METHOD__);
	}
}