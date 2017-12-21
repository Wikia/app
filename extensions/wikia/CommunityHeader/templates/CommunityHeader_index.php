<header
	<?= !empty( $backgroundImageUrl ) ? "style=\"background-image: url({$backgroundImageUrl});\"" : '' ?>
	class="wds-community-header">
	<? if ( $wordmark->hasWordmark() ) : ?>
		<div class="wds-community-header__wordmark" data-tracking="<?= $wordmark->trackingLabel ?>">
			<a accesskey="z" href="<?= $wordmark->href ?>">
				<img src="<?= $wordmark->image->url ?>"
					 width="<?= $wordmark->image->width ?>"
					 height="<?= $wordmark->image->height ?>"
					 alt="<?= $wordmark->label->render() ?>">
			</a>
		</div>
	<? endif; ?>
	<div class="wds-community-header__top-container">
		<div class="wds-community-header__sitename" data-tracking="<?= $sitename->trackingLabel ?>">
			<a href="<?= $sitename->url ?>"><?= $sitename->titleText->render() ?></a>
		</div>
		<div class="wds-community-header__counter" data-tracking="<?= $counter->trackingLabel ?>">
			<span class="wds-community-header__counter-value"><?= $counter->value ?></span>
			<span class="wds-community-header__counter-label"><?= $counter->label->render() ?></span>
		</div>
		<div class="wds-community-header__wiki-buttons wds-button-group">
			<?php foreach ( $wikiButtons->buttons as $wikiButton ): ?>
				<a class="wds-button wds-is-squished wds-is-secondary<?= empty( $wikiButton->additionalClasses ) ? '' : ' ' . $wikiButton->additionalClasses ?>"
				   href="<?= $wikiButton->href ?>"
				   data-tracking="<?= $wikiButton->tracking ?>"<?php if ( !empty( $wikiButton->title ) ): ?> title="<?= $wikiButton->title->render() ?>"<?php endif; ?>>
					<?= DesignSystemHelper::renderSvg( $wikiButton->icon, 'wds-icon wds-icon-small' ) ?>
					<?php if ( !empty( $wikiButton->label ) ): ?>
						<span><?= $wikiButton->label->render() ?></span>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
			<?php if ( !empty( $wikiButtons->moreButtons ) ): ?>
				<div class="wds-dropdown">
					<div class="wds-button wds-is-squished wds-is-secondary wds-dropdown__toggle">
						<?= DesignSystemHelper::renderSvg( 'wds-icons-more', 'wds-icon wds-icon-small' ) ?>
					</div>
					<div class="wds-dropdown__content wds-is-not-scrollable wds-is-right-aligned">
						<ul class="wds-list wds-is-linked">
							<?php foreach ( $wikiButtons->moreButtons as $moreButton): ?>
								<li>
									<a href="<?= $moreButton->href ?>"
									   data-tracking="<?= $moreButton->tracking ?>"<?= empty( $moreButton->additionalClasses )
										? '' : ' class="' . $moreButton->additionalClasses . '"' ?>>
									<?= $moreButton->label->render() ?>
									</a>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?= $app->renderView( 'CommunityHeaderService', 'localNavigation' ); ?>
</header>
