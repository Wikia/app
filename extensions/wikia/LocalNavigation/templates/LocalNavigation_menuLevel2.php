<ul class="dropdown second-level-menu">
	<? foreach ($nodes as $i2 => $node2): ?>
		<li class="local-nav-entry second-level-row">
			<a href="<?= $node2['href']; ?>" data-content="<?= $node2['textEscaped']; ?>" <?= $node2['canonicalAttr']; ?>
			<?if (!empty($node2['children'])): ?>
				class="has-more"
			<? endif ?>
			>
				<span><?= $node2['text']; ?></span>
			</a>
			<? if ( $node2['children'] ): ?>
				<?= $app->renderView('LocalNavigation', 'menuLevel3', [
					'nodes' => $node2['children'],
					'more' => ( $node2['href'] === '#' ? null : ['href' => $node2['href'], 'text' => $node2['text']] ),
				]); ?>
			<? endif; ?>
		</li>
	<? endforeach; ?>
	<? if ( !empty( $more ) ): ?>
		<li class="local-nav-entry second-level-row">
			<a href="<?= $more['href']; ?>" data-content="<?= wfMessage('local-navigation-more-of', $more['text'])->escaped(); ?>">
				<span>
					<?= wfMessage('local-navigation-more-of', $more['text'])->parse(); ?>
				</span>
			</a>
		</li>
	<? endif; ?>
</ul>
