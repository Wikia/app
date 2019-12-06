<form class="wds-global-navigation__search-container" action="<?= Sanitizer::encodeAttribute( $model['results']['url'] ); ?>">
	<div class="wds-global-navigation__search">
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
		<div class="wds-dropdown wds-global-navigation__search-dropdown wds-no-chevron wds-has-dark-shadow">
			<div class="wds-dropdown__toggle wds-global-navigation__search-input-wrapper">
				<div class="WikiaSearchInputWrapper">
					<div class="wds-dropdown">
						<div class="wds-dropdown__toggle">
						<span>
							<?= wfMsg( 'wikiasearch2-search-scope-internal' ) ?>
						</span>
							<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
						</div>
						<div class="wds-dropdown__content">
							<ul class="wds-list wds-is-linked">
								<li>
									<button class="wds-button wds-is-text" data-value="<?= \Wikia\Search\Config::SCOPE_INTERNAL ?>">
										<?= wfMsg( 'wikiasearch2-search-scope-internal' ) ?></button>
								</li>
								<li>
									<button class="wds-button wds-is-text" data-value="<?= \Wikia\Search\Config::SCOPE_CROSS_WIKI ?>">
										<?= wfMsg( 'wikiasearch2-search-scope-crosswiki' ) ?></button>
								</li>
							</ul>
						</div>
					</div>
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
				</div>
				<button class="wds-button wds-is-text wds-global-navigation__search-close" type="button">
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-close-tiny',
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
	</div>
</form>
