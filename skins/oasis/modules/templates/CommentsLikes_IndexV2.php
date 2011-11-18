<?php
	// render simple version for comments bubble (for blogs)
	if ($commentsBubble) {
?>
	<div class="commentslikes">
		<a href="<?= htmlspecialchars($commentsLink) ?>" class="comments" data-id="comment" title="<?= htmlspecialchars($commentsTooltip) ?>"<?= $commentsAccesskey ?>><span class="commentsbubble"><?= $formattedComments ?></span></a>
	</div>
<?php
	}
	// show comments / talk button
	else if (isset($comments)) {
		$text = wfMsgExt($commentsEnabled ? 'oasis-page-header-comments' : 'oasis-page-header-talk', array('parsemag'), $comments);

		echo wfRenderModule('MenuButton', 'Index', array(
			'action' => array(
				'text' => $text,
				'html' => '<span class="commentsbubble">'.$formattedComments.'</span>',
				'href' => $commentsLink,
			),
			'name' => 'comment',
			'class' => 'comments secondary'
		));
	}
?>