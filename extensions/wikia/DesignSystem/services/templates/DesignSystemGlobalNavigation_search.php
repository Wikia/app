<form class="wds-global-navigation__search" action="<?= Sanitizer::encodeAttribute( $model['module']['results']['url'] ); ?>">
	<div class="wds-dropdown wds-is-active wds-global-navigation__search-input-wrapper">
		<label class="wds-global-navigation__search-label">
			<?= DesignSystemHelper::getSvg(
				'wds-icons-magnifying-glass',
				'wds-icon wds-icon-small wds-global-navigation__search-label-icon'
			) ?>
			<input id="searchInput"
			       class="wds-global-navigation__search-input"
			       name="<?= Sanitizer::encodeAttribute( $model['module']['results']['param-name'] ); ?>"
			       data-active-placeholder="<?= DesignSystemHelper::renderText( $model['module']['placeholder-active'] ); ?>"
			       placeholder="<?= DesignSystemHelper::renderText( $model['module']['placeholder-inactive'] ); ?>"/>
		</label>
		<button class="wds-button wds-is-text wds-global-navigation__search-close" type="reset">
			<?= DesignSystemHelper::getSvg(
				'wds-icons-cross',
				'wds-icon wds-icon-small wds-global-navigation__search-close-icon',
				wfMessage( 'global-navigation-search-cancel' )->escaped()
			) ?>
		</button>
	</div>
	<button class="wds-button wds-global-navigation__search-submit">
		<?= DesignSystemHelper::getSvg(
			'wds-icons-arrow',
			'wds-icon wds-icon-small wds-global-navigation__search-submit-icon'
		) ?>
	</button>
</form>
