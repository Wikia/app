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
	var $formattedComments;
	var $commentsAccesskey;
	var $commentsLink;
	var $commentsTooltip;

	var $showLike;
	var $likeHref;
	var $likeRef;

	/**
	 * Get URL of the page comments button should be linking to
	 */
	private function getCommentsLink() {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgRequest;

		$isHistory = $wgRequest->getVal('action') == 'history';

		if (class_exists('ArticleComment') && ArticleCommentInit::ArticleCommentCheckTitle($wgTitle)) {
			// link to article comments section
			if ($this->contextTitle != $wgTitle || $isHistory) {
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
		global $wgTitle, $wgLang, $wgContentNamespaces;

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
			$this->comments = $data['comments'];
			$this->formattedComments = $this->comments;

			$this->commentsLink = $this->getCommentsLink();
			$this->commentsTooltip = $this->getCommentsTooltip();

			$this->commentsAccesskey = ' accesskey="t"';
		}

		// Facebook's "Like"
		// @see http://developers.facebook.com/docs/reference/plugins/like
		if (!empty($data['likes'])) {
			$this->showLike = true;

			// canonical URL
			$this->likeHref = $this->contextTitle->getFullUrl();

			// check namespaces
			$ns = $this->contextTitle->getNamespace();
			if (in_array($ns, $wgContentNamespaces)) {
				$this->likeRef = 'content_page';
			}
			else if (defined('NS_BLOG_ARTICLE') && $ns == NS_BLOG_ARTICLE) {
				$this->likeRef = 'blog_page';
			}
			else if ($ns == NS_CATEGORY) {
				$this->likeRef = 'category_page';
			}
			else if (defined('NS_TOPLIST') && $ns == NS_TOPLIST) {
				$this->likeRef = 'list_page';
			}
			else {
				$this->showLike = false;
			}
		}

		wfProfileOut(__METHOD__);
	}
}