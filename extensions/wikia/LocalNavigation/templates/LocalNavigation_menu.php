<nav class="local-nav">
	<div class="local-nav-container">
	<ul class="first-level-menu">
		<? foreach ($menuNodes as $i1 => $node1): ?>
			<li class="local-nav-entry">
				<a href="<?= $node1['href']; ?>" <?= $node1['canonicalAttr']; ?>><?= $node1['textEscaped']; ?></a>
				<? if ( array_key_exists( 'children', $node1 ) ): ?>
					<?= $app->renderView('LocalNavigation', 'menuLevel2', [
						'nodes' => $node1['children'],
						'more' => ( $node1['href'] === '#' ? null : ['href' => $node1['href'], 'text' => $node1['text']] ),
					]); ?>
				<? endif; ?>
			</li>
		<? endforeach; ?>
	</ul>
	</div>
</nav>
