<div class="rwe-page-header">
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
	<ul class="rwe-page-header__nav">
		<li class="rwe-page-header__nav-element">
			<img src="/extensions/wikia/RWEPageHeader/svg/read_icon.svg"/>
			<a class="rwe-page-header__nav-link" href="/">Read</a>
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-dropdown-tiny',
				'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
			) ?>
		</li>

		<li class="rwe-page-header__nav-element">
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-pencil',
				'wds-icon wds-icon-small'
			) ?>
			<a class="rwe-page-header__nav-link" href="/">Contribute</a>
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-dropdown-tiny',
				'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
			) ?>
		</li>

		<li class="rwe-page-header__nav-element">
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-reply',
				'wds-icon wds-icon-small'
			) ?>
			<a class="rwe-page-header__nav-link" href="/d">Discuss</a>
		</li>

		<li class="rwe-page-header__nav-element">
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-magnifying-glass',
				'wds-icon wds-icon-small'
			) ?>
			<a class="rwe-page-header__nav-link" href="/Special:Search">Search</a>
		</li>
	</ul>
</div>
