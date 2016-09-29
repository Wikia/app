<form class="wds-global-navigation__search" action="<?= Sanitizer::encodeAttribute( $model['module']['results']['url'] ); ?>">
	<div id="searchInputWrapper" class="wds-dropdown wds-global-navigation__search-input-wrapper">
		<label class="wds-global-navigation__search-label">
			<?= DesignSystemHelper::getSvg(
				'wds-icons-magnifying-glass',
				'wds-icon wds-icon-small wds-global-navigation__search-label-icon'
			) ?>
			<input id="searchInput"
				type="search"
				class="wds-global-navigation__search-input"
				name="<?= Sanitizer::encodeAttribute( $model['module']['results']['param-name'] ); ?>"
				<?php if ( !empty( $model['module']['suggestions'] ) ) : ?>
					data-suggestions-url="<?= $model['module']['suggestions']['url'] ?>"
					data-suggestions-param-name="<?= $model['module']['suggestions']['param-name'] ?>"
				<?php endif; ?>
				data-active-placeholder="<?= DesignSystemHelper::renderText( $model['module']['placeholder-active'] ); ?>"
				placeholder="<?= DesignSystemHelper::renderText( $model['module']['placeholder-inactive'] ); ?>"
				autocomplete="off"
			/>
		</label>
		<button class="wds-button wds-is-text wds-global-navigation__search-close" type="reset" data-tracking-label="global-navigation-search-close">
			<?= DesignSystemHelper::getSvg(
				'wds-icons-cross',
				'wds-icon wds-icon-small wds-global-navigation__search-close-icon',
				wfMessage( 'global-navigation-search-cancel' )->escaped()
			) ?>
		</button>
		<button class="wds-button wds-global-navigation__search-submit" type="submit" data-tracking-label="global-navigation-search-submit">
			<?= DesignSystemHelper::getSvg(
				'wds-icons-arrow',
				'wds-icon wds-icon-small wds-global-navigation__search-submit-icon'
			) ?>
		</button>
	</div>
</form>
