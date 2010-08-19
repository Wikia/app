<!-- s:<?= __FILE__ ?> -->
<?php
if (!count($comments)) {
	echo '<ul id="article-comments-ul"><li>';
	echo '<div id="article-comments-zero">' . wfMsg('article-comments-zero-comments') . '</div>';
	echo '</li></ul>';
} else {
	echo '<ul id="article-comments-ul">';
	$odd = true;
	$first = ' article-comment-first';
	foreach ($comments as $commentId => $commentArr) {
		$rowClass = $odd ? 'odd' : 'even';
		$odd = !$odd;
		echo "<li id=\"comm-$commentId\" class=\"article-comments-li article-comments-row-{$rowClass}{$first} clearfix\">\n";
		echo $commentArr['level1']->render();
		echo "\n</li>\n";
		$first = '';
		if (isset($commentArr['level2'])) {
			foreach ($commentArr['level2'] as $commentId => $comment) {
				echo "<li id=\"comm-$commentId\" class=\"article-comments-li article-comments-nested clearfix\">\n";
				echo $comment->render();
				echo "\n</li>\n";
			}
		}
	}
	echo '</ul>';
}
?>
<!-- e:<?= __FILE__ ?> -->
