<!-- s:<?= __FILE__ ?> -->
<div class="blog-comment">
<?php
	if( ! $comment[ "hidden" ] ):
?>
	<a name="<?php echo isset( $comment["anchor"][2] ) ? $comment["anchor"][2] : "" ?>"></a>
	<div class="comment_avatar">
		<?php echo $comment["avatar"] ?>
	</div>
	<div class="comment">
		<div class="details">
			<strong><?php echo $comment["sig"] ?></strong>
			<span class="timestamp"><?php echo isset( $comment["anchor"][2] ) ? '<a href="#' . $comment["anchor"][2] . '">' . $comment["timestamp"] . '</a>': $comment["timestamp"] ?></span>
		<?php if( $canDelete ): ?>
			<a href="<?php echo $comment[ "title" ]->getLocalUrl( "redirect=no&action=delete" ) ?>"><?= wfMessage( 'blog-comment-delete' )->text() ?></a>
		<?php endif; ?>
		<?php if( $canToggle ): ?>
			<a href="#" class="blog-comm-hide" id="<?php echo $comment[ "title" ]->getArticleId() ?>"><?= wfMessage( 'blog-comment-hide' )->text() ?></a>
		<?php endif; ?>
		<?php if( $canEdit ): ?>
			<a name="<?php echo $comment[ "title" ]->getArticleId() ?>" href="#<?php echo $comment[ "title" ]->getArticleId() ?>" class="blog-comm-edit" id="<?php echo $comment[ "title" ]->getArticleId() ?>"><?= wfMessage( 'blog-comment-edit' )->text() ?></a>
			<?php if ( !empty($showHistory) && !$comment[ "title" ]->isNewPage() ) : ?>
				<?= $sk->makeKnownLinkObj( $comment[ "title" ], wfMessage( 'blog-comment-history' )->rawParams()->escaped(), 'action=history' ) ?>
			<?php endif; ?>
		<?php endif; ?>
		</div>
		<div class="blog-comm-text" id="comm-text-<?php echo $comment[ "title" ]->getArticleId() ?>">
		<?php
			echo $comment["text"];
		?>
		</div>
	</div>
<?php
	else:
		echo "<div class=\"blog-comment-hidden\">\n";
		echo wfMessage( "blogs-comment-hidden" )->text();
		if( $canToggle ):
			echo '&nbsp;<a href="#" class="blog-comm-hide" id="'.$comment[ "title" ]->getArticleId().'">' . wfMessage( 'blog-comment-unhide' )->text() . '</a>';
		endif;
		echo "</div>\n";
	endif; ### comment[ "hiddent" ]
?>
</div>
<br style="clear: both;" />
<!-- e:<?= __FILE__ ?> -->
