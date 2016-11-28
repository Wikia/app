<div class="rwe-page-header">
	<div class="rwe-page-header-wordmark">
		<div class="rwe-page-haader-wordmark__shadow"></div>
		<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
	</div>
	<div class="rwe-page-header-nav__wrapper">
		<ul class="rwe-page-header-nav">
			<li class="rwe-page-header-nav__element rwe-page-header-nav__element-dropdown wds-dropdown wds-dropdown__toggle">
				<a class="rwe-page-header-nav__link" href="#" data-tracking="read">
					<svg width="18" height="18" viewBox="0 0 18 18"
						 class="wds-icon wds-icon-small rwe-page-header-nav__icon" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd"
							  d="M12.063 2.875c-1.226 0-2.363.35-3.063.962-.7-.612-1.838-.962-3.063-.962C3.663 2.875 2 4.013 2 5.5v8.75c0 .525.35.875.875.875s.875-.35.875-.875c0-.262.787-.875 2.188-.875 1.4 0 2.187.613 2.187.875 0 .525.35.875.875.875s.875-.35.875-.875c0-.262.787-.875 2.188-.875 1.4 0 2.187.613 2.187.875 0 .525.35.875.875.875s.875-.35.875-.875V5.5c0-1.487-1.662-2.625-3.938-2.625zm-6.126 8.75c-.787 0-1.575.175-2.187.438V5.5c0-.263.787-.875 2.188-.875 1.4 0 2.187.612 2.187.875v6.563c-.612-.263-1.4-.438-2.188-.438zm8.313.438c-.613-.263-1.4-.438-2.188-.438-.787 0-1.574.175-2.187.438V5.5c0-.263.787-.875 2.188-.875 1.4 0 2.187.612 2.187.875v6.563z"></path>
					</svg>
					<span class="rwe-page-header-nav__text">Read</span>
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-dropdown-tiny',
						'wds-icon wds-icon-tiny rwe-page-header-nav__chevron'
					) ?>
				</a>
				<?= $app->renderView('RWEPageHeader', 'readTab'); ?>
			</li>

			<li class="rwe-page-header-nav__element rwe-page-header-nav__element-dropdown">
				<a class="rwe-page-header-nav__link" href="/wiki/Special:Community"
				   data-tracking="create">
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-pencil',
						'wds-icon wds-icon-small rwe-page-header-nav__icon'
					) ?>
					<span class="rwe-page-header-nav__text">Create</span>
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-dropdown-tiny',
						'wds-icon wds-icon-tiny rwe-page-header-nav__chevron'
					) ?>
				</a>
			</li>

			<li class="rwe-page-header-nav__element">
				<a class="rwe-page-header-nav__link" href="<?= $discussTabLink ?>" data-tracking="discuss">
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-reply',
						'wds-icon wds-icon-small rwe-page-header-nav__icon'
					) ?>
					<span class="rwe-page-header-nav__text">Discuss</span>
				</a>
			</li>

			<li id="searchFormWrapperRWE" class="rwe-page-header-nav__element">
				<form class="wds-global-navigation__search" action="<?= Sanitizer::encodeAttribute( $searchModel['results']['url'] ); ?>">
					<div id="searchInputWrapperRWE" class="wds-dropdown wds-global-navigation__search-input-wrapper">
						<label class="wds-global-navigation__search-label">
							<?= DesignSystemHelper::renderSvg(
								'wds-icons-magnifying-glass',
								'wds-icon wds-icon-small wds-global-navigation__search-label-icon'
							) ?>
							<input id="searchInputRWE"
								   type="search"
								   class="wds-global-navigation__search-input"
								   name="<?= Sanitizer::encodeAttribute( $searchModel['results']['param-name'] ); ?>"

								   data-suggestions-url="<?= $searchModel['suggestions']['url'] ?>"
								   data-suggestions-param-name="<?= $searchModel['suggestions']['param-name'] ?>"
								   data-suggestions-tracking-label="rwe-<?= Sanitizer::encodeAttribute( $searchModel['suggestions']['tracking_label'] ); ?>"

								   data-active-placeholder="<?= DesignSystemHelper::renderText( $searchModel['placeholder-active'] ); ?>"
								   placeholder="<?= DesignSystemHelper::renderText( $searchModel['placeholder-inactive'] ); ?>"
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
						<button class="wds-button wds-global-navigation__search-submit" type="submit" data-tracking-label="rwe-<?= Sanitizer::encodeAttribute( $searchModel['results']['tracking_label'] ); ?>">
							<?= DesignSystemHelper::renderSvg(
								'wds-icons-arrow',
								'wds-icon wds-icon-small wds-global-navigation__search-submit-icon'
							) ?>
						</button>
					</div>
				</form>
			</li>
		</ul>
	</div>
</div>


