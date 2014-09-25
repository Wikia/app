<ul class="third dropdown">
	<? foreach ($nodes as $i3 => $node3): ?>
		<li>
			<a href="<?= $node3['href']; ?>" data-content="<?= $node3['text']; ?>">
				<span><?= $node3['text']; ?></span>
			</a>
		</li>
	<? endforeach; ?>
</ul>
