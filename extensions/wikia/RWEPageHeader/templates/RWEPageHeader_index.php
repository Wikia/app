<div class="rwe-page-header">
	<div class="rwe-page-header-wordmark">
		<div class="rwe-page-haader-wordmark__shadow"></div>
		<div class="rwe-page-header-wordmark_wrapper" data-tracking="wordmark">
			<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
		</div>
	</div>
	<div class="rwe-page-header-nav__wrapper">
		<ul class="rwe-page-header-nav">
			<li class="rwe-page-header-nav__element rwe-page-header-nav__element-dropdown wds-dropdown">
				<a class="rwe-page-header-nav__link" href="#" data-tracking="read">
					<svg class="wds-icon wds-icon-small rwe-page-header-nav__icon" width="18" height="16" viewBox="0 0 18 16" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M12.938 0C11.363 0 9.9.45 9 1.237 8.1.45 6.638 0 5.062 0 2.138 0 0 1.462 0 3.375v11.25c0 .675.45 1.125 1.125 1.125s1.125-.45 1.125-1.125c0-.338 1.013-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125 0 .675.45 1.125 1.125 1.125s1.125-.45 1.125-1.125c0-.338 1.012-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125 0 .675.45 1.125 1.125 1.125S18 15.3 18 14.625V3.375C18 1.462 15.863 0 12.937 0zM5.061 11.25a7.37 7.37 0 0 0-2.812.563V3.374c0-.338 1.013-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125v8.438a7.37 7.37 0 0 0-2.813-.563zm10.688.563a7.37 7.37 0 0 0-2.813-.563 7.37 7.37 0 0 0-2.812.563V3.374c0-.338 1.012-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125v8.438z"/>
					</svg>
					<span class="rwe-page-header-nav__text">Read</span>
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-dropdown-tiny',
						'wds-icon wds-icon-tiny rwe-page-header-nav__chevron'
					) ?>
				</a>
				<?= $app->renderView('RWEPageHeader', 'readTab'); ?>
			</li>

			<li class="rwe-page-header-nav__element rwe-page-header-nav__element-dropdown wds-dropdown">
				<a class="rwe-page-header-nav__link" href="#" data-tracking="create">
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
				<?= $app->renderView('RWEPageHeader', 'createTab'); ?>
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
					<div id="searchInputWrapperRWE" class="wds-dropdown wds-global-navigation__search-input-wrapper" data-tracking="search">
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

								   data-active-placeholder="<?= Sanitizer::encodeAttribute(wfMessage( $searchModel['placeholder-active'], $searchModel['placeholder-active']['params']['sitename'] )->inContentLanguage()); ?>"
								   placeholder="<?= Sanitizer::encodeAttribute(wfMessage( $searchModel['placeholder-inactive'] )->inContentLanguage()); ?>"
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


