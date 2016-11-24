<div class="rwe-page-header">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
	<ul class="rwe-page-header__nav">
		<li class="rwe-page-header__nav-element">
			<a class="rwe-page-header__nav-link rwe-page-header--dropdown" href="/" data-tracking="read">
				<svg width="18" height="18" viewBox="0 0 18 18" class="wds-icon wds-icon-small rwe-page-header__icon" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M12.063 2.875c-1.226 0-2.363.35-3.063.962-.7-.612-1.838-.962-3.063-.962C3.663 2.875 2 4.013 2 5.5v8.75c0 .525.35.875.875.875s.875-.35.875-.875c0-.262.787-.875 2.188-.875 1.4 0 2.187.613 2.187.875 0 .525.35.875.875.875s.875-.35.875-.875c0-.262.787-.875 2.188-.875 1.4 0 2.187.613 2.187.875 0 .525.35.875.875.875s.875-.35.875-.875V5.5c0-1.487-1.662-2.625-3.938-2.625zm-6.126 8.75c-.787 0-1.575.175-2.187.438V5.5c0-.263.787-.875 2.188-.875 1.4 0 2.187.612 2.187.875v6.563c-.612-.263-1.4-.438-2.188-.438zm8.313.438c-.613-.263-1.4-.438-2.188-.438-.787 0-1.574.175-2.187.438V5.5c0-.263.787-.875 2.188-.875 1.4 0 2.187.612 2.187.875v6.563z"></path>
				</svg>
				<span class="rwe-page-header__nav-text">Read</span>
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny rwe-page-header__chevron'
				) ?>
			</a>
		</li>

		<li class="rwe-page-header__nav-element">
			<a class="rwe-page-header__nav-link rwe-page-header--dropdown" href="/wiki/Special:Community" data-tracking="create">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-pencil',
					'wds-icon wds-icon-small rwe-page-header__icon'
				) ?>
				<span class="rwe-page-header__nav-text">Create</span>
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny rwe-page-header__chevron'
				) ?>
			</a>
		</li>

		<li class="rwe-page-header__nav-element">
			<a class="rwe-page-header__nav-link" href="<?= $discussTabLink ?>" data-tracking="discuss">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-reply',
					'wds-icon wds-icon-small rwe-page-header__icon'
				) ?>
				<span class="rwe-page-header__nav-text">Discuss</span>
			</a>
		</li>

		<li class="rwe-page-header__nav-element">
			<a class="rwe-page-header__nav-link" href="/wiki/Special:Search" data-tracking="search">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-magnifying-glass',
					'wds-icon wds-icon-small rwe-page-header__icon'
				) ?>
				<span class="rwe-page-header__nav-text">Search</span>
			</a>
		</li>
	</ul>
</div>
