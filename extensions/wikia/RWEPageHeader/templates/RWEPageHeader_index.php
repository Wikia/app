<h2>test</h2>

<div>some random stuff</div>
<div id="searchFormWrapperRWE" class="wds-global-navigation">
	<form class="wds-global-navigation__search" action="<?= Sanitizer::encodeAttribute( $searchModel['module']['results']['url'] ); ?>">
		<div id="searchInputWrapperRWE" class="wds-dropdown wds-global-navigation__search-input-wrapper">
			<label class="wds-global-navigation__search-label">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-magnifying-glass',
					'wds-icon wds-icon-small wds-global-navigation__search-label-icon'
				) ?>
				<input id="searchInputRWE"
					   type="search"
					   class="wds-global-navigation__search-input"
					   name="<?= Sanitizer::encodeAttribute( $searchModel['module']['results']['param-name'] ); ?>"

						data-suggestions-url="<?= $searchModel['module']['suggestions']['url'] ?>"
						data-suggestions-param-name="<?= $searchModel['module']['suggestions']['param-name'] ?>"
						data-suggestions-tracking-label="<?= Sanitizer::encodeAttribute( $searchModel['module']['suggestions']['tracking_label'] ); ?>"

					   data-active-placeholder="<?= DesignSystemHelper::renderText( $searchModel['module']['placeholder-active'] ); ?>"
					   placeholder="<?= DesignSystemHelper::renderText( $searchModel['module']['placeholder-inactive'] ); ?>"
					   autocomplete="off"
				/>
			</label>
			<button class="wds-button wds-is-text wds-global-navigation__search-close" type="reset">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-cross',
					'wds-icon wds-icon-small wds-global-navigation__search-close-icon',
					wfMessage( 'global-navigation-search-cancel' )->escaped()
				) ?>
			</button>
			<button class="wds-button wds-global-navigation__search-submit" type="submit" data-tracking-label="<?= Sanitizer::encodeAttribute( $searchModel['module']['results']['tracking_label'] ); ?>">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-arrow',
					'wds-icon wds-icon-small wds-global-navigation__search-submit-icon'
				) ?>
			</button>
		</div>
	</form>
</div>