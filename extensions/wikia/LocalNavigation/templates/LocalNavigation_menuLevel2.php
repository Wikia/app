<ul class="second dropdown">
	<? foreach ($nodes as $i2 => $node2): ?>
		<li>
			<a href="<?= $node2['href']; ?>" data-content="<?= $node2['text']; ?>" class="has-more">
				<span><?= $node2['text']; ?></span>
				<? if (!empty($node2['hasChildren'])): ?>
					<span class="more"></span>
				<? endif ?>
			</a>
			<? if ( $node2['children'] ): ?>
				<?= $app->renderView('LocalNavigation', 'menuLevel3', ['nodes' => $node2['children']]); ?>
			<? endif; ?>
		</li>
	<? endforeach; ?>
</ul>
