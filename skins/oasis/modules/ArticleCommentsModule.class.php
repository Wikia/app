<?php
class ArticleCommentsModule extends Module {

	var $dataAfterContent;   // fully rendered HTML that comes from skin object

	var $wgTitle;
	var $wgStylePath;

	var $avatar;
	var $canEdit;
	var $isBlocked;
	var $reason;
	var $commentListRaw;
	var $isReadOnly;
	var $pagination;
	var $countComments;
	var $countCommentsNested;

	public function executeIndex() {
		wfProfileIn(__METHOD__);

		global $wgTitle;


		if (class_exists('ArticleCommentInit') && ArticleCommentInit::ArticleCommentCheck()) {
			wfLoadExtensionMessages('ArticleComments');

			$commentList = ArticleCommentList::newFromTitle($wgTitle);
			$data = $commentList->getData();
			if (empty($data)) {
				// Seems like we should always have data, so this is an error.  How to signal?
			}

			// Hm.
			// TODO: don't pass whole instance of Masthead object for author of current comment
			$this->avatar = $data['avatar'];

			$this->canEdit = $data['canEdit'];
			$this->isBlocked = $data['isBlocked'];
			$this->reason = $data['reason'];
			$this->commentListRaw = $data['commentListRaw'];
			$this->isReadOnly = $data['isReadOnly'];
			$this->pagination = $data['pagination'];
			$this->countComments = $data['countComments'];
			$this->countCommentsNested = $data['countCommentsNested'];

			//echo "<pre>" . print_r($this->avatar, true) . "</pre>";

		}

		wfProfileOut(__METHOD__);
	}

	// Call via ajax like this:
	// http://owen.wikia-dev.com/index.php?action=ajax&rs=moduleProxy&moduleName=ArticleComments&actionName=AJAX&outputType=html
	// &moduleParams=json_encoded_array()
	//
    // $this->param = $wgRequest->getText('param');

	public function executeAJAX() {
			$commentList = ArticleCommentList::newFromTitle($wgTitle);
			$data = $commentList->getData();
			$this->commentListRaw = $data['commentListRaw'];
			$retval = '<ul id="article-comments-ul" class="comments">';

			foreach ($commentListRaw as $commentId => $commentArr) {
				$rowClass = $odd ? 'odd' : 'even';
				$odd = !$odd;
				$comment = $commentArr['level1']->getData();
				$retval .= wfRenderPartial('ArticleComments', 'Comment', array('comment' => $comment, 'commentId' => $commentId, 'rowClass' => $rowClass));
				$comment = array();
				if (isset($commentArr['level2'])) {
					echo '<ul>';
					foreach ($commentArr['level2'] as $commentId => $commentArr) {
						$comment = $commentArr->getData();
						$retval .= wfRenderPartial('ArticleComments', 'Comment', array('comment' => $comment, 'commentId' => $commentId, 'rowClass' => $rowClass));
					}
					echo "</ul>";
				}
			}
			return $retval;
	}
}