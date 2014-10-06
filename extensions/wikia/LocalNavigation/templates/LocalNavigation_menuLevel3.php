<ul class="dropdown third-level-menu">
	<? foreach ($nodes as $i3 => $node3): ?>
		<li>
			<a href="<?= $node3['href']; ?>" data-content="<?= $node3['textEscaped']; ?>" <?= $node3['canonicalAttr']; ?>>
				<span><?= $node3['text']; ?></span>
			</a>
		</li>
	<? endforeach; ?>
	<? if ( !empty( $more ) ):
		$label = wfMessage('local-navigation-more-of', $more['text']);
		?>
		<li>
			<a href="<?= $more['href']; ?>" data-content="<?= $label->escaped(); ?>">
				<span>
					<?= $label->parse(); ?>
				</span>
			</a>
		</li>
	<? endif; ?>
</ul>
