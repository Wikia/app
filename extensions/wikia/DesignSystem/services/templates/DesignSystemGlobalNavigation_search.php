<form class="wds-global-navigation__search-container" action="<?= Sanitizer::encodeAttribute( $model['results']['url'] ); ?>">
	<div class="wds-dropdown wds-global-navigation__search wds-no-chevron wds-has-dark-shadow">
		<div class="wds-global-navigation__search-toggle">
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-magnifying-glass-small',
				'wds-icon wds-icon-small wds-global-navigation__search-toggle-icon'
			) ?>
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-magnifying-glass',
				'wds-icon wds-global-navigation__search-toggle-icon'
			) ?>
			<span class="wds-global-navigation__search-toggle-text">
				<?= wfMessage( 'global-navigation-search-placeholder-inactive' )->escaped(); ?>
			</span>
		</div>
		<div class="wds-dropdown__toggle wds-global-navigation__search-input-wrapper">
			<input
				type="search"
				class="wds-global-navigation__search-input"
				name="<?= Sanitizer::encodeAttribute( $model['results']['param-name'] ); ?>"
				placeholder="<?= DesignSystemHelper::renderTranslatableText( $model['placeholder-active'] ); ?>"
				autocomplete="off"
				<?php if ( !empty( $model['suggestions'] ) ) : ?>
					data-suggestions-url="<?= $model['suggestions']['url'] ?>"
					data-suggestions-param-name="<?= $model['suggestions']['param-name'] ?>"
					data-suggestions-tracking-label="<?= Sanitizer::encodeAttribute( $model['suggestions']['tracking-label'] ); ?>"
				<?php endif; ?>
			>
			<button class="wds-button wds-is-text wds-global-navigation__search-close" type="button">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-add-tiny',
					'wds-icon wds-icon-tiny wds-global-navigation__search-close-icon'
				) ?>
			</button>
			<button class="wds-button wds-global-navigation__search-submit"
				data-tracking-label="<?= Sanitizer::encodeAttribute( $model['results']['tracking-label'] ); ?>">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-arrow-small',
					'wds-icon wds-icon-small wds-global-navigation__search-submit-icon'
				) ?>
			</button>
		</div>
	</div>
</form>
