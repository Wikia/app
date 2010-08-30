<ul id="article-comments-ul" class="comments">
	<?php
	if (!count($commentListRaw)) {
		echo '<li>';
		echo '<div id="article-comments-zero"></div>';
		echo '</li>';
	} else {
		$odd = true;
		foreach ($commentListRaw as $commentId => $commentArr) {
			$rowClass = $odd ? 'odd' : 'even';
			$odd = !$odd;
			$comment = $commentArr['level1']->getData();
			echo wfRenderPartial('ArticleComments', 'Comment', array('comment' => $comment, 'commentId' => $commentId, 'rowClass' => $rowClass));
			$comment = array();
			if (isset($commentArr['level2'])) {
				echo "<ul>\n";
				foreach ($commentArr['level2'] as $commentId => $commentArr) {
					$comment = $commentArr->getData();
					echo wfRenderPartial('ArticleComments', 'Comment', array('comment' => $comment, 'commentId' => $commentId, 'rowClass' => $rowClass));
				}
				echo "</ul>";
			}
		}
	}
	?>
</ul>
