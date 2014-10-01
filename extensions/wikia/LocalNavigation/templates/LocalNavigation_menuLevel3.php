<ul class="dropdown third">
	<? foreach ($nodes as $i3 => $node3): ?>
		<li>
			<a href="<?= $node3['href']; ?>" data-content="<?= htmlspecialchars( $node3['text'] ); ?>">
				<span><?= $node3['text']; ?></span>
			</a>
		</li>
	<? endforeach; ?>
	<? if ( !empty( $more ) ): ?>
		<li>
			<a href="<?= $more['href']; ?>" data-content="<?= wfMessage('local-navigation-more-of', $more['text'])->escaped(); ?>">
				<span><?= wfMessage('local-navigation-more-of', $more['text'])->parse(); ?></span>
			</a>
		</li>
	<? endif; ?>
</ul>
