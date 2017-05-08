<ul class="pph-local-nav-menu">
	<? foreach ( $data as $item ) : ?>
		<li class="pph-local-nav-tracking pph-local-nav-item-l1<? if ( !empty( $item['children'] ) ): ?> pph-local-nav-container<? else: ?> pph-local-nav-link<? endif; ?>">
			<a href="<?= $item['href'] ?>"
			   data-tracking="custom-level-1"><?= $item['text'] ?></a><?php if ( !empty( $item['children'] ) ) : ?><?= DesignSystemHelper::renderSvg(
				'wds-icons-dropdown-tiny',
				'wds-icon wds-icon-tiny pph-local-nav-chevron'
			) ?>
				<ul class="pph-local-nav-sub-menu pph-local-nav-l2">
					<div class="pph-local-nav-spread">
						<? foreach ( $item['children'] as $i => $childL2 ): ?>
							<li class="pph-local-nav-tracking pph-local-nav-item-l2
						<? if ( !empty( $childL2['children'] ) ): ?> pph-local-nav-container<? endif; ?>
						<?php if ( !empty( $childL2['children'] ) && count( $childL2['children'] ) < $i + 1 ): ?> pph-sticked-to-parent<?php endif; ?>">
								<a href="<?= $childL2['href'] ?>"
								   data-tracking="custom-level-2"><?= $childL2['text'] ?></a>
								<? if ( !empty( $childL2['children'] ) ): ?>
									<?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny', 'pph-local-nav-sub-chevron' ); ?>
									<ul class="pph-local-nav-sub-menu pph-local-nav-l3">
										<? foreach ( $childL2['children'] as $childL3 ): ?>
											<li class="pph-local-nav-tracking pph-local-nav-item-l3">
												<a href="<?= $childL3['href'] ?>"
												   data-tracking="custom-level-3"><?= $childL3['text'] ?></a>
											</li>
										<? endforeach; ?>
									</ul>
								<? endif; ?>
							</li>
						<? endforeach; ?>
					</div>
				</ul>
			<?php endif; ?>
		</li>
	<? endforeach; ?>
	<li class="pph-local-nav-tracking pph-local-nav-item-l1 pph-local-nav-container pph-local-nav-explore">
		<a data-tracking="explore-menu">
			<svg class="wds-icon wds-icon-small" width="18" height="16" viewBox="0 0 18 16"
				 xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd"
					  d="M12.938 0C11.363 0 9.9.45 9 1.237 8.1.45 6.638 0 5.062 0 2.138 0 0 1.462 0 3.375v11.25c0 .675.45 1.125 1.125 1.125s1.125-.45 1.125-1.125c0-.338 1.013-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125 0 .675.45 1.125 1.125 1.125s1.125-.45 1.125-1.125c0-.338 1.012-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125 0 .675.45 1.125 1.125 1.125S18 15.3 18 14.625V3.375C18 1.462 15.863 0 12.937 0zM5.061 11.25a7.37 7.37 0 0 0-2.812.563V3.374c0-.338 1.013-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125v8.438a7.37 7.37 0 0 0-2.813-.563zm10.688.563a7.37 7.37 0 0 0-2.813-.563 7.37 7.37 0 0 0-2.812.563V3.374c0-.338 1.012-1.125 2.813-1.125 1.8 0 2.812.787 2.812 1.125v8.438z"/>
			</svg>
			<?= $explore['text'] ?>
		</a><?= DesignSystemHelper::renderSvg(
			'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny pph-local-nav-chevron'
		) ?>
		<ul class="pph-local-nav-sub-menu pph-local-nav-l2">
			<? foreach ( $explore['children'] as $child ): ?>
				<li class="pph-local-nav-tracking pph-local-nav-item-l2">
					<a href="<?= $child['href'] ?>"
					   data-tracking="<?= $child['tracking'] ?>"><?= $child['text'] ?></a>
				</li>
			<? endforeach; ?>
		</ul>
	</li>
	<? if ( !empty( $discuss ) ): ?>
		<li class="pph-local-nav-tracking pph-local-nav-item-l1 pph-local-nav-discuss pph-local-nav-link">
			<a href="<?= $discuss['href'] ?>" data-tracking="discuss">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-reply',
					'wds-icon wds-icon-small'
				) ?>
				<span class="pph-local-nav-discuss-text"><?= $discuss['text'] ?></span>
			</a>
		</li>
	<? endif; ?>
</ul>
