<div class="mcf-card mcf-card-discussions">
	<header class="mcf-card-discussions__header">
		<span><?= wfMessage( 'recirculation-discussions-latest-discussions' )
				->inContentLanguage()
				->escaped() ?></span>
		<a href="<?= Sanitizer::encodeAttribute( $discussionsUrl ) ?>"
		   class="mcf-card-discussions__link" data-tracking="discussions-link">
			<?= wfMessage( 'recirculation-discussion-link-text' )->inContentLanguage()->escaped() ?>
			<?= DesignSystemHelper::renderSvg( 'wds-icons-arrow',
				'wds-icon wds-icon-small mcf-card-discussions__link-icon' ) ?></a>
	</header>
	<ul class="mcf-card-discussions__list">
		<? if($showZeroState): ?>
		<a href="<?= Sanitizer::encodeAttribute( $discussionsUrl ) ?>" class="mcf-card-discussions__zero-state">
			<?= DesignSystemHelper::renderSvg( 'wds-icons-add', 'wds-icon mcf-card-discussions__zero-state-icon' ) ?>
			<div
				class="mcf-card-discussions__zero-state-text"><?= wfMessage( 'recirculation-discussions-no-posts' )
					->inContentLanguage()
					->escaped() ?></div>
			<span
				class="mcf-card-discussions__zero-state-text"><?= wfMessage( 'recirculation-discussions-get-started' )
					->inContentLanguage()
					->escaped() ?></span>
		</a>
		<? endif ?>
		<?php foreach ( $posts as $index => $post ): ?>
			<li class="mcf-card-discussions__item">
				<?php if ( $post->authorIsAnon ): ?>
					<span class="mcf-card-discussions__user-info">
						<?= F::app()
							->renderView( 'Recirculation', 'discussionsAuthor',
								[ 'post' => $post ] ) ?>
					</span>
				<?php else: ?>
					<a href="<?= AvatarService::getUrl( $post->author ) ?>"
					   class="mcf-card-discussions__user-info"
					   data-tracking="discussions-user-<?= $index ?>">
						<?= F::app()
							->renderView( 'Recirculation', 'discussionsAuthor',
								[ 'post' => $post ] ) ?>
					</a>
				<?php endif; ?>
				<a href="<?= Sanitizer::encodeAttribute( $post->url )?>" data-tracking="discussions-post-<?= $index ?>">
					<div class="mcf-card-discussions__content"><?= Sanitizer::escapeHtmlAllowEntities( $post->title ) ?></div>
					<div class="mcf-card-discussions__meta">
						<div class="mcf-card-discussions__in">
							<?= wfMessage( 'recirculation-discussions-in' )->inContentLanguage()->escaped() ?>
							<?= Sanitizer::escapeHtmlAllowEntities( $post->meta['forumName'] ) ?></div>
						<div class="mcf-card-discussions__counters">
							<?= DesignSystemHelper::renderSvg( 'wds-icons-heart', 'wds-icon wds-icon-tiny' ) ?>
							<?= Sanitizer::escapeHtmlAllowEntities( $post->meta['upvoteCount'] ) ?>
							<?= DesignSystemHelper::renderSvg( 'wds-icons-comment', 'wds-icon wds-icon-tiny' ) ?>
							<?= Sanitizer::escapeHtmlAllowEntities( $post->meta['postCount'] ) ?>
						</div>
					</div>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
