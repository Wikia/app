		<ul class="tabs">
			<li<?= $currentTab === 'main' ? ' class="selected" ' : '' ?>>
				<a href="<?= Skin::makeSpecialUrl( 'Phalanx' ); ?>"><?= wfMessage( 'phalanx-tab-main' )->escaped(); ?></a>
			</li>
			<li<?= $currentTab === 'test' ? ' class="selected" ' : '' ?>>
				<a href="<?= Skin::makeSpecialUrl( 'Phalanx/test' ); ?>"><?= wfMessage( 'phalanx-tab-secondary' )->escaped(); ?></a>
			</li>
		</ul>
