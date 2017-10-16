<div class="wds-dropdown page-header__languages">
	<div class="wds-dropdown__toggle">
		<? // There is intentionally no new line between span and svg to not render additional space between text na svg icon ?>
		<span data-tracking="interwiki-dropdown"><?= $languages->currentLangName ?></span><?= DesignSystemHelper::renderSvg(
			'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
		) ?>
	</div>
	<div class="wds-dropdown__content wds-is-right-aligned">
		<ul class="wds-list wds-is-linked">
			<?php foreach ( $languages->languageList as $key => $val ) : ?>
				<li>
					<a href="<?= Sanitizer::encodeAttribute( $val['href'] ); ?>"
					   data-tracking="top-<?= $key ?>"><?= htmlspecialchars( $val['name'] ); ?></a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>
