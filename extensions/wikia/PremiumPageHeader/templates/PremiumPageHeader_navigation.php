<ul class="pph-local-nav-menu">
	<? foreach ( $data as $item ) : ?>
		<li class="ppg-local-nav-item-l1">
			<a href="<?= $item['href'] ?>"><?= $item['textEscaped'] ?></a>
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-dropdown-tiny',
				'wds-icon wds-icon-tiny pph-local-nav-chevron'
			) ?>
			<ul class="pph-local-nav-sub-menu pph-local-nav-l2">
				<? foreach ( $item['children'] as $childL2 ): ?>
					<li class="ppg-local-nav-item-l2">
						<a href="<?= $childL2['href'] ?>"><?= $childL2['textEscaped'] ?></a>

						<? if ( !empty( $childL2['children'] ) ): ?>
							<ul class="pph-local-nav-sub-menu pph-local-nav-l3">
								<? foreach ( $childL2['children'] as $childL3 ): ?>
									<li class="ppg-local-nav-item-l3">
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
</ul>
