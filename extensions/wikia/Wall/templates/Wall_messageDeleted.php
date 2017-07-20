<div class="WikiaArticle" id="WikiaArticle">
	<?= wfMessage( 'wall-deleted-msg-text' )->escaped(); ?>
	<?php if ( !empty( $wallUrl ) ): ?>
		<a href="<?= $wallUrl ?>"><?= $returnTo ?></a>
	<?php endif; ?>
	<?php if ( $showViewLink ): ?>
		<p>
			<a href="<?php echo $viewUrl; ?>">
				<?php echo wfMessage( 'wall-deleted-msg-view' )->escaped(); ?>
			</a>
		</p>
	<?php endif; ?>
</div>
