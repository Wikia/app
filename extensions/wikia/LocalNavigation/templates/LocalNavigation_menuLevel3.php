<ul class="dropdown third-level-menu">
	<? foreach ($nodes as $i3 => $node3): ?>
		<li class="third-level-row">
			<a href="<?= $node3['href']; ?>" data-content="<?= $node3['textEscaped']; ?>" <?= $node3['canonicalAttr']; ?> title="<?= $node3['textEscaped']; ?>">
				<span><?= $node3['textEscaped']; ?></span>
			</a>
		</li>
	<? endforeach; ?>
	<? if ( !empty( $more ) ):
		$label = wfMessage('local-navigation-more-of', $more['text'])->escaped();
		?>
		<li class="third-level-row">
			<a href="<?= $more['href']; ?>" data-content="<?= $label; ?>" title="<?= $label; ?>">
				<span><?= $label; ?></span>
			</a>
		</li>
	<? endif; ?>
</ul>
