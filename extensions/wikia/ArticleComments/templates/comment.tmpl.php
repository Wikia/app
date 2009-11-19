<!-- s:<?= __FILE__ ?> -->
<div class="blog-comment">
	<a name="<?php echo isset( $comment["anchor"][2] ) ? $comment["anchor"][2] : "" ?>"></a>
	<div class="comment_avatar">
		<?php echo $comment["avatar"] ?>
	</div>
	<div class="comment">
		<div class="details">
			<strong><?php echo $comment["sig"] ?></strong>
			<span class="timestamp"><?php echo $comment["timestamp"] ?></span>
		<?php if ( $canDelete ) { ?>
			<a href="<?php echo $comment[ "title" ]->getLocalUrl( "redirect=no&action=delete" ) ?>"><?=wfMsg('blog-comment-delete')?></a>
		<?php } ?>
		<?php if ( $canEdit ) { ?>
			<a name="<?php echo $comment[ "title" ]->getArticleId() ?>" href="#<?php echo $comment[ "title" ]->getArticleId() ?>" class="blog-comm-edit" id="<?php echo $comment[ "title" ]->getArticleId() ?>"><?=wfMsg('blog-comment-edit')?></a>
			<?php if ( !empty($showHistory) && !$comment[ "title" ]->isNewPage() ) { ?>
				<?= $sk->makeKnownLinkObj( $comment[ "title" ], wfMsgHtml( 'blog-comment-history' ), 'action=history' ) ?>
			<?php } ?>
		<?php } ?>
		</div>
		<div class="blog-comm-text" id="comm-text-<?php echo $comment[ "title" ]->getArticleId() ?>">
		<?php
			echo $comment["text"];
		?>
		</div>
	</div>
</div>
<br style="clear: both;" />
<!-- e:<?= __FILE__ ?> -->
