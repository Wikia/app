<? // render simple version for comments bubble (for blogs) ?>
<? if ($commentsBubble): ?>
	<div class="commentslikes">
		<a href="<?= htmlspecialchars( $commentsLink ) ?>"
			class="comments<?= empty( $isArticleComments ) ? ' talk' : '' ?>"
			data-id="comment"
			title="<?= $commentsTooltip ?>"<?= $commentsAccesskey ?>>

			<span class="commentsbubble"><?= $formattedComments ?></span>
		</a>
	</div>

<? // show comments / talk button ?>
<? elseif ( isset( $comments ) ):
	$msg = $commentsEnabled ? 'oasis-page-header-comments' : 'oasis-page-header-talk';

	echo $app->renderView( 'MenuButton', 'Index', [
		'action' => [
			'text' => wfMessage( $msg, $comments )->text(),
			'html' => '<span class="commentsbubble">' . $formattedComments . '</span>',
			'href' => $commentsLink,
			// don't use MenuButton module magic to get accesskey for this item (BugId:15698 / 15685)
			'accesskey' => wfMessage( 'accesskey-ca-talk' )->escaped(),
		],
		'name' => 'comment',
		'class' => 'comments secondary' . ( empty( $isArticleComments ) ? ' talk' : '' ),
		'nofollow' => true,
	] );
endif; ?>
