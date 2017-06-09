<?php
/**
 * Renders comments chicklet button with given value for given title
 *
 * @author Maciej Brencz
 */

class CommentsLikesController extends WikiaController {

	private $contextTitle;

	public function init() {
		$this->commentsAccesskey = null;
		$this->commentsBubble = null;
	}

	/**
	 * Are article comments enabled for context title?
	 */
	private function checkArticleComments() {
		$this->isArticleComments = class_exists('ArticleComment') && ArticleCommentInit::ArticleCommentCheckTitle($this->contextTitle);
		return $this->isArticleComments;
	}

	/**
	 * Get URL of the page comments button should be linking to
	 */
	private function getCommentsLink() {
		if ( $this->checkArticleComments() ) {
			$commentsLink = ArticleCommentInit::getCommentsLink( $this->contextTitle );
		}
		else {
			// link to talk page
			if ($this->contextTitle->canTalk($this->contextTitle->getNamespace())) {
				$commentsLink = $this->contextTitle->getTalkPage()->getLocalUrl();
			} else {
				// This case shouldn't happen other than Special:ThemeDesignerPreview
				// We're faking some comments to show a user what an article would look like
				$commentsLink = '';
			}
		}

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

	/**
	 * Format provided integer using one of oasis messages
	 * @param Integer $count - number of comments/talk pages
	 * @return String - formatted count
	 */
	public static function formatCount($count) {
		if ($count > 999999) {
			return $formattedComments = wfMessage('oasis-page-header-comments-m', floor($count / 1000000))->text();
		}
		else if ($count > 999) {
			return $formattedComments = wfMessage('oasis-page-header-comments-k', floor($count / 1000))->text();
		}
		return $count;
	}

	public function executeIndex($data) {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgContentNamespaces, $wgExtraNamespacesLocal;

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

		// comments / talks
		if (isset($data['comments']) && is_numeric($data['comments'])) {
			$this->comments = $data['comments'];

			// format number of comments (1200 -> 1k, 9999 -> 9k, 1.300.000 -> 1M)
			$this->formattedComments = self::formatCount($this->comments);

			$this->commentsLink = $this->getCommentsLink();
			$this->commentsTooltip = $this->getCommentsTooltip();
			$this->isArticleComments = $this->checkArticleComments();

			// get source of comments number (comments / talk page revisions)
			$this->commentsEnabled = $this->checkArticleComments();

			// pass accesskey => false to this module to disable accesskey attribute (BugId:15685)
			if (!isset($data['accesskey']) || $data['accesskey'] !== false) {
				$this->commentsAccesskey = ' accesskey="t"';
			}

			// render comments count as just a bubble
			$this->commentsBubble = !empty($data['bubble']);
		}

		wfProfileOut(__METHOD__);
	}

	public function getData() {
		global $wgTitle;

		wfProfileIn(__METHOD__);

		$this->contextTitle = $wgTitle;

		$count = $this->request->getVal('count');
		$formattedCount = self::formatCount($count);
		$href = $this->getCommentsLink();
		$tooltip = $this->getCommentsTooltip();
		$mgsKey = $this->checkArticleComments() ? 'oasis-page-header-comments' : 'oasis-page-header-talk';
		$title = wfMessage($mgsKey)->text();

		wfProfileOut(__METHOD__);

		$this->response->setVal('data', [
			'href' => $href,
			'tooltip' => $tooltip,
			'formattedCount' => $formattedCount,
			'title' => $title
		]);
	}
}
