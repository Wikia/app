<ul class="dropdown second-level-menu">
	<? foreach ($nodes as $i2 => $node2): ?>
		<li class="local-nav-entry second-level-row">
			<a href="<?= $node2['href']; ?>" data-content="<?= $node2['textEscaped']; ?>" <?= $node2['canonicalAttr']; ?> title="<?= $node2['textEscaped']; ?>"
			<?if (!empty($node2['children'])): ?>
				class="has-more"
			<? endif ?>
			>
				<span><?= $node2['textEscaped']; ?></span>
			</a>
			<? if ( array_key_exists( 'children', $node2 ) ): ?>
				<?= $app->renderView('LocalNavigation', 'menuLevel3', [
					'nodes' => $node2['children'],
					'more' => ( $node2['href'] === '#' ? null : ['href' => $node2['href'], 'text' => $node2['text']] ),
				]); ?>
			<? endif; ?>
		</li>
	<? endforeach; ?>
	<? if ( !empty( $more ) ):
			$label = wfMessage('local-navigation-more-of', $more['text'])->escaped();
		?>
		<li class="local-nav-entry second-level-row">
			<a href="<?= $more['href']; ?>" data-content="<?= $label; ?>" title="<?= $label; ?>">
				<span><?= $label; ?></span>
			</a>
		</li>
	<? endif; ?>
</ul>
