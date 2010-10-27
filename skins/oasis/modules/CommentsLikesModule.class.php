<?php
/**
 * Renders comments chicklet button with given value for given title
 *
 * @author Maciej Brencz
 */

class CommentsLikesModule extends Module {

	var $wgBlankImgUrl;

	var $comments;
	var $commentsBubble;
	var $formattedComments;
	var $commentsAccesskey;
	var $commentsEnabled;
	var $commentsLink;
	var $commentsTooltip;

	var $showLike;
	var $likeHref;
	var $likeRef;
	var $likeTheme;

	private $contextTitle;

	/**
	 * Are article comments enabled for context title?
	 */
	private function checkArticleComments() {
		return class_exists('ArticleComment') && ArticleCommentInit::ArticleCommentCheckTitle($this->contextTitle);
	}

	/**
	 * Get URL of the page comments button should be linking to
	 */
	private function getCommentsLink() {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgRequest;

		$isHistory = $wgRequest->getVal('action') == 'history';

		if ($this->checkArticleComments()) {
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
		global $wgTitle, $wgLang, $wgContentNamespaces, $wgExtraNamespacesLocal;
		if(empty($wgExtraNamespacesLocal)){
			$wgExtraNamespacesLocal = array();
		}

		// set the page for which we're showing comments / likes
		// used for proper linking on blog posts listings
		if (!empty($data['title'])) {
			$this->contextTitle = $data['title'];
		}
		else {
			// by default we're showing # of comments for current page
			$this->contextTitle = &$wgTitle;
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
			// RT #74393: include custom namespaces
			else if (in_array($ns, array_keys($wgExtraNamespacesLocal))) {
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

			// check lightness of skin theme
			$this->likeTheme = SassUtil::isThemeDark() ? 'dark' : 'light';
		}

		// comments / talks
		if (isset($data['comments']) && is_numeric($data['comments'])) {
			$this->comments = $data['comments'];

			// format number of comments (1200 -> 1k, 9999 -> 9k, 1.300.000 -> 1M)
			$this->formattedComments = $this->comments;

			if ($this->comments > 999999) {
				$this->formattedComments = wfMsg('oasis-page-header-comments-m', floor($this->comments / 1000000));
			}
			else if ($this->comments > 999) {
				$this->formattedComments = wfMsg('oasis-page-header-comments-k', floor($this->comments / 1000));
			}

			$this->commentsLink = $this->getCommentsLink();
			$this->commentsTooltip = $this->getCommentsTooltip();

			// get source of comments number (comments / talk page revisions)
			$this->commentsEnabled = $this->checkArticleComments();

			$this->commentsAccesskey = ' accesskey="t"';

			// render comments count as just a bubble
			$this->commentsBubble = !empty($data['bubble']);
		}

		wfProfileOut(__METHOD__);
	}
}