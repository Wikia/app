<div class="wds-dropdown page-header__languages <?= count( $languages->languageList ) <= 1 ? 'wds-is-disabled' : '' ?>">
	<div class="wds-dropdown__toggle">
			<span class="" data-tracking="interwiki-dropdown">
				<?= $languages->currentLangName ?>
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
				) ?>
			</span>
	</div>
		<?php if ( count( $languages->languageList ) > 1 ): ?>
			<div class="wds-dropdown__content">
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

