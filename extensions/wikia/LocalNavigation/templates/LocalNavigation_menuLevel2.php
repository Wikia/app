<ul class="second dropdown">
	<? foreach ($nodes as $i2 => $node2): ?>
		<li class="local-nav-entry second-level-row">
			<a href="<?= $node2['href']; ?>" data-content="<?= htmlspecialchars( $node2['text'] ); ?>"
			<?if (!empty($node2['children'])): ?>
				class="has-more"
			<? endif ?>
			>
				<span><?= $node2['text']; ?></span>
			</a>
			<? if ( $node2['children'] ): ?>
				<?= $app->renderView('LocalNavigation', 'menuLevel3', [
					'nodes' => $node2['children'],
					'more' => ['href' => $node2['href'], 'text' => $node2['text']]
				]); ?>
			<? endif; ?>
		</li>
	<? endforeach; ?>
	<? if ( $more['href'] !== '#' ): ?>
		<li class="local-nav-entry second-level-row">
			<a href="<?= $more['href']; ?>" data-content="<?= wfMessage('local-navigation-more-of', $more['text'])->escaped(); ?>">
				<span>
					<?= wfMessage('local-navigation-more-of', $more['text'])->parse(); ?>
				</span>
			</a>
		</li>
	<? endif; ?>
</ul>
