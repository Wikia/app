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
			<?php foreach ( $wikiButtons as $wikiButton ): ?>
				<a class="wds-button wds-is-squished wds-is-secondary<?= empty( $wikiButton->additionalClasses ) ? '' : ' ' . $wikiButton->additionalClasses ?>"
				   href="<?= $wikiButton->href ?>"
				   data-tracking="<?= $wikiButton->tracking ?>"<?php if ( !empty( $wikiButton->title ) ): ?> title="<?= $wikiButton->title->render() ?>"<?php endif; ?>>
					<?= DesignSystemHelper::renderSvg( $wikiButton->icon, 'wds-icon wds-icon-small' ) ?>
					<?php if ( !empty( $wikiButton->label ) ): ?>
						<span><?= $wikiButton->label->render() ?></span>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<?= $app->renderView( 'CommunityHeaderService', 'localNavigation' ); ?>
</header>
