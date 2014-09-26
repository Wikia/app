<ul class="second dropdown">
	<? foreach ($nodes as $i2 => $node2): ?>
		<li class="local-nav-entry">
			<a href="<?= $node2['href']; ?>" data-content="<?= $node2['text']; ?>"
			<?if (!empty($node2['children'])): ?>
				class="has-more"
			<? endif ?>
			>
				<span><?= $node2['text']; ?></span>
			</a>
			<? if ( $node2['children'] ): ?>
				<?= $app->renderView('LocalNavigation', 'menuLevel3', ['nodes' => $node2['children']]); ?>
			<? endif; ?>
		</li>
	<? endforeach; ?>
</ul>
