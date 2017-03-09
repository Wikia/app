<ul class="pph-local-nav-menu">
	<? foreach ( $data as $item ) : ?>
		<li class="pph-local-nav-item-l1">
			<a href="<?= $item['href'] ?>"><?= $item['textEscaped'] ?></a>
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-dropdown-tiny',
				'wds-icon wds-icon-tiny pph-local-nav-chevron'
			) ?>
			<ul class="pph-local-nav-sub-menu pph-local-nav-l2">
				<? foreach ( $item['children'] as $childL2 ): ?>
					<li class="pph-local-nav-item-l2">
						<a href="<?= $childL2['href'] ?>"><?= $childL2['textEscaped'] ?></a>

						<? if ( !empty( $childL2['children'] ) ): ?>
							<ul class="pph-local-nav-sub-menu pph-local-nav-l3">
								<? foreach ( $childL2['children'] as $childL3 ): ?>
									<li class="pph-local-nav-item-l3">
										<a href="<?= $childL3['href'] ?>"><?= $childL3['textEscaped'] ?></a>
									</li>
								<? endforeach; ?>
							</ul>
						<? endif; ?>
					</li>
				<? endforeach; ?>
			</ul>
		</li>
	<? endforeach; ?>
	<li class="pph-local-nav-item-l1 pph-local-nav-explore">
		<svg class="wds-icon wds-icon-small rwe-page-header-nav__icon" width="18" height="16" viewBox="0 0 18 16"
			 xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd"
				  d="M12.938 0C11.363 0 9.9.45 9 1.237 8.1.45 6.638 0 5.062 0 2.138 0 0 1.462 0 3.375v11.25c0 .675.45 1.125 1.125 1.125s1.125-.45 1.125-1.125c0-.338 1.013-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125 0 .675.45 1.125 1.125 1.125s1.125-.45 1.125-1.125c0-.338 1.012-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125 0 .675.45 1.125 1.125 1.125S18 15.3 18 14.625V3.375C18 1.462 15.863 0 12.937 0zM5.061 11.25a7.37 7.37 0 0 0-2.812.563V3.374c0-.338 1.013-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125v8.438a7.37 7.37 0 0 0-2.813-.563zm10.688.563a7.37 7.37 0 0 0-2.813-.563 7.37 7.37 0 0 0-2.812.563V3.374c0-.338 1.012-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125v8.438z"/>
		</svg>
		<span><?= $explore['text'] ?></span>
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny pph-local-nav-chevron'
		) ?>
		<ul class="pph-local-nav-sub-menu pph-local-nav-l2">
			<? foreach ( $explore['children'] as $child ): ?>
				<li class="pph-local-nav-item-l2">
					<a href="<?= $child['href'] ?>"><?= $child['textEscaped'] ?></a>
				</li>
			<? endforeach; ?>
		</ul>
	</li>
	<li class="pph-local-nav-item-l1 pph-local-nav-discuss">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-reply',
			'wds-icon wds-icon-small rwe-page-header-nav__icon'
		) ?>
		<a href="<?= $discuss['href'] ?>"><?= $discuss['text'] ?></a>
	</li>
</ul>
