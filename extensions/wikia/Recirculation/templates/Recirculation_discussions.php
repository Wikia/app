<div class="mcf-card mcf-card-discussions">
	<header class="mcf-card-discussions__header">
		<span><?= wfMessage( 'recirculation-discussions-latest-discussions' )->escaped() ?></span>
		<a href="<?= Sanitizer::encodeAttribute( $discussionsUrl ) ?>" class="mcf-card-discussions__link">
			<?= wfMessage( 'recirculation-discussion-link-text' )->escaped() ?>
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-arrow',
				'wds-icon wds-icon-small mcf-card-discussions__link-icon'
			) ?></a>
	</header>
	<ul class="mcf-card-discussions__list">
		<?php foreach ( $posts as $post ): ?>
			<li class="mcf-card-discussions__item">
				<a href="<?= AvatarService::getUrl( $post->author ) ?>" class="mcf-card-discussions__user-info">
					<img class="wds-avatar" src="<?= AvatarService::getAvatarUrl( $post->author, 26 ) ?>">
					<span class="mcf-card-discussions__user-subtitle"><?= Sanitizer::escapeHtmlAllowEntities( $post->author ) ?>
						• <time class="discussion-timestamp" datetime="<?= Sanitizer::encodeAttribute( $post->pub_date ) ?>"></time></span>
				</a>
				<a href="<?= Sanitizer::encodeAttribute( $post->url )?>">
					<div class="mcf-card-discussions__content"><?= Sanitizer::escapeHtmlAllowEntities( $post->title ) ?></div>
					<div class="mcf-card-discussions__meta">
						<div class="mcf-card-discussions__in">
							<?= wfMessage( 'recirculation-discussions-in' )->escaped() ?>
							<?= Sanitizer::escapeHtmlAllowEntities( $post->meta['forumName'] ) ?></div>
						<div class="mcf-card-discussions__counters">
							<?= DesignSystemHelper::renderSvg( 'wds-icons-upvote', 'wds-icon wds-icon-tiny' ) ?>
							<?= Sanitizer::escapeHtmlAllowEntities( $post->meta['upvoteCount'] ) ?>
							<?= DesignSystemHelper::renderSvg( 'wds-icons-reply', 'wds-icon wds-icon-tiny' ) ?>
							<?= Sanitizer::escapeHtmlAllowEntities( $post->meta['postCount'] ) ?>
						</div>
					</div>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
