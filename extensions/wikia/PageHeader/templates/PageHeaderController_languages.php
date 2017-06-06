<div class="wds-dropdown page-header__languages <?= $languages->isDisabled() ? 'wds-is-disabled' : '' ?>">
	<div class="wds-dropdown__toggle">
			<span class="" data-tracking="interwiki-dropdown">
				<?= $languages->currentLangName ?>
			</span>
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-dropdown-tiny',
				'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
			) ?>
	</div>
		<?php if ( count( $languages->languageList ) > 1 ): ?>
			<div class="wds-dropdown__content wds-is-right-aligned">
				<ul class="wds-list">
					<?php foreach ( $languages->languageList as $key => $val ) : ?>
						<li>
							<a href="<?= Sanitizer::encodeAttribute( $val['href'] ); ?>"
							   data-tracking="top-<?= $key ?>"><?= htmlspecialchars( $val['name'] ); ?></a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>

